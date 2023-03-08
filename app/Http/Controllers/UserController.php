<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = User::query();
        $users=$query->orderBy('id', 'DESC')->get();
        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'role_id'  => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);
        }

        $input['id'] = Str::uuid();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['name']  = $user->username;
        $success['token'] = $user->createToken('accessToken')->accessToken;
        return $this->sendResponse($success, 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $user=User::find($id);
          
        $validator = Validator::make($input, [
            'username' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);   }

        $user->username = $input['username'];
        $user->password = $input['password'];
        $user->update();

        return $this->sendResponse($user, 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project=Project::find($id);
        $project->delete();
        return $this->sendResponse([], 'Project deleted successfully.');
    }

    public function login(Request $request)
    {
        if(\Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
            $user = \Auth::user(); 
            
            $success['name'] =  $user->username;
            $success['role'] =  $user->role_id;
            $success['id'] =  $user->id;
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            
            return $this->sendResponse($success, 'User login successfully.');
        
        }else{ 
            return $this->sendError('Invalid Username or Password','',401);
        } 
    }
    


}
