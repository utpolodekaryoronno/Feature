<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $features = DB::table('features')->latest()->get();
        $features = DB::table('features')->latest()->get()->map(function ($feature) {
            $photos = json_decode($feature->photos, true);
            $count = is_array($photos) ? count($photos) : 0;
            $feature->photo_count = $count > 1 ? $count - 1 : 0;
            return $feature;
        });

        return view('features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'feature_name' => 'required | min:3 | max:20',
            'photos' => 'required|array',
            'photos.*' => 'required|mimes:jpeg,png,jpg|max:2024',
        ]);



        $photos = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('uploads/features'), $filename);
                $photos[] = $filename;
            }
        }
        DB::table('features')->insert([
            'feature_name' => $request->feature_name,
            'photos' => json_encode($photos),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Feature added Successful');

    }

    /**
     * Display the specified resource.
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
        $feature = DB::table('features')->where('id', $id)->first();

        if ($feature && $feature->photos) {
            foreach (json_decode($feature->photos) as $photo) {
                $path = public_path('uploads/features/' . $photo);
                if (File::exists($path)) File::delete($path);
            }
        }

        DB::table('features')->where('id', $id)->delete();
        return back()->with('success', 'Feature deleted!');
    }
}


