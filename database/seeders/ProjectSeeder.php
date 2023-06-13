<?php

namespace Database\Seeders;

use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {

            $project = new Project();
            $project->title = $faker->sentence(3);
            $project->slug = Str::slug($project->title, '-'); // 👈  Use me to generate a slug
            $project->content = $faker->paragraphs(asText:true);
            $project->url_project = 'placeholders/' . $faker->image('storage/app/public/placeholders/', fullPath:false, category:'Posts', format:'jpg', word:$post->title, gray:true);
            $project->save();
        }
    }
}
