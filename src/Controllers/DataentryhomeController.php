<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Vokuro\Models\Clients;
use Vokuro\Models\Equipment;
use Vokuro\Models\Locations;
use Vokuro\Models\Vehicles;
use Vokuro\Models\Volunteers;

/**
 * Display the "Data Entry Home" page.
 */
class DataentryhomeController extends ControllerBase
{
    /**
     * @var  EventlistController
     */
    private $eventList = null;

    /**
     * initialize this Controller
     */
    public function initialize()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    public function indexAction()
    {
        $this->view->setVar('extraTitle', "Data Entry Overview");

        $this->eventList = new EventlistController();
        $this->view->setVar('appointmentsNextWeekCount', $this->eventList->getAppointmentsCount('start', date('Y-m-d'), date('Y-m-d', strtotime('+7 DAY'))));
        $this->view->setVar('appointmentsNext30DaysCount', $this->eventList->getAppointmentsCount('start', date('Y-m-d'), date('Y-m-d', strtotime('+30 DAY'))));
        $this->view->setVar('appointmentsDoneCount', $this->eventList->getAppointmentsCount("end", date('Y-m-d', strtotime('-365 DAY')), date('Y-m-d')));

        $this->view->setVar('operationsNextWeekCount', $this->eventList->getOperationsCount('start', date('Y-m-d'), date('Y-m-d', strtotime('+7 DAY'))));
        $this->view->setVar('operationsNext30DaysCount', $this->eventList->getOperationsCount('start', date('Y-m-d'), date('Y-m-d', strtotime('+30 DAY'))));
        $this->view->setVar('operationsDoneCount', $this->eventList->getOperationsCount("end", date('Y-m-d', strtotime('-365 DAY')), date('Y-m-d')));

        $this->view->setVar('volunteersCount', $this->getVolunteersCount(""));
        $this->view->setVar('volunteersWithoutCertification', $this->getVolunteersWithoutCertificationCount());

        $this->view->setVar('vehiclesCount', $this->getVehiclesCount(""));
        $this->view->setVar('vehiclesInspectionAhead', $this->getVehiclesCountWithInspectionAhead(30));

        $this->view->setVar('equipmentCount', $this->getEquipmentCount(""));
        $this->view->setVar('equipmentNotOnStockCount', $this->getEquipmentNotOnStockCount("total_count > 0 and isReusable = 'N'"));

        $this->view->setVar('clientsCount', $this->getClientsCount(""));
        $this->view->setVar('locationsCount', $this->getLocationsCount(""));

        $this->view->setVar('nextEvents', $this->eventList->getNextEventsSimpleFormat(5));

        $this->view->setVar('lastEvents', $this->eventList->getLastEventsSimpleFormat(5));
    }

    private function getVolunteersCount(string $whereCondition)
    {
        return $this->eventList->getOneCellFromTable(['cnt' => 'COUNT(*) '], ['vol' => Volunteers::class], 'cnt', $whereCondition);
    }

    private function getVolunteersWithoutCertificationCount()
    {
        /**
         *  @var Criteria $model
         */
        $model = Volunteers::query()
            ->leftJoin('Vokuro\Models\VolunteersCertificatesLink', 'Vokuro\Models\VolunteersCertificatesLink.volunteersId = \Vokuro\Models\Volunteers.id')
            ->andWhere('Vokuro\Models\VolunteersCertificatesLink.validUntil < NOW()')
            ->orWhere('Vokuro\Models\VolunteersCertificatesLink.id IS NULL')
            ->execute();
        return sizeof($model);
    }

    private function getVehiclesCount(string $whereCondition)
    {
        return $this->eventList->getOneCellFromTable(['cnt' => 'COUNT(*) '], ['vehi' => Vehicles::class], 'cnt', $whereCondition);
    }


    private function getVehiclesCountWithInspectionAhead(int $daysAhead)
    {
        return $this->eventList->getOneCellFromTable(
            ['cnt' => 'COUNT(*) '], // $columnSelect
            ['vehi' => Vehicles::class], // $fromTables
            'cnt', // $resultColName
            "vehi.[technicalInspection] < '".date('Y-m-d', strtotime('+'.$daysAhead.' DAY'))."'" // $whereCondition
        );
    }

    private function getEquipmentCount(string $whereCondition)
    {
        return $this->eventList->getOneCellFromTable(['cnt' => 'COUNT(*) '], ['eq' => Equipment::class], 'cnt', $whereCondition);
    }

    private function getEquipmentNotOnStockCount(string $whereCondition)
    {
        return $this->eventList->getOneCellFromTable(['cnt' => 'COUNT(*) '], ['eq' => Equipment::class], 'cnt', $whereCondition);
    }

    private function getClientsCount(string $whereCondition)
    {
        return $this->eventList->getOneCellFromTable(['cnt' => 'COUNT(*) '], ['cl' => Clients::class], 'cnt', $whereCondition);
    }

    private function getLocationsCount(string $whereCondition)
    {
        return $this->eventList->getOneCellFromTable(['cnt' => 'COUNT(*) '], ['loc' => Locations::class], 'cnt', $whereCondition);
    }
}
