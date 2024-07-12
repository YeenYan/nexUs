<?php

namespace App\Http\Controllers\Workspace\Sections;

use App\Models\Section;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Services\WorkspaceService;
use App\Http\Controllers\Controller;

class SectionsController extends Controller
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
    // public function index()
    // {
    //     //
    // }

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
    public function store(Request $request, Collection $collection)
    {
        $current_collection_id = $request->collection_id;

        // Validate the request data
        $validateData = $request->validate(
            [
                'section_name' => 'required|min:4'
            ]
        );

        // Add the current collection_id to the validated data
        $validateData['collection_id'] = $current_collection_id;

        // Create the new Section
        $newCollection = Section::create($validateData);

        // Get the ID of the newly created section
        $newSectionID = $newCollection->section_id;

        // This is for the Vue Store to update the Current Sections Objects
        $all_collections = $this->workspaceService->getAllSections($current_collection_id);

        return response()->json([
            'current_all_sections' => $all_collections,
            // 'redirect_url' => $redirectUrl,
        ], 200);
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
    public function update(
        Request $request,
        $workspace,
        $collection_id,
        $section
    ) {
        try {
            $section = Section::findOrFail($section);

            $validatedData = $request->validate([
                'section_name' => 'required|string|max:255',
            ]);

            $section->update($validatedData);

            $all_sections = $this->workspaceService->getAllSections($collection_id);

            return response()->json([
                'current_all_sections' => $all_sections,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update section'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        $workspace,
        $collection_id,
        $section_id
    ) {
        //
        $section = Section::find($section_id);

        // Check if the resource exists
        if ($section) {
            // Delete the resource
            $section->delete();

            $all_sections = $this->workspaceService->getAllSections($collection_id);

            return response()->json([
                'current_all_sections' => $all_sections,
            ], 200);

            // Return a success response
            // return response()->json(['message' => 'Resource deleted successfully'], 200);
        } else {
            // Return an error response if the resource was not found
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }
}
