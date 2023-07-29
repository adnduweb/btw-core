<?php

namespace Adnduweb\Ci4Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTaxes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'           => 'INT', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'rate'       => ['type' => 'DECIMAL(20, 3)'],
            'active'     => ['type' => 'INT', 'constraint' => 11],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tax');


        $this->forge->addField([
            'id_tax_lang' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tax_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'lang'         => ['type' => 'CHAR', 'constraint' => 48],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 255]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_tax_lang', true);
        $this->forge->addKey('lang');
        $this->forge->addForeignKey('tax_id', 'tax', 'id', false, 'CASCADE');
        $this->forge->createTable('tax_langs', true);

        $this->forge->addField([
            'id_tax_rules_group' => ['type'           => 'INT', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'active'     => ['type' => 'INT', 'constraint' => 11],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id_tax_rules_group');
        $this->forge->createTable('tax_rules_group');

        $this->forge->addField([
            'id_tax_rule' => ['type'           => 'INT', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'country'       => ['type' => 'VARCHAR', 'constraint' => 48],
            'state'     => ['type' => 'VARCHAR', 'constraint' => 48],
            'id_tax_rules_group'     => ['type' => 'INT', 'constraint' => 11],
            'tax_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id_tax_rule');
        $this->forge->addForeignKey('tax_id', 'tax', 'id', false, 'CASCADE');
        $this->forge->createTable('tax_rules');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('tax');
        $this->forge->dropTable('tax_langs');
        $this->forge->dropTable('tax_rules_group');
        $this->forge->dropTable('tax_rules');
    }
}
