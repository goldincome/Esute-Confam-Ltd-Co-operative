<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use App\User; 
use App\Group; 
use Validator;

class GroupController extends Controller
{
    
    /** * Display a listing of the resource. 
     * * * @return \Illuminate\Http\Response */ 
    public function index() { 
        $groups = Group::find(Auth::user()->id); 
        $data = $groups->toArray();

        if (is_null($groups)) { 
            $response = [ 
                'success' => false, 
                'data' => 'Empty', 
                'message' => 'Group not found.' 
            ]; 
            return response()->json($response, 404); 
        }

        $response = [ 
        'success' => true, 
        'data' => $data, 
        'message' => 'Groups retrieved successfully.'
         ];
         return response()->json($response, 200); 
    }


    public function store(Request $request) {
        $input = $request->all(); 
        $validator = Validator::make($input,
         [ 
            'group_name' => 'required', 
            'group_desc' => 'required',
            'group_capacity' => 'required',
            'group_save_amt' => 'required',
            'is_searchable' => 'required',
            'group_type' => 'required',
            'group_start_month' => 'required'

        ]);

        if ($validator->fails()) {
             $response = [ 
                 'success' => false, 
                 'data' => 'Validation Error.', 
                 'message' => $validator->errors() 
                ]; 
            return response()->json($response, 404); 
        }
        $input['user_id'] = Auth::user()->id; 
        $input['group_unique_id'] =str_random(7);
        $group = Group::create($input); 
        $data = $group->toArray(); 
        $response = [ 
            'success' => true, 
            'data' => $data, 
            'message' => 'Group created successfully.' 
        ];

        return response()->json($response, 200);

    }

    public function show($id) {
        $group = Group::find($id); 
        $data = $group->toArray(); 
        if (is_null($group)) { 
            $response = [ 
                'success' => false, 
                'data' => 'Empty', 
                'message' => 'Group not found.' 
            ]; 
            return response()->json($response, 404); 
        }

        $response = [ 
            'success' => true, 
            'data' => $data, 
            'message' => 'Group retrieved successfully.' 
        ]; 
        return response()->json($response, 200);

    }

    public function update(Request $request, Group $group) { 
        $input = $request->all();
        $validator = Validator::make($input, 
        [ 
            'group_name' => 'required', 
            'group_desc' => 'required',
            'group_capacity' => 'required',
            'group_save_amt' => 'required',
            'is_searchable' => 'required',
            'group_type' => 'required',
            'group_start_month' => 'required'
        ]);

        if ($validator->fails()) { 
            $response = [ 
                'success' => false, 
                'data' => 'Validation Error.', 
                'message' => $validator->errors() 
            ]; 
            return response()->json($response, 404); 
        }

        $group->user_id = Auth::user()->id; 
        $group->save(); 
        $data = $group->toArray();

        $response = [ 
            'success' => true, 
            'data' => $data, 
            'message' => 'Group updated successfully.' 
        ]; 
        return response()->json($response, 200);
    }

    public function destroy(Group $group) { 
        $group->delete(); 
        $data = $group->toArray();
        $response = [ 
            'success' => true, 
            'data' => $data, 
            'message' => 'Group deleted successfully.' 
        ]; 
        return response()->json($response, 200);

    }

    

}
