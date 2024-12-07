<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class NoteSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('notes')->insertBatch($data);
    }
}

