<?php

namespace App\Modules\Api\Controllers;

use Illuminate\Http\Request;
use App\Modules\Api\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class AuthController extends BaseController
{

    public function token(Request $request)
    {
        $user = \Auth::user();
        $user->tokens()->where('name', 'WorkApp')->delete();
        $success['token'] =  $user->createToken('WorkApp')->plainTextToken;

        return $this->sendResponse($success, 'User signed in');
    }

    /**
     * @deprecated
     */
    public function signin(Request $request)
    {
        return;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('WorkApp')->plainTextToken;
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    /**
     * @deprecated
     */
    public function signup(Request $request)
    {
        return;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('WorkApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }
}
