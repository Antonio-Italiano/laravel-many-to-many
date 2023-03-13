<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = ['FrontEnd', 'BackEnd', 'FullStack'];

        foreach($labels as $label){
            $type = new Type();
            $type->label = $label;
            $type->save();
        }
    }
}
