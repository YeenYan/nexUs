<?php

namespace App\Services;

use App\Models\{
 Task
};


class TaskService
{

 // FETCH ALL ACTIVITIES FOR THE SELECTED TASK
 public function get_task_activities($task_id)
 {
  $task = Task::findOrFail($task_id);

  // Get all tasks for the section by descending order
  $activites = $task->activities()->mostRecent()->get();

  return $activites;
 }

 public function count_task_activities($task_id)
 {
  $task = Task::findOrFail($task_id);

  $total_activities = $task->activities()->count();

  return $total_activities;
 }
}
