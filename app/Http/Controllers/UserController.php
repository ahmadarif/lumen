<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    /**
     * Register new user
     * @param Request $request
     * @return Response
     */
    public function register(Request $request) {
        $hasher = app()->make('hash');

        $email = $request->input('email');
        $name = $request->input('name');
        $password = $hasher->make($request->input('password'));

        try {
            $user = new User();
            $user->email = $email;
            $user->name = $name;
            $user->password = $password;

            if ($user->save()) {
                $res['success'] = true;
                $res['message'] = 'Success register!';
                return response($res, Response::HTTP_CREATED);
            } else {
                $res['success'] = false;
                $res['message'] = 'Failed to register!';
                return response($res, Response::HTTP_BAD_REQUEST);
            }
        } catch (QueryException $e) {
            $res['success'] = false;
            $res['message'] = $e->errorInfo[2];
            return response($res, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * User login
     * @param Request $request
     * @return Response
     */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->respondWithErrorMessage($validator);
        }

        $hasher = app()->make('hash');

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            $res['success'] = false;
            $res['message'] = 'Email not found!';
            return response($res, Response::HTTP_BAD_REQUEST);
        } else {
            if ($hasher->check($password, $user->password)) {
                $token = sha1(time());
                $create_token = User::where('id', $user->id)->update(['token' => $token]);
                if ($create_token) {
                    $res['success'] = true;
                    $res['token'] = $token;
                    $res['data'] = $user;
                    return response($res);
                }
            } else {
                $res['success'] = true;
                $res['message'] = 'Password incorrect!';
                return response($res, Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Get user by ID
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function getUser(Request $request, $id) {
        $user = User::where('id', $id)->get();
        if ($user) {
            $res['success'] = true;
            $res['data'] = $user;
            return response($res, Response::HTTP_OK);
        }else{
            $res['success'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res, Response::HTTP_BAD_REQUEST);
        }
    }
}