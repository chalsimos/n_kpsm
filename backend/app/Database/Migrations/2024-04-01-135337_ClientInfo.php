<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ClientInfo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [   
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' =>true,
                'auto_increment' => true
            ],
            'FirstName' =>[
                'type' => 'TEXT',
            ],
            'LastName' => [
                'type' => 'TEXT'
            ],
            'phone' => [
                'type' => 'TEXT'
            ],
            'email' => [
                'type' => 'TEXT'
            ],
            'municipality' => [
                'type' => 'TEXT'
            ],
            'barangay' => [
                'type' =>'TEXT'
            ],
            'sitio' => [
                'type' => 'TEXT',
                'null' => true
            ]
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('clientinfo');
    }

    public function down()
    {
        $this->forge->dropTable('clientinfo');
    }
}
