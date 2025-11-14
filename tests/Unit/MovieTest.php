<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run the database seed before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // seeds your favorite movies
    }

    /**
     * Test that a movie can be created and saved.
     */
    public function test_can_create_movie()
    {
        $movie = Movie::create([
            'title' => 'Inception',
            'director' => 'Christopher Nolan',
            'duration' => 148,
            'release_date' => '2010-07-16',
            'description' => 'A mind-bending thriller about dreams within dreams.',
        ]);

        $this->assertDatabaseHas('movies', [
            'title' => 'Inception',
            'director' => 'Christopher Nolan',
        ]);
    }

    /**
     * Test that a movie can be read.
     */
    public function test_can_read_movie()
    {
        $movie = Movie::first();

        $this->assertNotNull($movie);
        $this->assertNotEmpty($movie->title);
    }

    /**
     * Test that a movie can be updated.
     */
    public function test_can_update_movie()
    {
        $movie = Movie::first();
        $movie->update(['title' => 'Updated Title']);

        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => 'Updated Title',
        ]);
    }

    /**
     * Test that a movie can be deleted.
     */
    public function test_can_delete_movie()
    {
        $movie = Movie::first();
        $movieId = $movie->id;

        $movie->delete();

        $this->assertDatabaseMissing('movies', [
            'id' => $movieId,
        ]);
    }

    /**
     * Test that multiple movies can exist and be counted.
     */
    public function test_can_list_movies()
    {
        $movies = Movie::all();

        $this->assertTrue($movies->count() > 0);
    }

    /**
    * Test that a movie can be shown and works as intended.
    */

    public function test_movie_show_page_displays_correct_data()
    {
        $movie = Movie::create([
            'title' => 'The Matrix',
            'director' => 'Lana Wachowski, Lilly Wachowski',
            'description' => 'A computer hacker learns the truth about reality.',
            'release_date' => '1999-03-31',
            'duration' => 136,
            'tags' => 'sci-fi, cyberpunk, action',
        ]);

        $response = $this->get(route('movies.show', $movie->id));

        $response->assertStatus(200)
                 ->assertInertia(fn ($page) => $page
                     ->component('Movies/Show')
                     ->has('movie')
                     ->where('movie.title', 'The Matrix')
                     ->where('movie.director', 'Lana Wachowski, Lilly Wachowski')
                     ->where('movie.tags', 'sci-fi, cyberpunk, action')
                 );
    }

    public function test_movie_show_page_not_found()
    {
        $response = $this->get(route('movies.show', 999));

        $response->assertStatus(404);
    }
}
