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
}
