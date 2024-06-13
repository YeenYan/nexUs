<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Http\Request;
// use Dotenv\Exception\ValidationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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
        return inertia('Auth/Login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::attempt(
            $request->validate(
                [
                    'email' => 'required|string|email',
                    'password' => 'required'
                ]
            ),
            true
        )) {
            throw ValidationException::withMessages(
                [
                    'all' => 'The provided email or password is incorrect',
                ]
            );
        }

        $request->session()->regenerate();

        // dd(Auth::user()->workspaces);

        // Fetch the user's workspaces
        $userWorkspaces = Auth::user()->workspaces;

        // Filter the workspaces where the active column is 1
        $activeWorkspaces = $userWorkspaces->filter(function ($workspace) {
            return $workspace->active == 1;
        });

        // Get the first active workspace (assuming you want to redirect to the first one found)
        $activeWorkspace = $activeWorkspaces->first();

        // Check if an active workspace was found
        if ($activeWorkspace) {
            // Redirect to the 'dashboard' route with the workspace_id parameter
            return redirect()->route('workspace.dashboard.index', ['workspace' => $activeWorkspace->workspace_id]);
        } else {
            // Handle case where no active workspace was found
            // Redirect to a default route or return an error response
            return redirect()->route(
                'workspace.show',
                ['workspace' => $activeWorkspace->workspace_id]
            );
        }
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
