<?php

namespace Btw\Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCurrencies extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'           => 'INT', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'code'    => ['type' => 'varchar', 'constraint' => 48],
            'name'    => ['type' => 'varchar', 'constraint' => 48],
            'symbol'    => ['type' => 'varchar', 'constraint' => 48],
            'placement'    => ['type' => 'varchar', 'constraint' => 48],
            'decimal'    => ['type' => 'varchar', 'constraint' => 48],
            'thousands'    => ['type' => 'varchar', 'constraint' => 48],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('currencies');
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->forge->dropTable('currencies');
    }
}
