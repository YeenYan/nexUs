<?php

namespace App\Http\Controllers\Workspace\Activity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\{
    Task,
    Activity
};
use App\Services\{
    TaskService
};

class ActivityController extends Controller
{
    protected $taskService;

    public function __construct(
        TaskService $taskService
    ) {
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
        $task_id = $request->task_id;

        $validateData = $request->validate(
            [
                'activity_name' => 'required|min:4',
                'status_type' => 'required',
                'priority_type' => 'required',
                'due_date' => 'required',
                'description' => 'required|min:10'
            ],
            [
                'status_type.required' => 'Please select a status type',
                'priority_type' => 'Please select priority type'
            ]
        );

        $validateData['task_id'] = $task_id;

        $new_activity = Activity::create($validateData);

        // Fetch Specific Task
        $task = Task::findOrFail($task_id);
        $task['total_activities'] = $this->taskService->count_task_activities($task_id);
        $task['completed_activities'] = $task->activities()->where('status_type', 2)->count();

        return response()->json(
            [
                'new_activity' => $new_activity,
                'single_task' => $task
            ],
            200
        );
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

    public function update_activity_name(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id,
        $activity_id
    ) {
        try {
            $activity = Activity::findOrFail($activity_id);

            $validate_data = $request->validate([
                'activity_name' => 'required|min:5'
            ]);

            $activity->update($validate_data);

            return response()->json(
                [
                    'updated_activity' => $activity
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to update activity name'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_priority(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id,
        $activity_id
    ) {
        try {
            $activity = Activity::findOrFail($activity_id);

            $validate_data = $request->validate([
                'priority_type' => 'required'
            ]);

            $activity->update($validate_data);

            return response()->json(
                [
                    'updated_activity' => $activity
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to update activity priority type'], 500);
        }
    }


    /**
     * Summary of update_status
     * @param \Illuminate\Http\Request $request
     * @param mixed $workspace
     * @param mixed $collection_id
     * @param mixed $section_id
     * @param mixed $task_id
     * @param mixed $activity_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update_status(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id,
        $activity_id
    ) {
        try {
            $activity = Activity::findOrFail($activity_id);

            $validate_data = $request->validate([
                'status_type' => 'required'
            ]);

            $activity->update($validate_data);

            // Fetch Specific Task
            $task = Task::findOrFail($task_id);
            $task['total_activities'] = $this->taskService->count_task_activities($task_id);
            $task['completed_activities'] = $task->activities()->where('status_type', 2)->count();

            return response()->json(
                [
                    'updated_activity' => $activity,
                    'current_task' => $task
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to update activity status type'], 500);
        }
    }

    /**
     * Update Activity Due Date
     */

    public function update_due_date(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id,
        $activity_id
    ) {
        try {
            $activity = Activity::findOrFail($activity_id);

            $validate_data = $request->validate(
                [
                    'due_date' => 'required|date|after_or_equal:today'
                ]
            );

            $activity->update($validate_data);

            return response()->json(
                [
                    'updated_activity' => $activity
                ],
                200
            );
        } catch (ValidationException $e) {
            // Return validation errors as JSON response
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to update activity status type'], 500);
        }
    }

    /**
     * Update Activity Description
     */

    public function update_description(
        Request $request,
        $workspace,
        $collection_id,
        $section_id,
        $task_id,
        $activity_id
    ) {
        try {
            $activity = Activity::findOrFail($activity_id);

            $validate_data = $request->validate(
                [
                    'description' => 'required|min:5'
                ]
            );

            $activity->update($validate_data);

            return response()->json(
                [
                    'updated_activity' => $activity
                ],
                200
            );
        } catch (ValidationException $e) {
            // Return validation errors as JSON response
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to update activity description'], 500);
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
        $task_id,
        $activity_id
    ) {
        try {
            $activity = Activity::findOrFail($activity_id);

            // Check if the resource exists
            if ($activity) {
                // Delete the resource
                $activity->delete();

                // Fetch Specific Task
                $task = Task::findOrFail($task_id);
                $task['total_activities'] = $this->taskService->count_task_activities($task_id);
                $task['completed_activities'] = $task->activities()->where('status_type', 2)->count();

                return response()->json(
                    [
                        'current_task' => $task
                    ],
                    200
                );
            } else {
                // Return an error response if the resource was not found
                return response()->json(['message' => 'Resource not found'], 404);
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to update activity status type'], 500);
        }
    }
}
