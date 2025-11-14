<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies with optional filters.
     */
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $director = $request->input('director');
        $year     = $request->input('year');
        $tag      = $request->input('tag');

        // Get the full list of directors and years
        $directors = Movie::select('director')->distinct()->pluck('director');
        $years = Movie::selectRaw('YEAR(release_date) as year')->distinct()->pluck('year')->sortDesc();

        // Query the movies based on the filters
        $movies = Movie::query()
            ->when($search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('director', 'like', "%{$search}%")
                        ->orWhere('tags', 'like', "%{$search}%");
                });
            })
            ->when($director, function ($q, $director) {
                $q->where('director', 'like', "%{$director}%");
            })
            ->when($year, function ($q, $year) {
                $q->whereYear('release_date', $year);
            })
            ->when($tag, function ($q, $tag) {
                $q->where('tags', 'like', "%{$tag}%");
            })
            ->orderBy('release_date', 'desc')
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('Movies/Index', [
            'movies'    => $movies,
            'filters'   => [
                'search'   => $search,
                'director' => $director,
                'year'     => $year,
                'tag'      => $tag,
            ],
            'directors' => $directors, // Send directors to frontend
            'years'     => $years,     // Send years to frontend
        ]);
    }

    /**
     * Show the form to create a new movie
     */
    public function create()
    {
        return Inertia::render('Movies/Create');
    }

    /**
     * Store a new movie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
            'release_date' => 'nullable|date',
            'tags' => 'nullable|string',
        ]);

        Movie::create($validated);

        return redirect()->route('movies.index')->with('success', 'Movie added!');
    }

    /**
     * Show a single movie detail page
     */
    public function show(Movie $movie)
    {
        return Inertia::render('Movies/Show', ['movie' => $movie]);
    }

    /**
     * Show edit form
     */
    public function edit(Movie $movie)
    {
        return Inertia::render('Movies/Edit', ['movie' => $movie]);
    }

    /**
     * Update a movie
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

        return redirect()->route('movies.index')->with('success', 'Movie updated!');
    }

    /**
     * Delete a movie
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Movie deleted!');
    }
}
