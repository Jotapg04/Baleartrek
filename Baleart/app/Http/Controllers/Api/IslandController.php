<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Island;

class IslandController extends Controller
{
    /**
     * Devuelve todas las islas para el menú de navegación (Punto 12 de la Rúbrica)
     */
    public function index()
    {
        $islands = Island::all();
        return response()->json($islands);
    }
}