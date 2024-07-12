<?php

namespace App\Services;

use App\Models\{
  Collection,
  Workspace
};
use Illuminate\Support\Facades\Auth;


class WorkspaceService
{
  public function getActiveWorkspace()
  {
    // Fetch the user's workspaces
    $userWorkspaces = Auth::user()->workspaces;

    // Filter the workspaces where the active column is 1
    $activeWorkspaces = $userWorkspaces->filter(function ($workspace) {
      return $workspace->active == 1;
    });

    // Get the first active workspace
    $activeWorkspaces = $activeWorkspaces->first();

    return $activeWorkspaces;
  }

  public function getAllCollections()
  {
    // Assuming you are looking for a specific workspace with an ID of 1
    $workspaceId = $this->getActiveWorkspace()->workspace_id;
    $workspace = Workspace::findOrFail($workspaceId);

    // Get all collections for the workspace by descending order
    $collections = $workspace->collections()->mostRecent()->get();

    return $collections;
  }


  public function getAllSections($collection_id)
  {

    $collection = Collection::findOrFail($collection_id);

    // Get all collections for the workspace by descending order
    $sections = $collection->sections()->mostRecent()->get();

    return $sections;
  }

  public function redirectToActiveWorkspace()
  {
    $activeWorkspace = $this->getActiveWorkspace();
    // $all_collections = $this->getAllCollections();

    if ($activeWorkspace) {
      // Redirect to the 'dashboard' route with the workspace_id parameter

      return redirect()->route(
        'workspace.dashboard.index',
        [
          'workspace' => $activeWorkspace->workspace_id,
        ]
      );
    } else {
      // Handle case where no active workspace was found
      // Redirect to a default route or return an error response
      return redirect()->route(
        'workspace.show',
        [
          'all_workspaces' => $activeWorkspace,
        ]
      );
    }
  }

  public function getWorkspaceData($workspace)
  {
    $all_collections = $this->getAllCollections();

    return
      [
        'all_workspaces' => Auth::user()->workspaces,
        'avatar' => Auth::user()->avatar,
        'all_collections' => $all_collections,
      ];
  }
}
