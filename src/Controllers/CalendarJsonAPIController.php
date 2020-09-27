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
    private function getSchedulesByAppointments($startDate, $endDate, $publicOnly)
    {
        $query = [];
        $conditions = '';
        $builder = Criteria::fromInput($this->getDI(), Appointments::class, $query);
        if (isset($startDate)) {
            $conditions .= (!empty($conditions) ? ' and ' : '' ) . "[start] >= '$startDate'";
            //$builder->conditions('start >= DATE_FORMAT(NOW(),\'%Y-%m-%d 00:00:00\')'); // in the future
        }
        if (isset($endDate)) {
            $conditions .= (!empty($conditions) ? ' and ' : '' ) . "[end] <= '$endDate'";
        }
        if (!empty($conditions)) {
            $builder->conditions($conditions);
        }
        $builder->orderBy("start");

        $appointmentsArr = [];
        $b = $builder->createBuilder();
        $paginator   = new Paginator(
            [
                'builder'   => $b,
                'limit'     => 1000, // max. 1000 appointments ... should never be so much...
                'page'      => $this->request->getQuery('page', 'int', 1),
            ]
        );

        $appointments = $paginator->paginate()->items;

        /**
         * @var Appointments $appointment
         */
        foreach ($appointments as $appointment) {
            $appointmentArr = [];
            $appointmentArr["id"] = $appointment->getId();
            $appointmentArr["title"] = $appointment->getLabel();
            $appointmentArr["start"] = $appointment->getStart();
            if (!empty($appointment->getEnd())) {
                $appointmentArr["end"] = $appointment->getEnd();
            }
            array_push($appointmentsArr, $appointmentArr);
        }
        return $appointmentsArr;
    }

    private function getSchedulesByOperations($startDate, $endDate, $publicOnly)
    {
        // todo: $publicOnly

        $builder = Criteria::fromInput($this->getDI(), Operationshifts::class, $this->request->getQuery());
        $builder->orderBy("start");

        $count = Operationshifts::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operationshifts');
            $this->dispatcher->forward([
                "controller" => "operationshifts",
                'action' => 'index',
            ]);

            return;
        }
        if (!isset($operationshift)) {
            $shortDescription = (Operations::findFirstByid($opId))->shortDescription;
        } else {
            $shortDescription = $operationshift->Operations->shortDescription;
        }
    }




    private function handle_next_element(array $allSchedules, string $marker, string $readableMarker, \ArrayIterator $opIter)
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
        $appointmentSchedules = $this->getSchedulesByAppointments($startDate->format("Y-m-d H:i:s"), $endDate->format("Y-m-d H:i:s"), $publicOnly);
        //$operationSchedules = $this->getSchedulesByOperations($startDate, $endDate, $publicOnly);

        // Example from fullcalendar.io
        $schedule = [
            ["id" => "1",'title' => "All Day Event (public)", "start" => "2020-09-01"],
            ["id" => "2",'title' => "Long Event","start"=> "2020-09-07","end"=> "2020-09-10"],
            ["id" => "999",'title' => "Repeating Event","start"=> "2020-09-09T16:00:00-02:00","end"=> "2020-09-09T17:00:00-02:00"],
            ["id" => "999",'title' => "Repeating Event","start"=> "2020-09-16T16:00:00-02:00","end"=> "2020-09-16T17:00:00-02:00"],
            ["id" => "999",'title' => "Repeating Event","start"=> "2020-09-23T16:00:00-02:00","end"=> "2020-09-23T17:00:00-02:00"],
            ["id" => "3",'title' => "Conference","start"=> "2020-09-11","end"=> "2020-09-13"],
            ["id" => "4",'title' => "Meeting","start"=> "2020-09-12T10:30:00-02:00","end"=> "2020-09-12T12:30:00-02:00"],
            ["id" => "5",'title' => "Conf2","start"=> "2020-10-11","end"=> "2020-10-20"],
        ];

        $operationSchedules = [
            ["id" => "1",'title' => "test2","start"=> "2020-09-16T12:00:00-02:00","end"=> "2020-09-16T13:00:00-02:00"],
            ["id" => "2",'title' => "Sanitätsdienst Oktober-Sportfest","start"=> "2020-10-09","end"=> "2020-10-09"],
            ["id" => "2",'title' => "Frühschicht","start"=> "2020-10-09T07:00:00-02:00","end"=> "2020-10-09T12:30:00-02:00"],
            ["id" => "3",'title' => "Sanitätsdienst Reitturnier","start"=> "2020-10-10"],
            ["id" => "3",'title' => "Frühschicht","start"=> "2020-10-10T09:00:00-02:00","end"=> "2020-10-10T14:30:00-02:00"],
        ];

        // combine applications with operations
        $allSchedules = [];
        $apIter = (new ArrayObject($appointmentSchedules))->getIterator();
        //$apIter = (new ArrayObject($schedule))->getIterator();
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

        $json2 = json_encode($allSchedules);

        $json = '[
                      {
                        "title": "All Day Event",
                        "start": "2020-09-01"
                      },
                      {
                        "title": "Long Event",
                        "start": "2020-09-07",
                        "end": "2020-09-10"
                      },
                      {
                        "id": "999",
                        "title": "Repeating Event",
                        "start": "2020-09-09T16:00:00-05:00"
                      },
                      {
                        "id": "999",
                        "title": "Repeating Event",
                        "start": "2020-09-16T16:00:00-05:00"
                      },
                      {
                        "title": "Conference",
                        "start": "2020-09-11",
                        "end": "2020-09-13"
                      },
                      {
                        "title": "Meeting",
                        "start": "2020-09-12T10:30:00-05:00",
                        "end": "2020-09-12T12:30:00-05:00"
                      },
                      {
                        "title": "Lunch",
                        "start": "2020-09-12T12:00:00-05:00"
                      },
                      {
                        "title": "Meeting",
                        "start": "2020-09-12T14:30:00-05:00"
                      },
                      {
                        "title": "Happy Hour",
                        "start": "2020-09-12T17:30:00-05:00"
                      },
                      {
                        "title": "Dinner",
                        "start": "2020-09-12T20:00:00"
                      },
                      {
                        "title": "Birthday Party",
                        "start": "2020-09-13T07:00:00-05:00"
                      },
                      {
                        "title": "Click for Google",
                        "url": "http://google.com/",
                        "start": "2020-09-28"
                      }
                    ]
                    ';
        return $json2;
    }

    // todo: /calendarapi/v1/get/{startdate}/{enddate}/{timeZone}

    public function getSchedulesAction()
    {
        $query = $this->request->getQuery();
        $timeZone = 'local';
        $publicOnly = !$this->session->has('auth-identity');
        if (isset($query["test"])){
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
