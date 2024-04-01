<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Request extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user' => [
                'type' => 'TEXT'
            ],
            'request_type' => [
                'type' => 'TEXT'
            ],
            'status' => [
                'type' =>'TEXT'
            ]
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('request');
    }

    public function down()
    {
        $this->forge->dropTable('request');
    }
}