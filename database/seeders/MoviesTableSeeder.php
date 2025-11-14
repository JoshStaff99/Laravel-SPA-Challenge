<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('movies')->insert([
            [
                'title' => 'The Lord of the Rings: The Fellowship of the Ring',
                'description' => 'A ring with mysterious powers lands in the hands of a young hobbit, Frodo. Under the guidance of Gandalf, a wizard, he and his three friends set out on a journey and land in the Elvish kingdom.',
                'director' => 'Peter Jackson',
                'release_date' => '2001-12-10',
                'duration' => 178,
                'tags' => 'fantasy, adventure, epic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Lord of the Rings: The Two Towers',
                'description' => 'Frodo and Sam arrive in Mordor with the help of Gollum. A number of new allies join their former companions to defend Isengard as Saruman launches an assault from his domain.',
                'director' => 'Peter Jackson',
                'release_date' => '2002-12-11',
                'duration' => 179,
                'tags' => 'fantasy, adventure, epic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Lord of the Rings: The Return of the King',
                'description' => 'The former Fellowship of the Ring prepares for the final battle. While Frodo and Sam approach Mount Doom to destroy the One Ring, they follow Gollum, unaware of the path he is leading them on.',
                'director' => 'Peter Jackson',
                'release_date' => '2003-12-17',
                'duration' => 201,
                'tags' => 'fantasy, adventure, epic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gladiator',
                'description' => 'Commodus takes over power and demotes Maximus, one of the preferred generals of his father, Emperor Marcus Aurelius. As a result, Maximus is relegated to fighting till death as a gladiator.',
                'director' => 'Ridley Scott',
                'release_date' => '2000-12-05',
                'duration' => 155,
                'tags' => 'action, historical, drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Matrix',
                'description' => 'A computer hacker learns the truth about reality.',
                'director' => 'Lana Wachowski, Lilly Wachowski',
                'release_date' => '1999-03-31',
                'duration' => 136,
                'tags' => 'sci-fi, cyberpunk, action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
