<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( 'auth' );
        $this->middleware( 'admin' );
    }

    /**
     * Display a listing of the resource.
     *
     * @param string|null $year
     * @param string|null $month
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index( string $year = null, string $month = null ) {
        return view( 'user', [
            'controller' => $this,
            'users'      => User::all(),
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        try {
            return view( 'user' )->with( [
                'controller' => $this,
                'template'   => 'user.new',
                'user'       => new User,
            ] );
        } catch ( ModelNotFoundException $ex ) {
            if ( $ex instanceof ModelNotFoundException ) {
                return response()->view( 'errors.' . '404' );
            }
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store( Request $request ) {
        $this->validate( $request, [
            'name'     => 'required',
            'username' => 'required|unique:users',
            'email'    => 'required|unique:users',
            'password' => 'required',
        ] );
        $user = User::create( [
            'name'        => $request->input( 'name' ),
            'username'    => $request->input( 'username' ),
            'email'       => $request->input( 'email' ),
            'password'    => Hash::make( $request->input( 'password' ) ),
            'salary_name' => $request->input( 'salary_name' ),
            'role'        => 0,
        ] );

        return redirect()->route( 'users.index' )->with( 'success',
            "The user <strong>$user->name</strong> has successfully been created." );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        try {
            return view( 'user' )->with( [
                'controller' => $this,
                'template'   => 'user.edit',
                'user'       => User::findOrFail( $id ),
            ] );
        } catch ( ModelNotFoundException $ex ) {
            if ( $ex instanceof ModelNotFoundException ) {
                return response()->view( 'errors.' . '404' );
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update( Request $request, $id ) {
        try {
            $user = User::findOrFail( $id );
            $this->validate( $request, [
                'name'        => 'required',
                'email'       => 'required|email|unique:users,email,' . $id,
                'username'    => 'required|unique:users,username,' . $id,
                'salary_name' => 'unique:users,salary_name,' . $id,
            ] );
            $user->username    = $request->input( 'username' );
            $user->email       = $request->input( 'email' );
            $user->name        = $request->input( 'name' );
            $user->salary_name = $request->input( 'salary_name' );
            $user->save();

            return redirect()->route( 'users.index' )->with( 'success',
                "The user <strong>$user->name</strong> has successfully been updated." );
        } catch ( ModelNotFoundException $ex ) {
            if ( $ex instanceof ModelNotFoundException ) {
                return response()->view( 'errors.' . '404' );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        //
    }
}
