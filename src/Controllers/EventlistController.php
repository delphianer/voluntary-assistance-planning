<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Models\Appointments;
use Vokuro\Models\Operations;
use Vokuro\Models\Operationshifts;
use Vokuro\Models\Volunteers;

/**
 * This controller just helps out doing the event-lists :)
 *
 * Class EventlistController
 * @package Vokuro\Controllers
 */
class EventlistController extends ControllerBase
{
    public function getNextEventsSimpleFormat(int $limit)
    {
        $rawSQL = "
            select 'appointments' event_kind,
                 a.id event_id,
                 a.label event_label
                ,a.start event_starting
                ,a.end event_ending
            from appointments a
            where a.start > now()
        union all
            select 'operations' event_kind
                ,op.id event_id
                ,op.shortDescription event_label
                ,min(opsh.start) event_starting
                ,min(opsh.end) event_ending
            from operations op
            inner join vokuro.operationshifts opsh on opsh.operationId = op.id
            where opsh.`start` > now()
            group by op.shortDescription
        order by event_starting
        limit $limit";

        $db      = $this->di['db'];
        $data    = $db->query($rawSQL);
        $results = $data->fetchAll();

        return $results;
    }


    public function getLastEventsSimpleFormat(int $limit)
    {
        $rawSQL = "
            select 'appointments' event_kind,
                 a.id event_id,
                 a.label event_label
                ,a.start event_starting
                ,a.end event_ending
            from appointments a
            where a.start < now()
        union all
            select 'operations' event_kind
                ,op.id event_id
                ,op.shortDescription event_label
                ,min(opsh.start) event_starting
                ,min(opsh.end) event_ending
            from operations op
            inner join vokuro.operationshifts opsh on opsh.operationId = op.id
            where opsh.`start` < now()
            group by op.shortDescription
        order by event_ending desc
        limit $limit";

        $db      = $this->di['db'];
        $data    = $db->query($rawSQL);
        $results = $data->fetchAll();

        return $results;
    }



    public function getNextOperationsWithCommitmentFormat(int $limit, Volunteers $vol)
    {
        $myID = 0;
        if (isset($vol)) {
            $myID = $vol->getId();
        }

        $rawSQL = "
            select 'operations' event_kind
                ,op.id event_id
                ,op.shortDescription event_label
                ,min(opsh.start) event_starting
                ,min(opsh.end) event_ending
                ,nvl(
                	(select numberVolunteersNeeded
	                	from operationshifts_departments_link odl
    	            	where odl.operationShiftId = opsh.id),0) event_volunteersNeeded
                ,(select count(*)
                	from operationshifts_departments_link odl
                	join opshdepl_volunteers_link ovl
                		on ovl.opDepNeedId = odl.id
                	where odl.operationShiftId = opsh.id) event_volunteersCommitted
                ,nvl(
                    (select max(ovl.id)
                        from operationshifts_departments_link odl
                        join opshdepl_volunteers_link ovl
                            on ovl.opDepNeedId = odl.id
                            and ovl.volunteersId = $myID
                        where odl.operationShiftId = opsh.id),0) event_IHaveCommitted
            from operations op
            inner join vokuro.operationshifts opsh on opsh.operationId = op.id
            where opsh.`start` > now()
            group by op.shortDescription
            order by event_starting
            limit $limit";

        $db      = $this->di['db'];
        $data    = $db->query($rawSQL);
        $results = $data->fetchAll();

        return $results;
    }





    public function getSimpleCountFromTable(array $countColumns, array $fromTables, string $resultColName, string $whereCondition)
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


    public function getAppointmentsCount(string $whereCondition)
    {
        return $this->getSimpleCountFromTable(['cnt' => 'COUNT(*) '], ['apo' => Appointments::class], 'cnt', $whereCondition);
    }

    public function getOperationsCount(string $whereCondition)
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
}
