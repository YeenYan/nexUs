<?php

namespace App\Http\Controllers\Workspace\Collections;

use Inertia\Response;
use App\Models\Workspace;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\WorkspaceService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class CollectionsController extends Controller
{
    protected $workspaceService;

    public function __construct(WorkspaceService $workspaceService)
    {
        $this->workspaceService = $workspaceService;
    }

    // public function __construct()
    // {

    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Workspace $workspace, Request $request): Response
    {
        $data = $this->workspaceService->getWorkspaceData($workspace);

        // dd($request->view);

        return inertia(
            'Workspace/Collections/Index',
            array_merge(
                $data,
                ['collection_id' => $request->collection_id]
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Workspace $workspace)
    {
        // dd(Workspace::all());

        // Get the current active workspace ID
        $current_workspace_id = $this->workspaceService->getActiveWorkspace()->workspace_id;

        // Validate the request data
        $validateData = $request->validate(
            [
                'collection_name' => 'required|min:4'
            ]
        );

        // Add the current workspace ID to the validated data
        $validateData['workspace_id'] = $current_workspace_id;

        // Create the new collection
        $newCollection = Collection::create($validateData);

        // Get the ID of the newly created collection
        $newCollectionID = $newCollection->collection_id;

        // Retrieve the workspace data (this line seems unused, consider removing it if not needed)
        $data = $this->workspaceService->getWorkspaceData($workspace);

        return redirect()->route('workspace.collections.index', [
            'workspace' => $current_workspace_id,
            'collection_id' => $newCollectionID,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Workspace $workspace, $collection_id): Response
    {
        // dd($this->workspaceService->getSpecificCollections($id));
        // dd($workspace->collections()->where('collection_id', $id));
        // dd($workspace->collections());

        // $workspaceId = 'wp-6ihDCGzeT32OXvCmmgX2Zw';
        // $workspace = Workspace::find($workspaceId);
        // $collections = $workspace->collections()->where('collection_id', $id)->get();
        // // Extract the collection names
        // $collectionNames = $collections->pluck('collection_name');

        // // Display the collection names
        // dd($collections);

        $data = $this->workspaceService->getWorkspaceData($workspace);

        return inertia(
            'Workspace/Collections/Show',
            array_merge(
                $data,
                ['collection_id' => $collection_id],
                // [
                //     'all_collections' => $col
                // ]
            )
        );
    }

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
