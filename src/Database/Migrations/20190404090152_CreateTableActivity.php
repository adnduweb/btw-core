<?php

namespace Btw\Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableActivity extends Migration
{
    public function up()
    {
        // audit logs
        $fields = [
            'event_type' => ['type' => 'varchar', 'constraint' => 255],
            'event_access' => ['type' => 'varchar', 'constraint' => 255],
            'event_method' => ['type' => 'varchar', 'constraint' => 255],
            'source'     => ['type' => 'varchar', 'constraint' => 63],
            'source_id'  => ['type' => 'int', 'unsigned' => true],
            'user_id'    => ['type' => 'int', 'unsigned' => true, 'null' => true],
            'event'      => ['type' => 'varchar', 'constraint' => 31],
            'summary'    => ['type' => 'varchar', 'constraint' => 255],
            'properties'    => ['type' => 'text'],
            'created_at' => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addKey(['source', 'source_id', 'event']);
        $this->forge->addKey(['user_id', 'source', 'event']);
        $this->forge->addKey(['event', 'user_id', 'source', 'source_id']);
        $this->forge->addKey('created_at');

        $this->forge->createTable('activity_log');
    }

    public function down()
    {
        $this->forge->dropTable('activity_log');
    }
}
