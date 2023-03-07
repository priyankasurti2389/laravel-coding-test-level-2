<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;

class CheckHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->user();
        
        if(!empty($user)){
            
            $api_user = User::with('accessRole')->where('id',$user->id)->first();
            Log::info('Request User details', ['user' => $api_user]);
            if(!empty($api_user->accessRole)){

                $role = $api_user->accessRole;
                
                Log::info('User details', ['user' => $api_user]);
                Log::info('User Role details', ['role' => $role]);
                Log::info('--------------------------------------------------');
                Log::info('Current API Path', ['api path' => $request->path()]);
                Log::info('Current API Method', ['api method' => $request->method()]);
                if($role->access_list){
                    $access_list = json_decode($role->access_list);
                    // Log::info('api_access_path', ['api_access_path' => $access_list]);
                    $has_access = false;
                    foreach ($access_list as $key => $api_access) {
                        
                        $api_path = $api_access->path;
                        if($api_path == "*" && in_array('*',$api_access->methods)){
                            $has_access = true;
                        }else{
                            if(strpos($api_access->path, '*') != -1){
                                $api_path = trim($api_access->path, '/*');
                            }
                            
                            if (Str::startsWith($request->path(),$api_path) && in_array($request->method(), $api_access->methods)){
                               $has_access = true;
                            }
                        }
                    }
                    if($has_access == false){
                        return response()->json(array('success' => false,'message' => 'Permission denied'))->setStatusCode(401);
                    }
                }else{
                    return response()->json(array('success' => false,'message' => 'client version not avaialable in header'))->setStatusCode(401);
                    
                }

            }

            
            
        }
        

        return $next($request);
    }
}