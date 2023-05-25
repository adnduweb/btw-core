<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdditionalUserFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
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
            'email_verified_at' => [
                'type' => 'datetime',
                'null' => false,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['first_name', 'last_name', 'avatar']);
    }
}
