<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

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
        $this->view->setVar('appointmentsNextWeekCount', $this->eventList->getAppointmentsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('appointmentsNext30DaysCount', $this->eventList->getAppointmentsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('appointmentsDoneCount', $this->eventList->getAppointmentsCount("[end] <= NOW()"));

        $this->view->setVar('operationsNextWeekCount', $this->eventList->getOperationsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('operationsNext30DaysCount', $this->eventList->getOperationsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('operationsDoneCount', $this->eventList->getOperationsCount("[end] <= NOW()"));

        $this->view->setVar('volunteersCount', $this->getVolunteersCount(""));
        $this->view->setVar('vehiclesCount', $this->getVehiclesCount(""));
        $this->view->setVar('equipmentCount', $this->getEquipmentCount(""));
        $this->view->setVar('equipmentNotOnStockCount', $this->getEquipmentNotOnStockCount("total_count > 0 and isReusable = 'N'"));
        $this->view->setVar('clientsCount', $this->getClientsCount(""));
        $this->view->setVar('locationsCount', $this->getLocationsCount(""));

        $this->view->setVar('nextEvents', $this->eventList->getNextEventsSimpleFormat(5));

        $this->view->setVar('lastEvents', $this->eventList->getLastEventsSimpleFormat(5));
    }

    private function getVolunteersCount(string $whereCondition)
    {
        return $this->eventList->getSimpleCountFromTable(['cnt' => 'COUNT(*) '], ['vol' => Volunteers::class], 'cnt', $whereCondition);
    }

    private function getVehiclesCount(string $whereCondition)
    {
        return $this->eventList->getSimpleCountFromTable(['cnt' => 'COUNT(*) '], ['vehi' => Vehicles::class], 'cnt', $whereCondition);
    }

    private function getEquipmentCount(string $whereCondition)
    {
        return $this->eventList->getSimpleCountFromTable(['cnt' => 'COUNT(*) '], ['eq' => Equipment::class], 'cnt', $whereCondition);
    }

    private function getEquipmentNotOnStockCount(string $whereCondition)
    {
        return $this->eventList->getSimpleCountFromTable(['cnt' => 'COUNT(*) '], ['eq' => Equipment::class], 'cnt', $whereCondition);
    }

    private function getClientsCount(string $whereCondition)
    {
        return $this->eventList->getSimpleCountFromTable(['cnt' => 'COUNT(*) '], ['cl' => Clients::class], 'cnt', $whereCondition);
    }

    private function getLocationsCount(string $whereCondition)
    {
        return $this->eventList->getSimpleCountFromTable(['cnt' => 'COUNT(*) '], ['loc' => Locations::class], 'cnt', $whereCondition);
    }

}
