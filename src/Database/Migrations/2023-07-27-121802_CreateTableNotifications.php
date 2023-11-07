<?php

namespace Btw\Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableNotifications extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'           => 'INT', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'int', 'unsigned' => true],
            'type_id'  => ['type' => 'int', 'unsigned' => true],
            'title'    => ['type' => 'varchar', 'constraint' => 48],
            'is_read'  => ['type' => 'int', 'unsigned' => true],
            'body'    => ['type' => 'varchar', 'constraint' => 255],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('notify');
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->forge->dropTable('notify');
    }
}
