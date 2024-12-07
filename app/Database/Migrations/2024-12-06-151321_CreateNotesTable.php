<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'varchar',
                'constraint' => 225,
            ],
            'content' => [
                'type'       => 'text',
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'datetime',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'datetime',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('notes');
    }

    public function down()
    {
        $this->forge->dropTable('notes');
    }
}
