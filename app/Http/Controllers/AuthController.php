<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$creds = $request->validate([
			'email' => 'required',
			'password' => 'required'
		]);
		
		$user = User::where('email', $creds['email'])->first();
		if (!$user || !Hash::check($creds['password'], $user->password))
		{
			return response()->json('Invalid credentials', 401);
		}

		$token = $user->createToken('api-token')->plainTextToken;
		
		return Response()->json($token, Response::HTTP_OK);
	}
}


