<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class OpshdeplVolunteersLinkMigration_20209344
 */
class OpshdeplVolunteersLinkMigration_20209344 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('opshdepl_volunteers_link', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'create_time',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "current_timestamp()",
                            'notNull' => true,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'update_time',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "current_timestamp()",
                            'notNull' => true,
                            'after' => 'create_time'
                        ]
                    ),
                    new Column(
                        'shortDescription',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 60,
                            'after' => 'update_time'
                        ]
                    ),
                    new Column(
                        'longDescription',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 5000,
                            'after' => 'shortDescription'
                        ]
                    ),
                    new Column(
                        'opDepNeedId',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'longDescription'
                        ]
                    ),
                    new Column(
                        'volunteersId',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'opDepNeedId'
                        ]
                    ),
                    new Column(
                        'volCurrentMaximumCertRank',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'volunteersId'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('FKODLOVoLODL_idx', ['opDepNeedId'], ''),
                    new Index('FKOpDepLVounteers_idx', ['volunteersId'], '')
                ],
                'references' => [
                    new Reference(
                        'FKOpDepLOVoLODL',
                        [
                            'referencedTable' => 'operationshifts_departments_link',
                            'referencedSchema' => 'vokuro',
                            'columns' => ['opDepNeedId'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'NO ACTION',
                            'onDelete' => 'NO ACTION'
                        ]
                    ),
                    new Reference(
                        'FKOpDepLVounteers',
                        [
                            'referencedTable' => 'volunteers',
                            'referencedSchema' => 'vokuro',
                            'columns' => ['volunteersId'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'NO ACTION',
                            'onDelete' => 'NO ACTION'
                        ]
                    )
                ],
                'options' => [
                    'table_type' => 'BASE TABLE',
                    'auto_increment' => '',
                    'engine' => 'InnoDB',
                    'table_collation' => 'utf8mb4_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
