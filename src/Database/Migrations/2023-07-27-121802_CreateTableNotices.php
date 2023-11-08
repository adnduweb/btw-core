<?php

namespace Btw\Front\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableNotices extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'company_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'type_id' => ['type' => 'INT', 'constraint' => 11, 'null' => false, 'default' => 1],
            'from' => ['type' => 'DATETIME', 'null' => true],
            'to' => ['type' => 'DATETIME', 'null' => true],
            'active' => ['type' => 'INT', 'constraint' => 11],
            'order' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('notices');


        $this->forge->addField([
            'id_notice_lang' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'notice_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'lang' => ['type' => 'CHAR', 'constraint' => 48],
            'name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description_short' => ['type' => 'TEXT'],
            'description' => ['type' => 'TEXT'],
        ]);

        $this->forge->addPrimaryKey('id_notice_lang');
        $this->forge->addUniqueKey(['lang', 'notice_id'], 'lang_notice_id');
        ;
        $this->forge->addForeignKey('notice_id', 'notices', 'id', false, 'CASCADE');
        $this->forge->createTable('notices_langs', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {

        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable('notice');
        $this->forge->dropTable('notice_langs');

        $this->db->enableForeignKeyChecks();
    }
}
