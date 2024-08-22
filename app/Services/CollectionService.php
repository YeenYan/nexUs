<?php

namespace App\Services;

use App\Models\{
 Activity,
 Task,
 Section,
 Collection,
 Workspace
};


class CollectionService
{
 public function get_all_sections($collection_id)
 {

  // First, get all the sections in the collection
  $sections = Section::where('collection_id', $collection_id)
   ->orderBy('created_at', 'desc') // Order if necessary
   ->get();

  // Initialize an array to store the results
  $sectionActivities = [];

  foreach ($sections as $section) {
   // Get the total count of activities for the current section
   $totalCount = Activity::whereIn('task_id', function ($query) use ($section) {
    $query->select('task_id') // Select task IDs
     ->from('tasks')
     ->where('section_id', $section->section_id)
     ->orderBy('created_at', 'desc'); // Order if necessary
   })->count(); // Count the total activities

   // Get the count of completed activities (status_type = 2) for the current section
   $completedCount = Activity::whereIn('task_id', function ($query) use ($section) {
    $query->select('task_id') // Select task IDs
     ->from('tasks')
     ->where('section_id', $section->section_id)
     ->orderBy('created_at', 'desc'); // Order if necessary
   })->where('status_type', 2) // Filter by status_type = 2
    ->count(); // Count the completed activities

   // Add the counts directly to the section object
   $section->total_count = $totalCount;
   $section->completed_count = $completedCount;
  }

  return $sections;
 }

 public function get_collection_progress($collection_id)
 {

  $activities = Activity::whereIn('task_id', function ($query) use ($collection_id) {
   $query->select('task_id')
    ->from('tasks')
    ->whereIn('section_id', function ($subQuery) use ($collection_id) {
     $subQuery->select('section_id')
      ->from('sections')
      ->where('collection_id', $collection_id)
      ->orderBy('created_at', 'desc'); // Order if necessary
    })
    ->orderBy('created_at', 'desc'); // Order if necessary
  })->get();

  // Count total activities
  $total_status = $activities->count();

  // Count activities with status_type = 2
  $completed = $activities->where('status_type', 2)->count();

  // Store these values to variables
  $total = $total_status;

  // Return the counts
  return [
   'total_activities' => $total,
   'completed' => $completed,
  ];
 }
}
