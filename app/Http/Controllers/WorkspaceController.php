<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use App\Models\Workspace;
use App\Models\Collection;
use App\Models\Workspace_Collab;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\WorkspaceService;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    protected $workspaceService;

    public function __construct(WorkspaceService $workspaceService)
    {
        $this->workspaceService = $workspaceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->workspaceService->redirectToActiveWorkspace();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user): Response
    {
        return inertia(
            'Workspace/Create',
            [
                'user' => $user
            ]
        );
    }

    /**
     * Deactivate the current active workspace and activate the new one.
     */
    public function switchWorkspace(Request $request)
    {
        $userId = Auth::user()->user_id;
        $newWorkspaceId = $request->input('workspace_id');

        // Deactivate the current active workspace
        $this->deactivateCurrentActiveWorkspace($userId);

        // Activate the new workspace
        Workspace::where('workspace_id', $newWorkspaceId)->update(['active' => 1]);

        // Redirect to the new workspace's dashboard
        return redirect()->route('workspace.dashboard.index', ['workspace' => $newWorkspaceId]);
    }

    /**
     * Deactivate the current active workspace of the user
     */
    protected function deactivateCurrentActiveWorkspace($userId)
    {
        Workspace::where('created_by', $userId)
            ->where('active', 1)
            ->update(['active' => 0]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(Auth::user()->username);
        $current_user = Auth::user()->user_id;

        $validatedData = $request->validate(
            [
                'workspace_name' => 'required|min:4',
                'avatar' => 'required|image|mimes:jpg,png,jpeg,webp,svg,svg+xml|max:3000'
            ]
        );

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();


            // Check if the file is an SVG
            if ($extension === 'svg' || $file->getMimeType() === 'image/svg+xml') {
                // Use the original filename for SVG files
                $filename = $file->getClientOriginalName();
            } else {
                $filename = 'wp' . Str::uuid() . '.' . $extension;
            }

            // Store the file in the public storage
            $file->storeAs('avatars/workspace', $filename, 'public');

            // Save only the filename in the database
            $validatedData['avatar'] = $filename;
        }

        // Deactivate the current active workspace
        $this->deactivateCurrentActiveWorkspace($current_user);

        // Set the new workspace as active
        $validatedData['active'] = 1;

        $user = User::find($current_user);

        // Create a new workspace associated with the user who made the request.
        $newWorkspace = $user->workspaces()->create($validatedData);

        // dd($newWorkspace);

        return redirect()->route('workspace.dashboard.index', ['workspace' => $newWorkspace->workspace_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Workspace $workspace)
    {
        return $this->workspaceService->redirectToActiveWorkspace();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
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
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    // }

}
