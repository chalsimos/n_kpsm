<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' =>true,
                'constraint' => 5,
                'auto_increment' =>true,
            ],
            'email' =>[
                'type' =>'TEXT',
            ],
            'password' =>[
                'type' =>'TEXT',
            ],
            'token' =>[
                'type' =>'TEXT',
            ],
            'remember_token' =>[
                'type' =>'TEXT',
                'null' =>true
            ],
            'type' => [
                'type' => 'TEXT'
            ],
            'status' =>[
                'type' =>'TEXT',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
