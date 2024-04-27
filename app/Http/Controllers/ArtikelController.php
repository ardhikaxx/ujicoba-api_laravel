<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Database\QueryException;

class ArtikelController extends Controller
{
    public function index()
    {
        try {
            $artikels = Artikel::select('judul', 'gambar', 'tanggal_upload', 'deskripsi')->get();

            $artikels->transform(function ($artikel) {
                $artikel->gambar = base64_encode($artikel->gambar);
                return $artikel;
            });

            return response()->json([
                'success' => true,
                'data' => $artikels,
                'message' => 'Data retrieved successfully'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching data from database: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
