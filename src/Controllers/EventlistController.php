<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Models\Appointments;
use Vokuro\Models\Operations;
use Vokuro\Models\Operationshifts;

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
            select 'ap' event_kind,
                 a.id event_id,
                 a.label event_label
                ,a.start event_starting
                ,a.end event_ending
            from appointments a
            where a.start < now()
        union all
            select 'op' event_kind
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
