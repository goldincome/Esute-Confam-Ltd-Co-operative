<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use App\MemberDeposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MemberDepositController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all(); 
        $validator = Validator::make($input,
         [ 
            'deposit_amt' => 'required', 
            'deposit_desc' => 'required',


        ]);

        if ($validator->fails()) {
             $response = [ 
                 'success' => false, 
                 'data' => 'Validation Error.', 
                 'message' => $validator->errors() 
                ]; 
            return response()->json($response, 404); 
        }
        $duser = auth()->guard('api')->user();
        $input['user_id'] = $duser->id; 
        $memberdeposit = MemberDeposit::create($input);
        $user = User::findOrFail($input['user_id']);
         $user->user_balance = ($input['deposit_amt'] + $duser->user_balance);
         $user->save(); 
        $data = $memberdeposit->toArray(); 
        $response = [ 
            'success' => true, 
            'data' => $data, 
            'message' => 'Deposit created successfully.' 
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
