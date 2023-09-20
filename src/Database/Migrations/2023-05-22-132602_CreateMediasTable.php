<?php

namespace Btw\Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediasTable extends Migration
{
    public function up()
    {
        // medias
        $fields = [
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'BINARY', 'constraint' => 36, 'unique' => true],
            'disk' => ['type' => 'VARCHAR', 'constraint' => 255],
            'type' => ['type' => 'VARCHAR', 'constraint' => 255],
            'size' => ['type' => 'VARCHAR', 'constraint' => 255],
            'path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'full_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addKey('file_name');
        $this->forge->addKey('created_at');

        $this->forge->createTable('medias');

        // medias Langs
        $fields = [
            'id_media_lang' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'media_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'lang' => ['type' => 'CHAR', 'constraint' => 48],
            'titre' => ['type' => 'VARCHAR', 'constraint' => 255],
            'legend' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255]
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id_media_lang', true);
        $this->forge->addKey('lang');
        $this->forge->addForeignKey('media_id', 'medias', 'id', false, 'CASCADE');
        $this->forge->createTable('medias_langs', true);

        // medias_users
        $fields = [
            'media_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addUniqueKey(['media_id', 'user_id']);
        $this->forge->addUniqueKey(['user_id', 'media_id']);
        // $this->forge->addForeignKey('media_id', 'medias', 'id', false, 'CASCADE');
        // $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');

        $this->forge->createTable('medias_users');

        // downloads
        $fields = [
            'media_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addKey(['media_id', 'user_id']);
        $this->forge->addKey(['user_id', 'media_id']);

        $this->forge->createTable('medias_downloads');
    }

    public function down()
    {
        $this->forge->dropTable('medias');
        $this->forge->dropTable('medias_langs');
        $this->forge->dropTable('medias_users');
        $this->forge->dropTable('medias_downloads');
    }
}
