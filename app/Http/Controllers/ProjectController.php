<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use Illuminate\Support\Str;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Project::query();
        if(!empty($request->q)){
            $query->where('name','like','%'.$request->q.'%');
        }

        $page_index=0;
        if(!empty($request->pageIndex)){
            $request->page=$request->pageIndex+1;
        }

        $page_size=3;
        if(!empty($request->pageSize)){
            $page_size=$request->pageSize;
        }

        $sort_field=!empty($request->sortByField)?$request->sortByField:'name';
        $sort_direction = !empty($request->sortDirection)?$request->sortDirection:'ASC' ;
        
        $query->orderBy($sort_field,$sort_direction);
            
        $projects=$query->paginate($page_size);
        return $this->sendResponse($projects, 'Projects retrieved successfully.');
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
            'name' => 'required|unique:projects,name',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);
        }

        $input['id'] = Str::uuid();
        $project = Project::create($input);

        return $this->sendResponse($project, 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return $this->sendError('Project not found.');
        }

        return $this->sendResponse($project, 'Project retrieved successfully.');
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

        $project=Project::find($id);
          
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);   }

        $project->name = $input['name'];
        $project->update();

        return $this->sendResponse($project, 'Project updated successfully.');
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

    public function assignProjectToUser(Request $request){
        $input = $request->all();
          
        $validator = Validator::make($input, [
            'project_id' => 'required',
            'user_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),200);   }

        $project=Project::find($request->project_id);

        if(!empty($request->user_id)){

            $errors = array();
            foreach($request->user_id as $user_id){
               $projectUser = ProjectUser::where('user_id',$user_id)->first();
               
               if(!empty($projectUser)){
                   array_push($errors,$user_id);
               }
            }

            if(!empty($errors)){
              $existing_users = implode(',',$errors);
            }

            $project->user()->sync($request->user_id);

            if(!empty($existing_users)){
              return $this->sendError('Project is already assigned to user_id '.$existing_users,[],200);
            }else{
              return $this->sendResponse($project, 'Project assigned successfully.');
            }
        }

        
    }
}
