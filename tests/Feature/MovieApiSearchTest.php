<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieApiSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prevent database seeding during tests
     */
    protected $seed = false;

    /**
     * Override setUp to prevent seeding
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Do not seed the database
    }

    public function test_search_returns_expected_movie()
    {
        Movie::create([
            'title' => 'The Matrix',
            'director' => 'Lana Wachowski, Lilly Wachowski',
            'description' => 'A computer hacker learns the truth about reality.',
            'release_date' => '1999-03-31',
            'duration' => 136,
            'tags' => 'sci-fi, cyberpunk, action',
        ]);

        Movie::create([
            'title' => 'Some Other Movie',
            'director' => 'Someone Else',
            'description' => 'Not relevant',
            'release_date' => '2020-01-01',
            'duration' => 90,
            'tags' => 'drama',
        ]);

        $response = $this->getJson('/api/movies?search=Matrix');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data'])
                 ->assertJsonFragment(['title' => 'The Matrix']);
    }

    public function test_pagination_returns_meta_and_links()
    {
        // create 12 movies
        for ($i = 1; $i <= 12; $i++) {
            Movie::create([
                'title' => "Pagination Test Movie {$i}",
                'director' => 'Director',
                'description' => 'Description',
                'release_date' => now()->subDays($i)->toDateString(),
                'duration' => 100 + $i,
                'tags' => 'pagination-test',
            ]);
        }

        $response = $this->getJson('/api/movies?tag=pagination-test&per_page=5');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'links', 'meta'])
                 ->assertJsonPath('meta.per_page', 5)
                 ->assertJsonPath('meta.total', 12)
                 ->assertJsonCount(5, 'data');
    }

    public function test_filter_by_tag_returns_matching_movies()
    {
        Movie::create([
            'title' => 'Sci-Fi Movie 1',
            'director' => 'Director A',
            'description' => 'A sci-fi film',
            'release_date' => '2020-01-01',
            'duration' => 120,
            'tags' => 'test-sci-fi, cyberpunk, action',
        ]);

        Movie::create([
            'title' => 'Drama Movie',
            'director' => 'Director B',
            'description' => 'A drama film',
            'release_date' => '2021-01-01',
            'duration' => 110,
            'tags' => 'drama, emotional',
        ]);

        Movie::create([
            'title' => 'Another Sci-Fi',
            'director' => 'Director C',
            'description' => 'Another sci-fi film',
            'release_date' => '2022-01-01',
            'duration' => 100,
            'tags' => 'test-sci-fi, space',
        ]);

        $response = $this->getJson('/api/movies?tag=test-sci-fi');

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data')
                 ->assertJsonFragment(['title' => 'Another Sci-Fi'])
                 ->assertJsonFragment(['title' => 'Sci-Fi Movie 1']);
    }

    public function test_filter_by_director_returns_matching_movies()
    {
        Movie::create([
            'title' => 'Film 1',
            'director' => 'Test Director XYZ',
            'description' => 'Description',
            'release_date' => '2020-01-01',
            'duration' => 120,
            'tags' => 'fantasy',
        ]);

        Movie::create([
            'title' => 'Film 2',
            'director' => 'Test Director XYZ',
            'description' => 'Description',
            'release_date' => '2021-01-01',
            'duration' => 130,
            'tags' => 'fantasy',
        ]);

        Movie::create([
            'title' => 'Film 3',
            'director' => 'Someone Else Completely',
            'description' => 'Description',
            'release_date' => '2022-01-01',
            'duration' => 100,
            'tags' => 'drama',
        ]);

        $response = $this->getJson('/api/movies?director=Test%20Director%20XYZ');

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data')
                 ->assertJsonFragment(['director' => 'Test Director XYZ']);
    }

    public function test_filter_by_year_returns_matching_movies()
    {
        Movie::create([
            'title' => 'Movie Year Test 2020',
            'director' => 'Director',
            'description' => 'Description',
            'release_date' => '2020-06-15',
            'duration' => 120,
            'tags' => 'year-test',
        ]);

        Movie::create([
            'title' => 'Movie Year Test 2021',
            'director' => 'Director',
            'description' => 'Description',
            'release_date' => '2021-03-20',
            'duration' => 110,
            'tags' => 'year-test',
        ]);

        $response = $this->getJson('/api/movies?year=2020');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonPath('data.0.title', 'Movie Year Test 2020');
    }

    public function test_combined_search_and_filters()
    {
        Movie::create([
            'title' => 'The Matrix',
            'director' => 'Lana Wachowski',
            'description' => 'A computer hacker learns the truth about reality.',
            'release_date' => '1999-03-31',
            'duration' => 136,
            'tags' => 'sci-fi, cyberpunk, action',
        ]);

        Movie::create([
            'title' => 'Inception',
            'director' => 'Christopher Nolan',
            'description' => 'A skilled thief who steals corporate secrets.',
            'release_date' => '2010-07-16',
            'duration' => 148,
            'tags' => 'sci-fi, thriller',
        ]);

        $response = $this->getJson('/api/movies?search=Wachowski&tag=sci-fi');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonPath('data.0.title', 'The Matrix');
    }
}
