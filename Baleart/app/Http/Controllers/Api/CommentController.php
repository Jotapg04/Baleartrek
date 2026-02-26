<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        // Añadimos 'images' al array de relaciones
        return Comment::with(['user', 'meeting.trek', 'images']) 
            ->where('status', '!=', 'n') // Solo activos
            ->orderByDesc('score')        // Los de 5 estrellas primero
            ->get();
    }
}