<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserInformation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'uid' => [
                'type' => 'INT',
                'constraint' =>5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'LastName' => [
                'type' => 'TEXT'
            ],
            'FirstName' => [
                'type' => 'TEXT'
            ],
            'phone' => [
                'type' => 'TEXT'
            ],
            'municipality' => [
                'type' => 'TEXT',
            ],
            'barangay' => [
                'type' => 'TEXT',
            ],

        ]);
        $this->forge->addPrimaryKey('uid');
        $this->forge->createTable('user_information');
    }

    public function down()
    {
        $this->forge->dropTable('user_information');
    }
}
