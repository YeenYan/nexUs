<?php

namespace App\Services;

use App\Models\{
 Section,
 Collection,
 Workspace
};


class SectionService
{

 public function getSectionData($sectionID)
 {
  $section = Section::findOrFail($sectionID);

  // Get all tasks for the section by descending order
  $sections = $section->tasks()->mostRecent()->get();

  return $section;
 }

 public function getTasksList($sectionID)
 {
  $section = Section::findOrFail($sectionID);

  // Get all tasks for the section by descending order
  $sections = $section->tasks()->mostRecent()->get();

  return $sections;
 }
}
