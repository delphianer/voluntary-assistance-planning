<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class VehiclepropertiesMigration_20209344
 */
class VehiclepropertiesMigration_20209344 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('vehicleproperties', [
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
                        'vehiclesId',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'create_time',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "current_timestamp()",
                            'notNull' => true,
                            'after' => 'vehiclesId'
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
                        'label',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 60,
                            'after' => 'update_time'
                        ]
                    ),
                    new Column(
                        'description',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 5000,
                            'after' => 'label'
                        ]
                    ),
                    new Column(
                        'is_numeric',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "N",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'description'
                        ]
                    ),
                    new Column(
                        'value_string',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 500,
                            'after' => 'is_numeric'
                        ]
                    ),
                    new Column(
                        'value_numeric',
                        [
                            'type' => Column::TYPE_DECIMAL,
                            'notNull' => false,
                            'scale' => 5,
                            'after' => 'value_string'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id', 'vehiclesId'], 'PRIMARY'),
                    new Index('vehiclesId', ['vehiclesId', 'label'], 'UNIQUE'),
                    new Index('FKVehicles_idx', ['vehiclesId'], '')
                ],
                'references' => [
                    new Reference(
                        'FKVehicles',
                        [
                            'referencedTable' => 'vehicles',
                            'referencedSchema' => 'vokuro',
                            'columns' => ['vehiclesId'],
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
