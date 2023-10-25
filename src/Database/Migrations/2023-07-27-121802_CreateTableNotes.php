<?php

namespace Adnduweb\Ci4Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableNotes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'company_id' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'type' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'titre' => ['type' => 'VARCHAR', 'constraint' => 255],
            'content' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('notes');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('notes');
    }
}
