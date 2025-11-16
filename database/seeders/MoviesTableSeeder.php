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
            [
                'title' => 'Star Wars: Episode I The Phantom Menace',
                'description' => 'Jedi warriors Qui-Gon Jinn and Obi-Wan Kenobi are tasked with protecting a princess during a trade dispute between planets. During their mission, they meet a small boy who has the Force within him.',
                'director' => 'George Lucas',
                'release_date' => '1999-07-16',
                'duration' => 134,
                'tags' => 'sci-fi, space opera, action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Star Wars: Episode II Attack of the Clones',
                'description' => 'While pursuing an assassin, Obi Wan uncovers a sinister plot to destroy the Republic. With the fate of the galaxy hanging in the balance, the Jedi must defend the galaxy against the evil Sith.',
                'director' => 'George Lucas',
                'release_date' => '2002-05-16',
                'duration' => 142,
                'tags' => 'sci-fi, space opera, action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Star Wars: Episode III Revenge of the Sith',
                'description' => 'Anakin joins forces with Obi-Wan and sets Palpatine free from the evil clutches of Count Doku. However, he falls prey to Palpatine and the Jedis mind games and gives into temptation.',
                'director' => 'George Lucas',
                'release_date' => '2005-05-19',
                'duration' => 140,
                'tags' => 'sci-fi, space opera, action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Troy',
                'description' => 'Paris, the prince of Troy, convinces the beautiful Helen to leave her husband, King Menelaus, and come with him. But this enrages the king, and he declares war on Troy along with all his allies.',
                'director' => 'Wolfgang Petersen',
                'release_date' => '2004-05-21',
                'duration' => 163,
                'tags' => 'historical, epic, drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tron: Legacy',
                'description' => 'Sam misses his father, a virtual world designer, and enters a virtual space that has become much more dangerous than his father intended. Now, both father and son embark upon a life-and-death journey.',
                'director' => 'Joseph Kosinski',
                'release_date' => '2010-12-17',
                'duration' => 125,
                'tags' => 'sci-fi, action, adventure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kingdom of Heaven',
                'description' => 'Aided by his advisor Tiberias, Crusader Balian learns the true meaning of knighthood. Enlightened, he seeks to establish peace between Jerusalem and the East engaged in the Holy War.',
                'director' => 'Ridley Scott',
                'release_date' => '2005-05-06',
                'duration' => 144,
                'tags' => 'historical, epic, drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Last Samurai',
                'description' => 'An American military officer is ordered to train the first Japanese army in the Western tactics of warfare. However, a samurai tries to stop him from eradicating the traditional fighting techniques.',
                'director' => 'Edward Zwick',
                'release_date' => '2003-12-05',
                'duration' => 154,
                'tags' => 'historical, epic, drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Rocky',
                'description' => 'Rocky Balboa, a small-time boxer, gets a chance to fight heavyweight champion Apollo Creed. In a bid to earn respect and glory, Rocky jumps into the ring, unaware of the tough task ahead of him.',
                'director' => 'John G. Avildsen',
                'release_date' => '1976-11-21',
                'duration' => 119,
                'tags' => 'sports, drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
