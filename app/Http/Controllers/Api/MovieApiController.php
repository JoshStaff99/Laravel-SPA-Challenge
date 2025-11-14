<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieApiController extends Controller
{
    /**
     * Display a listing of the movies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $director = $request->query('director');
        $year = $request->query('year');
        $tag = $request->query('tag');

        $perPage = (int) $request->query('per_page', 15);

        $query = Movie::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('director', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        if ($director) {
            $query->where('director', 'like', "%{$director}%");
        }

        if ($year) {
            $query->whereYear('release_date', $year);
        }

        if ($tag) {
            // simple tag matching against comma-separated tags
            $query->where('tags', 'like', "%{$tag}%");
        }

        $movies = $query->orderBy('release_date', 'desc')
                        ->paginate($perPage)
                        ->withQueryString();

        return MovieResource::collection($movies);
    }

    /**
     * Store a newly created movie.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
            // require ISO date (Y-m-d) to avoid invalid dates being inserted into DB
            'release_date' => 'nullable|date_format:Y-m-d',
            'tags' => 'nullable|string',
        ]);

        $movie = Movie::create($validated);
        return new MovieResource($movie); // Return the created movie as a resource
    }

    /**
     * Display the specified movie.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }

    /**
     * Update the specified movie.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
            'release_date' => 'nullable|date',
            'tags' => 'nullable|string',
        ]);

        $movie->update($validated);
        return new MovieResource($movie);
    }

    /**
     * Remove the specified movie from storage.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(null, 204); // Return a 204 No Content response after deletion
    }
}