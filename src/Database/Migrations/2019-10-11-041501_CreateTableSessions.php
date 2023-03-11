<?php 

namespace Btw\Core\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableSessions extends Migration
{

	public function up()
	{
		$this->forge->addField([
			'id'         => [
				'type'       => 'VARCHAR',
				'constraint' => 128,
				'null'       => false
			],
			'ip_address' => [
				'type'       => 'VARCHAR',
				'constraint' => 45,
				'null'       => false
			],
			'user_id' => [
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true
			],
			'user_agent' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => false
			],
			'timestamp'  => [
				'type'       => 'TIMESTAMP',
				'null'       => false,
				'default'    => new RawSql('CURRENT_TIMESTAMP')
			],
			'data'       => [
				'type'       => 'TEXT',
				'null'       => false,
				'default'    => ''
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('timestamp');
		$this->forge->createTable('sessions', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('sessions', true);
	}
}

