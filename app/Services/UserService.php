<?php

namespace App\Services;

use App\Models\{
 Collection,
 Workspace,
 User
};
use Illuminate\Support\Facades\Auth;


class UserService
{

 public function get_member_id($email)
 {

  // Find the user by email
  $user = User::where('email', $email)->first();

  // Check if user exists
  if ($user) {
   // Return the user_id of the found user
   return $user->user_id;
  } else {
   // Return null or handle the case when the user is not found
   return null;
  }
 }
}
