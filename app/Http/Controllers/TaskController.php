<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController as BaseController;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Task::query();
        $tasks=$query->orderBy('id', 'DESC')->get();
        return $this->sendResponse($tasks, 'Tasks retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'project_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);
        }

        $input['id'] = Str::uuid();
        // print_r($input);exit;
        $task = Task::create($input);

        return $this->sendResponse($task, 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        return $this->sendResponse($task, 'Task retrieved successfully.');
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

        $task=Task::find($id);
          
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'project_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);
        }

        $task->title = $input['title'];
        $task->description = $input['description'];
        $task->status = $input['status'];
        $task->project_id = $input['project_id'];
        $task->update();

        return $this->sendResponse($task, 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $task=Task::find($id);
        $task->delete();
        return $this->sendResponse([], 'Task deleted successfully.');
    }

    public function updateTaskStatus(Request $request){
        $input = $request->all();
          
        $validator = Validator::make($input, [
            'task_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);
        }

        $task=Task::where('id',$input['task_id'])->where('user_id',$input['user_id'])->first();

        if(is_null($task)){
            return $this->sendError('This task is not assigned to you', [],200);
        }

        $task->status = $input['status'];
        $task->update();

        return $this->sendResponse($task, 'Task updated successfully.');
    }
}
