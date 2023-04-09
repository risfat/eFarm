<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Models\SupplyDemand;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display user details.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserDetails()
    {

        // $user = User::with('userDetail')->findOrFail($id);

        $user = Auth::user();

        return response()->json($user);
    }

    /**
     * Login Request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|string'
        ]);

        $user = User::where('phone', $request->phone)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'phone' => 'The Provided Credentials Are Incorrect.'
            ]);
        }

        return $user->createToken($user->email)->plainTextToken;

    }


    /**
     * Signup Request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|phone|unique:users|max:12',
            'name' => 'required|string|min:5',
            'type' => 'required|string',
            'address' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'address' => $request->address
        ]);

        $user->save();

//       	$supplyDemand = SupplyDemand::create([
//            'user_id' => $user->id,
//            'supply_demands' => "Not Available",
//        ]);
//      	$supplyDemand->save();

      return $user;

    }


    public function getUsers()
        {
            $user = Auth::user();
            if ($user->type === 'Farmer') {
                $consumers = User::where('type', 'Consumer')
                    ->with('supplyDemand')
                    ->get();
                return response()->json(['users' => $consumers]);
            } else {
                $farmers = User::where('type', 'Farmer')
                    ->with('supplyDemand')
                    ->get();
                return response()->json(['users' => $farmers]);
            }
        }



    }
