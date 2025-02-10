<?php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Handle forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLink(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 200);
        }

        return response()->json(['error' => __($status)], 500);
    }
}
