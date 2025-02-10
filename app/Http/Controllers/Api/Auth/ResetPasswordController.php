<?php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * Handle reset password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], 200);
        }

        return response()->json(['error' => __($status)], 500);
    }
}
