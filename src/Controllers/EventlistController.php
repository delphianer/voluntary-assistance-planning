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


    /**
     * @param int $limit
     * @param int $opid
     * @param Volunteers|null $vol
     * @return mixed
     */
    public function getNextOperationsWithCommitmentFormat(int $limit, $vol)
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
                ,max(opsh.end) event_ending
                ,sum(nvl(
                	(select numberVolunteersNeeded
	                	from operationshifts_departments_link odl
    	            	where odl.operationShiftId = opsh.id),0)) event_volunteersNeeded
                ,sum((select count(*)
                	from operationshifts_departments_link odl
                	join opshdepl_volunteers_link ovl
                		on ovl.opDepNeedId = odl.id
                	where odl.operationShiftId = opsh.id)) event_volunteersCommitted
                ,sum(nvl(
                    (select max(ovl.id)
                        from operationshifts_departments_link odl
                        join opshdepl_volunteers_link ovl
                            on ovl.opDepNeedId = odl.id
                            and ovl.volunteersId = $myID
                        where odl.operationShiftId = opsh.id),0)) event_IHaveCommitted
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


    /**
     * @param int $opid
     * @param Volunteers|null $vol
     * @return mixed
     */
    public function getOperationShiftsWithCommitmentFormat(int $opid, $vol)
    {
        $myID = 0;
        if (isset($vol)) {
            $myID = $vol->getId();
        }

        $rawSQL = "
                select
                    os.id shift_id
                    ,os.shortDescription event_label
                    ,dep.label department_label
                    ,os.`start` event_start
                    ,os.`end` event_end
                    ,odl.id department_need_id
                    ,odl.numberVolunteersNeeded event_needed
                    ,(select count(*)
                        from opshdepl_volunteers_link ovl
                        where ovl.opDepNeedId = odl.id ) event_volunteersCommitted
                    ,(select count(*)
                        from operationshifts_equipment_link osl
                        where os.id = osl.operationShiftId ) event_equipmentcount
                    ,(select count(*)
                        from operationshifts_vehicles_link ovl
                        where os.id = ovl.operationShiftId ) event_vehiclecount
                    ,nvl((select count(*)
                        from opshdepl_volunteers_link ovl
                        where  ovl.opDepNeedId = odl.id
                        and ovl.volunteersId = $myID
                        and odl.operationShiftId = os.id),0) event_IHaveCommitted
                    from operationshifts os
                    inner join operationshifts_departments_link odl on odl.operationShiftId = os.id
                    inner join departments dep on dep.id = odl.departmentId
                    where os.operationId = $opid";

        $db      = $this->di['db'];
        $data    = $db->query($rawSQL);
        $results = $data->fetchAll();

        return $results;
    }






    public function getOneCellFromTable(
        array $columnSelect,
        array $fromTables,
        string $resultColName,
        string $whereCondition,
        array $whereBinding = null
    ) {
        $model = $this
            ->modelsManager
            ->createBuilder()
            ->columns($columnSelect)
            ->from($fromTables);
        if (!empty($whereCondition)) {
            $model = $model->where($whereCondition);
            if (!is_null($whereBinding) && is_array($whereBinding)) {
                $model = $model->setBindParams($whereBinding);
            }
        }
        $model = $model->getQuery();
        $model = $model->getSingleResult();
        return $model[$resultColName];
    }


    public function getAppointmentsCount(string $dateColumn, string $BetweenDateRangeStart, string $BetweenDateRangeEnd)
    {
        $whereCondition = 'apo.['.$dateColumn.'] between :rangeStart: and :rangeEnd:';
        $whereBinding = ['rangeStart' => $BetweenDateRangeStart, 'rangeEnd' => $BetweenDateRangeEnd];
        return $this->getOneCellFromTable(['cnt' => 'COUNT(*) '], ['apo' => Appointments::class], 'cnt', $whereCondition, $whereBinding);
    }

    public function getOperationsCount(string $dateColumn, string $BetweenDateRangeStart, string $BetweenDateRangeEnd)
    {
        $whereCondition = 'opsh.['.$dateColumn.'] between :rangeStart: and :rangeEnd:';
        $whereBinding = ['rangeStart' => $BetweenDateRangeStart, 'rangeEnd' => $BetweenDateRangeEnd];
        return $this->getOneCellFromTable(['operationsCount' => 'COUNT(distinct op.id) '], ['op' => Operations::class,'opsh' => Operationshifts::class], 'operationsCount', $whereCondition, $whereBinding);
    }
}
