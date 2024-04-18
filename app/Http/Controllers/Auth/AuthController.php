<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $response = [
        'message' => null,
        'data' => null,
    ];

    public function register(Request $req) {
        $req->validate([
            'email' => 'required|email|unique:users,email',
            'nikIbu' => 'required',
            'namaIbu' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'password' => 'required',
        ]);        
    
        $data = [
            'email' => $req->email,
            'nikIbu' => $req->nikIbu,
            'namaIbu' => $req->namaIbu,
            'tempat_lahir' => $req->tempat_lahir,
            'tanggal_lahir' => $req->tanggal_lahir,
            'alamat' => $req->alamat,
            'telepon' => $req->telepon,
            'password' => Hash::make($req->password),
        ];
    
        try {
            $user = User::create($data);
            $this->response['data'] = $user;
            $this->response['message'] = 'success';
            return response()->json($this->response, 200);
        } catch (QueryException $e) {
            $this->response['message'] = 'User registration failed: ' . $e->getMessage();
            return response()->json($this->response, 500);
        }
    }

    public function login(Request $req) {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $req->email)->first();
    
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                'message' => "failed",
            ]);
        }
        
        $this->response['message'] = 'success';
        $this->response['data'] = [
            'token' => $user->createToken('')->plainTextToken
        ];
    
        return response()->json($this->response, 200);
    }    

    public function me() {
        $user = Auth::user();

        $this->response['message'] = 'success';
        $this->response['data'] = $user;

        return response()->json($this->response, 200);
    }

    public function logout() {
        $logot = auth()->user()->currentAccessToken()->delete();
            
        $this->response['message'] = 'success';

        return response()->json($this->response, 200);
    }
}
