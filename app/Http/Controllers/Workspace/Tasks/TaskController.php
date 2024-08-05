<?php

namespace App\Http\Controllers\Workspace\Tasks;

use Inertia\Response;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\{
    SectionService,
    TaskService
};

class TaskController extends Controller
{
    protected $sectionService;
    protected $taskService;

    public function __construct(SectionService $sectionService, TaskService $taskService)
    {
        $this->sectionService = $sectionService;
        $this->taskService = $taskService;
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
    public function store(Request $request)
    {
        $section_id = $request->section_id;

        // Validate the request data
        $validateData = $request->validate(
            [
                'task_name' => 'required|min:4',
                'priority_type' => 'required',
                'starred' => 'required',
            ],
            [
                'priority_type.required' => 'Please select priority type'
            ]
        );

        // Add the current section_id to the validated data
        $validateData['section_id'] = $section_id;

        // Create the new Task
        $newTask = Task::create($validateData);

        // $all_tasks = $this->sectionService->getTasksList($section_id);

        return response()->json(
            [
                'new_task' => $newTask
            ],
            200
        );
    }

    /**
     * Update the Task Priority Type
     */
    public function update_priority(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id
    ) {
        try {

            $task = Task::findOrFail($task_id);

            $validate_data = $request->validate([
                'priority_type' => 'required'
            ]);

            $task->update($validate_data);

            // $all_tasks = $this->sectionService->getTasksList($section_id);

            return response()->json(
                [
                    'single_task' => $task
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update task priority type'], 500);
        }
    }

    public function update_starred(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id
    ) {
        try {

            $task = Task::findOrFail($task_id);

            $validate_data = $request->validate([
                'starred' => 'required'
            ]);

            $task->update($validate_data);

            $all_tasks = $this->sectionService->getTasksList($section_id);

            return response()->json(
                [
                    'single_task' => $task
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update section'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($workspace_id, $collection_id, $section_id, $task_id)
    {
        $activities = $this->taskService->get_task_activities($task_id);

        return response()->json([
            'activities' => $activities
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_taskName(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id
    ) {
        try {

            $task = Task::findOrFail($task_id);

            $validate_data = $request->validate([
                'task_name' => 'required|min:4'
            ]);

            $task->update($validate_data);

            return response()->json(
                [
                    'updated_task' => $task
                ]
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update task name'], 500);
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
        $section_id,
        $task_id
    ) {
        $task = Task::findOrFail($task_id);

        // Check if the resource exists
        if ($task) {
            // Delete the resource
            $task->delete();

            // return response()->json([
            //     'current_all_sections' => $all_sections,
            // ], 200);
        } else {
            // Return an error response if the resource was not found
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }
}
