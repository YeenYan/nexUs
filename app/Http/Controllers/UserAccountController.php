<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Support\Str;
use App\Mail\InviteUserMail;
use Illuminate\Http\Request;
use App\Models\{User, Workspace, Workspace_Collab};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Services\{WorkspaceService, UserService};


class UserAccountController extends Controller
{
    protected $workspaceService;
    protected $userService;

    public function __construct(
        WorkspaceService $workspaceService,
        UserService $userService
    ) {
        $this->workspaceService = $workspaceService;
        $this->userService = $userService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return inertia('UserAccount/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'avatar' => 'required|image|mimes:jpg,png,jpeg,webp,svg,svg+xml|max:3000'
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();


            // Check if the file is an SVG
            if ($extension === 'svg' || $file->getMimeType() === 'image/svg+xml') {
                // Use the original filename for SVG files
                $filename = $file->getClientOriginalName();
            } else {
                $filename = Str::slug($request->username) . '-' . Str::uuid() . '.' . $extension;
            }


            // Store the file in the public storage
            $file->storeAs('avatars', $filename, 'public');

            // Save only the filename in the database
            $validatedData['avatar'] = $filename;
        }

        $user = User::create($validatedData);

        Auth::login($user);

        // return with('success', 'Account Created');
        return redirect()->route('workspace.create');
    }



    public function sendInvite(
        Request $request
    ) {
        $inviteeName = $request->input('name');
        $inviteeEmail = $request->input('email');

        $workspace_id = $this->workspaceService->getActiveWorkspace()->workspace_id;
        $owner = Auth::user()->user_id;
        $member = $this->userService->get_member_id($inviteeEmail);

        if ($member == null) {
            $member = 'User not found';
            $inviteLink = url('/login');
        } else {
            $inviteLink = route(
                'success.index',
                [
                    'workspace' => $workspace_id,
                    'owner_id' => $owner,
                    'member_id' => $member
                ]
            );
        }



        // Get the current user's email and name
        $fromEmail = Auth::user()->email;
        $fromName = Auth::user()->username;

        Mail::to($inviteeEmail)->send(new InviteUserMail($inviteeName, $inviteLink, $fromEmail, $fromName));

        return response()->json([
            'message' => 'Invitation sent successfully!',
            'workspace_id' => $workspace_id,
            'owner' => $owner,
            'member' => $member

            // 'workspace_data' => [
            //     'workspace_id' => $workspace_id,
            //     'owner' => $owner,
            //     'member' => $member
            // ]
        ]);
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

    public function add_member_to_workspace(Request $request, $workspace_id, $owner_id, $member_id)
    {

        $validate_data = $request->validate([
            'workspace_id' => 'required',
            'owner_id' => 'required',
            'member_id' => 'required'
        ]);

        $new_workspace_collab = Workspace_Collab::create($validate_data);

        return response()->json(
            [
                'new_workspace_collab' => $new_workspace_collab
            ],
            200
        );
    }

    public function success_email($workspace, $owner_id, $member_id): Response
    {

        return inertia(
            "Workspace/Success",
            [
                'workspace' => $workspace,
                'owner_id' => $owner_id,
                'member_id' => $member_id,
            ]
        );
    }
}
