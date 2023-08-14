<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Auth;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return response()->json($movies);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'rating' => 'required|numeric|min:0|max:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movie = new Movie;
        $movie->title = $validatedData['title'];
        $movie->description = $validatedData['description'];
        $movie->rating = $validatedData['rating'];

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imagePath = 'image';

            // Check if the directory exists, create it if not
            if (!Storage::exists($imagePath)) {
                Storage::makeDirectory($imagePath);
            }

            $movie->image = $imageFile->store($imagePath);
        } else {
            return response()->json(['error' => 'Image file is missing'], 400);
        }

        $movie->save();

        return response()->json($movie, 201);
    }

    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json($movie);
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'rating' => 'required|numeric|min:0|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movie->title = $validatedData['title'];
        $movie->description = $validatedData['description'];
        $movie->rating = $validatedData['rating'];

        if ($request->hasFile('image')) {
            Storage::delete($movie->image);
            $movie->image = $request->file('image')->store('image');
        }

        $movie->save();

        return response()->json($movie);
    }

    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        Storage::delete($movie->image);
        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
}
