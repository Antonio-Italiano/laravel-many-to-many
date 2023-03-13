<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $type_ids = Type::select('id')->pluck('id')->toArray();
        $type_ids[] = null;
        $technology_ids = Technology::select('id')->pluck('id')->toArray();

        for($i = 0; $i < 5; $i++){
            $project = new Project();

            $project->type_id = Arr::random($type_ids);
            $project->title = $faker->text(15);
            $project->description = $faker->paragraphs(2, true);
            // $project->image = "https://picsum.photos/id/" . $faker->numberBetween(1, 50) . "/200";
            $project->slug = Str::slug($project->title, '-');
            $project->url = $faker->url();
            
            $project->save();
            $project_technologies = [];

            foreach($technology_ids as $technology_id){
               if(rand(0, 1)) $project_technologies[] = $technology_id;
            }

            $project->technologies()->attach($project_technologies);
        }
    }
}
