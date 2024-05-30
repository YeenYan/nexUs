<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return inertia('UserAccount/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->hasFile('avatar'));

        $validatedData = $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'avatar' => 'required|image|mimes:jpg,png,jpeg,webp,svg,svg+xml|max:5000'
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();


            // Check if the file is an SVG
            if ($extension === 'svg' || $file->getMimeType() === 'image/svg+xml') {
                // Use the original filename for SVG files
                $filename = $file->getClientOriginalName();
            } else {
                $filename = Str::slug($request->username) . '-' . Str::uuid() . '.' . $extension;
            }


            // Store the file in the public storage
            $file->storeAs('avatars', $filename, 'public');

            // Save only the filename in the database
            $validatedData['avatar'] = $filename;
        }

        $user = User::create($validatedData);

        Auth::login($user);

        // return with('success', 'Account Created');
        return redirect()->route('workspace.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
