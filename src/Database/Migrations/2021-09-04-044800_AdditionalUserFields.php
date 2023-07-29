<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdditionalUserFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'company_id' => [
                'type'       => 'int',
                'constraint' => 11,
                'after'      => 'id',
            ],
            'first_name' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'username',
            ],
            'last_name' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'first_name',
            ],
            'avatar' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'last_name',
            ],
            'photo_profile' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'avatar',
            ],
            'main_account' => [
                'type'       => 'int',
                'constraint' => 11,
                'default' => '0',
                'after'      => 'avatar',
            ],
            'email_verified_at' => [
                'type' => 'datetime',
                'after'      => 'photo_profile',
                'null' => false,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['first_name', 'last_name', 'avatar']);
    }
}
