<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\User; 
use Validator;
use App\MemberGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
   /** * Register api * *   
   * @return \Illuminate\Http\Response 
   *
   */ 
   public function register(Request $request){ 
       $validator = Validator::make($request->all(), [ 
           'name' => 'required', 
           'email' => 'required|email', 
           'password' => 'required', 
           'c_password' => 'required|same:password', 
           ]); 
           
           if ($validator->fails()) { 
               $response = [ 'success' => false, 
               'data' => 'Validation Error.', 
               'message' => $validator->errors()
             ]; 
             
             return response()->json($response, 404); 
            } 
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input); 
            $success['token'] = $user->createToken('MyApp')->accessToken; 
            $success['name'] = $user->name; 
            $response = [ 
                'success' => true,            
                'data' => $success, 
                'message' => 'User register successfully.'
             ]; 
                return response()->json($response, 200); 
            } 
                
                /** * Login api * * @return \Illuminate\Http\Response */
    public function login() { 
        if (Auth::attempt(['email' => request('email'),'password' => request('password')])) {
         $user = Auth::user(); 
          $success['token'] = $user->createToken('MyApp')->accessToken; 
          return response()->json(['success' => $success], 200);
         } 
        else { 
            return response()->json(['error' => 'Unauthorised'], 401); 
        } 
    } 

        //list all groups that belongs to a particular admin
    public function listgroup() { 
       
        if (!is_null(auth()->guard('api')->user()->groups)){
      
            //$user->find(Auth::user()->id); 
            $data = auth()->guard('api')->user()->groups->toArray();
                $response = [ 
                    'success' => true, 
                    'data' => $data, 
                    'message' => 'Group retrieved successfully.' 
                ]; 
                return response()->json($response, 200);
        }
        else { 
            return response()->json(['error' => 'Unauthorised'], 401); 
        } 
    } 

        //List all groups 
    public function listallgroup() { 
       $groups = Group::all();
        if (!is_null($groups)){
      
            //$user->find(Auth::user()->id); 
            $data = $groups->toArray();
                $response = [ 
                    'success' => true, 
                    'data' => $data, 
                    'message' => 'Group retrieved successfully.' 
                ]; 
                return response()->json($response, 200);
        }
        else { 
            return response()->json(['error' => 'Unauthorised'], 401); 
        } 
    } 

        //Group admin Adding User to a group
    public function addusertogroup(Request $request) { 
            $validator = Validator::make($request->all(), [ 
                'ugroup_id' => 'required', 
                'user_id' => 'required', 
                ]); 
                
                if ($validator->fails()) { 
                    $response = [ 'success' => false, 
                    'data' => 'Validation Error.', 
                    'message' => $validator->errors()
                  ]; 
                  
                  return response()->json($response, 404); 
                 } 

                 $input = $request->all();
                 //Getting the group information that belong to the group admin
                 $group = Group::where('group_unique_id',$input['ugroup_id'])
                     ->where('user_id', auth()->guard('api')->user()->id)->get();
                    
                     //Checking if the user is registered
                $user = User::find($input['user_id']);

                $membergroup = MemberGroup::where(['group_id' => $group[0]->id, 'user_id' => $user->id])->get();
        
        if (count($membergroup) > 0 ){
            $response = [ 
                'success' => true, 
                'data' => $group->toArray(), 
                'message' => 'User already a member.' 
            ]; 
            return response()->json($response, 401); 
        }            
        else{       if (!is_null($group) && !is_null($user)){
                //$group_id = $group[0]->id;
                $addit = ['group_id'=>$group[0]->id,'user_id'=>$input['user_id']];
                    //Adding user to the group
                 MemberGroup::create($addit); 

                    $data = $group->toArray();
                        $response = [ 
                            'success' => true, 
                            'data' => $data , 
                            'message' => 'User added to Group successfully.' 
                        ]; 
                        return response()->json($response, 200);
                }
                else { 
                    return response()->json(['error' => 'Unauthorised'], 401); 
                }
            } 
    } 


    public function searchgroup() { 
                $groups = Group::where('is_searchable',1);
                if (!is_null($groups)){
            
                    //$user->find(Auth::user()->id); 
                    $data = $groups->toArray();
                        $response = [ 
                            'success' => true, 
                            'data' => $data, 
                            'message' => 'Group retrieved successfully.' 
                        ]; 
                        return response()->json($response, 200);
                }
                else { 
                    return response()->json(['error' => 'Unauthorised'], 401); 
                } 
     } 


}   


