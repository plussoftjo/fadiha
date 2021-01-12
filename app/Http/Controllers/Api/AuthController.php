<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Fetch User Inputs from the request
        $user_input = $request->all();
        

        if($request->image == 'null') {
            $user = User::create([
                'name' => $user_input['name'],
                'phone' => $user_input['phone'],
                'password' => bcrypt($user_input['password']),
                'role_id' => $user_input['role_id']
            ]);
        }else {
            if ($request->hasFile('image')) {
                //  Let's do everything here
                if ($request->file('image')->isValid()) {
                    //
                    $validated = $request->validate([
                        'image' => 'mimes:jpeg,png,jpg',
                    ]);
                    $extension = $request->image->extension();
                    $filename = Carbon::now()->format('YmdHs').'.'.$extension;
                    $request->image->storeAs('/public/users', $filename);
                    $url = 'storage/users/'.$filename;
                    
                   
                    $user = User::create([
                        'name' => $user_input['name'],
                        'phone' => $user_input['phone'],
                        'password' => bcrypt($user_input['password']),
                        'role_id' => $user_input['role_id'],
                        'avatar' => $url
                    ]); 
                   
                    
                }
            }else {
                $user = User::create([
                    'name' => $user_input['name'],
                    'phone' => $user_input['phone'],
                    'password' => bcrypt($user_input['password']),
                    'role_id' => $user_input['role_id']
                ]);
            }
        }


        // Create Token
        $token = $user->createToken('auth')->accessToken;

        // Fetch User
        $user_data = User::where('id', $user->id)->first();

        // Return data
        return response()->json([
            'token' => $token,
            'user' => $user_data,
        ]);
    }
    public function login(Request $request)
    {
        // Fetch Input
        $input = $request->all();
        // IF Right Values
        if (Auth::attempt(['phone' => $input['phone'], 'password' => $input['password']])) {
            // Auth User
            $user = Auth::User();
            $token = $user->createToken('auth')->accessToken; #Fetch Token


            //return data
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        }

        // if not correct
        return response()->json(['error' => 'Unauthorised'], 401);
    }

    public function auth()
    {
        $user = Auth::User();

        return response()->json($user);
    }
}
