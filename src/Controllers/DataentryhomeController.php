<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Resultset;
use Vokuro\Models\Appointments;
use Vokuro\Models\Clients;
use Vokuro\Models\Equipment;
use Vokuro\Models\Locations;
use Vokuro\Models\Operations;
use Vokuro\Models\Operationshifts;
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

        $this->view->setVar('appointmentsNextWeekCount', $this->getAppointmentsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('appointmentsNext30DaysCount', $this->getAppointmentsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('appointmentsDoneCount', $this->getAppointmentsCount("[end] <= NOW()"));

        $this->view->setVar('operationsNextWeekCount', $this->getOperationsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('operationsNext30DaysCount', $this->getOperationsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('operationsDoneCount', $this->getOperationsCount("[end] <= NOW()"));

        $this->view->setVar('volunteersCount', $this->getVolunteersCount(""));
        $this->view->setVar('vehiclesCount', $this->getVehiclesCount(""));
        $this->view->setVar('equipmentCount', $this->getEquipmentCount(""));
        $this->view->setVar('equipmentNotOnStockCount', $this->getEquipmentNotOnStockCount("total_count > 0 and isReusable = 'N'"));
        $this->view->setVar('clientsCount', $this->getClientsCount(""));
        $this->view->setVar('locationsCount', $this->getLocationsCount(""));

        $this->view->setVar('nextEvents', $this->getNextEvents());
    }

    private function getCountFrom(array $countColumns, array $fromTables, string $resultColName, string $whereCondition)
    {
        $model = $this
            ->modelsManager
            ->createBuilder()
            ->columns($countColumns)
            ->from($fromTables);
        if (!empty($whereCondition)) {
            $model = $model->where($whereCondition);
        }
        $model = $model->getQuery()
            ->getSingleResult();
        return $model[$resultColName];
    }

    private function getAppointmentsCount(string $whereCondition)
    {
        return $this->getCountFrom(['cnt' => 'COUNT(*) '], ['apo' => Appointments::class], 'cnt', $whereCondition);
    }

    private function getOperationsCount(string $whereCondition)
    {
        $model = $this
            ->modelsManager
            ->createBuilder()
            ->columns(['operationsCount' => 'COUNT(distinct op.id) '])
            ->from(['op' => Operations::class,'opsh' => Operationshifts::class])
            ;
        if (!empty($whereCondition)) {
            $model = $model->where($whereCondition);
        }
        $model = $model->getQuery()
            ->getSingleResult();
        return $model['operationsCount'];
    }


    private function getVolunteersCount(string $whereCondition)
    {
        return $this->getCountFrom(['cnt' => 'COUNT(*) '], ['vol' => Volunteers::class], 'cnt', $whereCondition);
    }

    private function getVehiclesCount(string $whereCondition)
    {
        return $this->getCountFrom(['cnt' => 'COUNT(*) '], ['vehi' => Vehicles::class], 'cnt', $whereCondition);
    }

    private function getEquipmentCount(string $whereCondition)
    {
        return $this->getCountFrom(['cnt' => 'COUNT(*) '], ['eq' => Equipment::class], 'cnt', $whereCondition);
    }

    private function getEquipmentNotOnStockCount(string $whereCondition)
    {
        return $this->getCountFrom(['cnt' => 'COUNT(*) '], ['eq' => Equipment::class], 'cnt', $whereCondition);
    }

    private function getClientsCount(string $whereCondition)
    {
        return $this->getCountFrom(['cnt' => 'COUNT(*) '], ['cl' => Clients::class], 'cnt', $whereCondition);
    }

    private function getLocationsCount(string $whereCondition)
    {
        return $this->getCountFrom(['cnt' => 'COUNT(*) '], ['loc' => Locations::class], 'cnt', $whereCondition);
    }

    private function getNextEvents()
    {
        $rawSQL = "
            select 'ap' event_kind,
                 a.id event_id,
                 a.label event_label
                ,a.start event_starting
                ,a.end event_ending
            from appointments a
            where a.start > now()
        union all
            select 'op' event_kind
                ,op.id event_id
                ,op.shortDescription event_label
                ,min(opsh.start) event_starting
                ,min(opsh.end) event_ending
            from operations op
            inner join vokuro.operationshifts opsh on opsh.operationId = op.id
            where opsh.`start` > now()
            group by op.shortDescription
        order by event_starting#
        limit 5";

        $db             = $this->di['db'];
        $data           = $db->query( $rawSQL );
        //$data->setFetchMode(Db::FETCH_OBJ);
        $results        = $data->fetchAll();




        return $results;
    }
}
