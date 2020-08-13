<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Api\AuthController;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'users' => $users->toArray()
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json([
            'status' => 'success',
            'user' => $user->toArray()
        ], 200);
    }

    public function showWeb(Request $request)
    {
        $token = session()->get('bearer');
        $request->headers->set('Authorization', "bearer $token");
        $request->headers->set('Accept', "application/json");
        $response = AuthController::user($request);
        $statusCode = $response->status();
        $data['user'] = $response->getData('data')['data'];
        if ($statusCode === 200) {
            return view('home')->with($data);
        }
        return redirect()->route('login')->withErrors(['message' => 'Unauthorized']);
    }

}
