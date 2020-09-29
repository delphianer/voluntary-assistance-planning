<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use ArrayObject;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use DateTime;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Models\Appointments;
use Vokuro\Models\Operations;
use Vokuro\Models\Operationshifts;

class CalendarJsonAPIController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
    }


    // test: http://localhost/calendarapi/v1/get/?start=2020-08-30T00:00:00+02:00&end=2020-10-30T00:00:00+02:00&test=1
    // todo: $publicOnly
    // todo: decide getAppointmentsInDateRange as Function of model with daterange and options like public only?
    //       then: here only limit and pagination... OR: limit and pagination in Controller-function with params and
    //             here only convertation into array for json encoding...
    /**
     * @param $class
     * @param $startDate
     * @param $endDate
     * @param $publicOnly
     * @return array
     */
    private function getSchedulesBy($class, $startDate, $endDate, $publicOnly)
    {
        $conditions = '';
        $builder = Criteria::fromInput($this->getDI(), $class, []);
        if (isset($startDate)) {
            $conditions .= (!empty($conditions) ? ' and ' : '' ) . "[start] >= '$startDate'";
        }
        if (isset($endDate)) {
            $conditions .= (!empty($conditions) ? ' and ' : '' ) . "[end] <= '$endDate'";
        }
        if (!empty($conditions)) {
            $builder->conditions($conditions);
        }
        $builder->orderBy("start");

        $b = $builder->createBuilder();
        $paginator   = new Paginator(
            [
                'builder'   => $b,
                'limit'     => 10000,
                'page'      => 1,//$this->request->getQuery('page', 'int', 1),
            ]
        );

        $items = $paginator->paginate()->items;

        $resultArr = [];
        foreach ($items as $appointmentOrOperation) {
            $appointmentOrOperationArr = [];
            $appointmentOrOperationArr["id"] = $appointmentOrOperation->getId();
            if ($class == Appointments::class) {
                $appointmentOrOperationArr["title"] = $appointmentOrOperation->getLabel();
            } else { // operation
                $appointmentOrOperationArr["title"] = $appointmentOrOperation->getShortDescription();
            }
            $appointmentOrOperationArr["start"] = $appointmentOrOperation->getStart();
            if (!empty($appointmentOrOperation->getEnd())) {
                $appointmentOrOperationArr["end"] = $appointmentOrOperation->getEnd();
            }
            array_push($resultArr, $appointmentOrOperationArr);
        }
        return $resultArr;
    }


    /**
     * @param array $allSchedules
     * @param string $marker
     * @param string $readableMarker
     * @param \ArrayIterator $opIter
     * @return array
     */
    private function handle_next_element(array $allSchedules, string $marker, string $readableMarker, \ArrayIterator $opIter): array
    {
        $current =  $opIter->current();
        if (isset($current["id"])) {
            $current["id"] =  $marker . ':' . $current["id"];
        }
        if (isset($current["title"])) {
            $current["title"] =  $readableMarker . ': ' . $current["title"];
        }
        array_push($allSchedules, $current);
        $opIter->next();

        return $allSchedules;
    }


    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param $timezone
     * @param $publicOnly
     * @return false|string
     */
    private function getResonseJsonFromDates($startDate, $endDate, $timezone, $publicOnly)
    {
        $appointmentSchedules = $this->getSchedulesBy(Appointments::class, $startDate->format("Y-m-d H:i:s"), $endDate->format("Y-m-d H:i:s"), $publicOnly);
            //$this->getSchedulesByAppointments($startDate->format("Y-m-d H:i:s"), $endDate->format("Y-m-d H:i:s"), $publicOnly);
        $operationSchedules = $this->getSchedulesBy(Operationshifts::class, $startDate->format("Y-m-d H:i:s"), $endDate->format("Y-m-d H:i:s"), $publicOnly);

        // combine applications with operations
        $allSchedules = [];
        $apIter = (new ArrayObject($appointmentSchedules))->getIterator();
        $opIter = (new ArrayObject($operationSchedules))->getIterator();

        while ($apIter->valid() || $opIter->valid()) {
            if (!$apIter->valid()) {
                $allSchedules = $this->handle_next_element($allSchedules, 'op', 'Op', $opIter);
            } elseif (!$opIter->valid()) {
                $allSchedules = $this->handle_next_element($allSchedules, 'ap', 'Ap', $apIter);
            } else { // both valid
                if ($apIter->current()['start'] < $opIter->current()['start']) {
                    $allSchedules = $this->handle_next_element($allSchedules, 'ap', 'Ap', $apIter);
                } else {
                    $allSchedules = $this->handle_next_element($allSchedules, 'op', 'Op', $opIter);
                }
            }
        }

        return json_encode($allSchedules);
    }

    // todo: /calendarapi/v1/get/{startdate}/{enddate}/{timeZone}

    public function getSchedulesAction()
    {
        $query = $this->request->getQuery();
        $timeZone = 'local';
        $publicOnly = !$this->session->has('auth-identity');
        if (isset($query["test"])) {
            $query["start"] = str_replace(' ', '+', $query["start"]);
            $query["end"]= str_replace(' ', '+', $query["end"]);
        }

        // todo: datetime thing...
        if (isset($query["start"])) {
            $start = DateTime::createFromFormat(DATE_ATOM, $query["start"]);
        } else {
            $start = new DateTime('first day of this month');
        }
        if (isset($query["end"])) {
            $end = DateTime::createFromFormat(DATE_ATOM, $query["end"]);
        } else {
            $end = new DateTime('last day of this month');
        }

        if ($this->session->has('auth-identity')) {
            $publicOnly = false;
        }

        $json = $this->getResonseJsonFromDates($start, $end, $timeZone, $publicOnly);

        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');

        echo $json;

        return;
    }
}
