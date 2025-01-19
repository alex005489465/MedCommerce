<?php

namespace App\Http\Controllers;

use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInformationController extends Controller
{
    /**
     * Get the user information based on the currently logged-in user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        // Get the email of the currently logged-in user
        $email = Auth::user()->email;
        $userInformation = UserInformation::where('email', $email)->first();

        if (!$userInformation) {
            return response()->json(['error' => 'User information not found.'], 404);
        }

        return response()->json($this->formatUserInformation($userInformation));
    }

    /**
     * Submit data to update the user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        // Get the email of the currently logged-in user
        $userEmail = Auth::user()->email;

        // Get the email from the request
        $requestEmail = $request->input('email');

        // Check if the request email matches the currently logged-in user's email
        if ($userEmail !== $requestEmail) {
            return response()->json(['error' => 'Email mismatch. Update failed.'], 403);
        }

        $userInformation = UserInformation::where('email', $userEmail)->first();

        if (!$userInformation) {
            return response()->json(['error' => 'User information not found.'], 404);
        }

        // Update user information (excluding the email field)
        $userInformation->update($request->except('email'));

        return response()->json($this->formatUserInformation($userInformation));
    }

    /**
     * Format the user information to a standardized array.
     *
     * @param  \App\Models\UserInformation  $userInformation
     * @return array
     */
    private function formatUserInformation(UserInformation $userInformation)
    {
        return [
            'email' => $userInformation->email,
            'name' => $userInformation->name ?: '',
            'nickname' => $userInformation->nickname ?: '',
            'gender' => $userInformation->gender ?: '',
            'date_of_birth' => $userInformation->date_of_birth ? $userInformation->date_of_birth->toISOString() : '',
            'profile_picture' => $userInformation->profile_picture ?: '',
            'phone_number' => $userInformation->phone_number ?: '',
            'address' => $userInformation->address ?: '',
            'occupation' => $userInformation->occupation ?: '',
        ];
    }
}
