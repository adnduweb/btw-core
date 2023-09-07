<?php

namespace Btw\Customer\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCompany extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'BINARY', 'constraint' => 36, 'unique' => true],
            'user_id' => ['type'       => 'INT', 'constraint' => 11, 'null' => true],
            'code_company' => ['type' => 'VARCHAR', 'constraint' => 255],
            'country' => ['type' => 'VARCHAR', 'constraint' => 24, 'default' => 'FR'],
            'state' =>['type' => 'VARCHAR', 'constraint' => 24, 'default' => 0],
            'type_company' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'company' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 0],
            'lastname' => ['type' => 'VARCHAR', 'constraint' => 255],
            'firstname' => ['type' => 'VARCHAR', 'constraint' => 255],
            'address1' => ['type' => 'VARCHAR', 'constraint' => 255],
            'address2' => ['type' => 'VARCHAR', 'constraint' => 255],
            'postcode' => ['type' => 'VARCHAR', 'constraint' => 255],
            'city' => ['type' => 'VARCHAR', 'constraint' => 255],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 255],
            'phone_mobile' => ['type' => 'VARCHAR', 'constraint' => 255],
            'vat_number' => ['type' => 'VARCHAR', 'constraint' => 255],
            'siret' => ['type' => 'VARCHAR', 'constraint' => 128],
            'ape' => ['type' => 'VARCHAR', 'constraint' => 48],
            'logo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null'=> true],
            'active' => ['type' => 'INT', 'constraint' => 11],
            'order' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('companies');

    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('companies');
    }
}