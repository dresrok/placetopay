<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document_types')->insert([
            ['code' => 'CC', 'description' => 'Cédula de ciudadanía', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'CE', 'description' => 'Cédula de extranjería', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'TI', 'description' => 'Tarjeta de identidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'RC', 'description' => 'Registro Civil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'NIT', 'description' => 'Número de Identificación Tributaria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'RUT', 'description' => 'Registro único tributario', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
