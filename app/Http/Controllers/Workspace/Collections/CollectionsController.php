<?php

namespace App\Http\Controllers\Workspace\Collections;

use Inertia\Response;
use App\Models\Workspace;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\{
    WorkspaceService,
    CollectionService
};

class CollectionsController extends Controller
{
    protected $workspaceService;
    protected $collectionService;

    public function __construct(
        WorkspaceService $workspaceService,
        CollectionService $collectionService
    ) {
        $this->workspaceService = $workspaceService;
        $this->collectionService = $collectionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        Workspace $workspace,
        Request $request,
    ): Response {

        $data = $this->workspaceService->getWorkspaceData($workspace);

        $sections_data = $this->collectionService->get_all_sections($request->collection_id);

        $inProgress = $this->collectionService->get_collection_progress($request->collection_id);


        return inertia(
            'Workspace/Collections/Index',
            array_merge(
                $data,
                [
                    'collection_id' => $request->collection_id,
                    'overall_total_activities' => $inProgress['total_activities'],
                    'overall_completed' => $inProgress['completed'],
                    'all_current_sections' => $sections_data
                ]
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

        // dd($all_collections);

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

        // This is for the Vue Store to update the Current Collections Objects
        $all_collections = $this->workspaceService->getAllCollections();

        // Return a JSON response with the newly created collection
        return response()->json([
            'current_collections' => $all_collections,
            'new_collection_id' => $newCollectionID
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Workspace $workspace, $collection_id, Request $request): Response
    // {

    //     $data = $this->workspaceService->getWorkspaceData($workspace);
    //     $sections = $this->workspaceService->getAllSections($request->collection_id);

    //     return inertia(
    //         'Workspace/Collections/Show',
    //         array_merge(
    //             $data,
    //             [
    //                 'collection_id' => $collection_id,
    //                 'all_current_sections' => $sections
    //             ],
    //             // [
    //             //     'all_collections' => $col
    //             // ]
    //         )
    //     );
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
    public function update(Request $request, $workspace, $collection_id)
    {
        try {
            $collection = Collection::findOrFail($collection_id);

            $validatedData = $request->validate([
                'collection_name' => 'required|string|max:255',
                // Add other fields as necessary
            ]);

            $collection->update($validatedData);
        } catch (\Exception $e) {

            // Return an appropriate error response
            return response()->json(['error' => 'Failed to update collection'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $workspace, $collection_id)
    {
        $collection = Collection::findOrFail($collection_id);

        if ($collection) {
            // Delete the resource
            $collection->delete();

            // This is for the Vue Store to update the Current Collections Objects
            $all_collections = $this->workspaceService->getAllCollections();

            // dd($all_collections);

            // Return a JSON response with the newly created collection
            return response()->json([
                'current_collections' => $all_collections,
            ], 200);
        } else {
            // Return an error response if the resource was not found
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }
}
