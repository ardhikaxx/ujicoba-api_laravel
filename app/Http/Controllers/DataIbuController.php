<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\DataIbu;
use Illuminate\Database\QueryException;

class DataIbuController extends Controller
{
    private $response = [
        'message' => null,
        'data' => null,
    ];

    public function register(Request $req) {
        $req->validate([
            'email_orang_tua' => 'required|email|unique:orang_tua,email_orang_tua',
            'nik_ibu' => 'required',
            'nama_ibu' => 'required',
            'tempat_lahir_ibu' => 'required',
            'tanggal_lahir_ibu' => 'required',
            'gol_darah_ibu' => 'required',
            'nik_ayah' => 'required',
            'nama_ayah' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'password_orang_tua' => 'required',
        ]);
    
        $data = [
            'email_orang_tua' => $req->email_orang_tua,
            'nik_ibu' => $req->nik_ibu,
            'nama_ibu' => $req->nama_ibu,
            'tempat_lahir_ibu' => $req->tempat_lahir_ibu,
            'tanggal_lahir_ibu' => $req->tanggal_lahir_ibu,
            'gol_darah_ibu' => $req->gol_darah_ibu,
            'nik_ayah' => $req->nik_ayah,
            'nama_ayah' => $req->nama_ayah,
            'alamat' => $req->alamat,
            'telepon' => $req->telepon,
            'password_orang_tua' => Hash::make($req->password_orang_tua),
        ];
    
        try {
            $user = DataIbu::create($data);
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
            'email_orang_tua' => 'required|email',
            'password_orang_tua' => 'required'
        ]);
    
        $user = DataIbu::where('email_orang_tua', $req->email_orang_tua)->first();
    
        if (!$user || !Hash::check($req->password_orang_tua, $user->password_orang_tua)) {
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
        $user = Auth::guard('sanctum')->user();

        $this->response['message'] = 'success';
        $this->response['data'] = $user;

        return response()->json($this->response, 200);
    }

    public function logout() {
        $user = Auth::user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });
    
        $this->response['message'] = 'success';
    
        return response()->json($this->response, 200);
    }
}