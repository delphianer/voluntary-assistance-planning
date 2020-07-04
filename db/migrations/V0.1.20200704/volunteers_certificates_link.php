<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class VolunteersCertificatesLinkMigration_20209314
 */
class VolunteersCertificatesLinkMigration_20209314 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('volunteers_certificates_link', [
                'columns' => [
                    new Column(
                        'create_time',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "current_timestamp()",
                            'notNull' => true,
                            'first' => true
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
                        'volunteersId',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'update_time'
                        ]
                    ),
                    new Column(
                        'certificatesId',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'volunteersId'
                        ]
                    ),
                    new Column(
                        'validUntil',
                        [
                            'type' => Column::TYPE_DATE,
                            'notNull' => false,
                            'after' => 'certificatesId'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['volunteersId', 'certificatesId'], 'PRIMARY'),
                    new Index('FKVolunteers_idx', ['volunteersId'], ''),
                    new Index('FKCertificates_idx', ['certificatesId'], '')
                ],
                'references' => [
                    new Reference(
                        'FKCertificates',
                        [
                            'referencedTable' => 'certificates',
                            'referencedSchema' => 'vokuro',
                            'columns' => ['certificatesId'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'NO ACTION',
                            'onDelete' => 'NO ACTION'
                        ]
                    ),
                    new Reference(
                        'FKVolunteers',
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
