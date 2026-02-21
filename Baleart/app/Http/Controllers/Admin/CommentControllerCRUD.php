<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentControllerCRUD extends Controller
{
    /**
     * INDEX - Listado de comentarios
     */
    public function index()
    {
        // Cargamos las relaciones para evitar el problema N+1
        // Suponiendo que Comment pertenece a User y a Meeting (y esta a Trek)
        $comments = Comment::with(['user', 'meeting.trek'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * EDIT - Formulario de edición
     */
    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * UPDATE - Actualizar el contenido
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        $comment->update($validated);

        // Forzamos el update de la fecha si solo se cambia el texto 
        // y por alguna razón Eloquent no lo detecta (aunque debería)
        $comment->touch();

        return redirect()
            ->route('comments.index')
            ->with('success', 'Comentario actualizado correctamente');
    }

    /**
     * DESTROY - Eliminar comentario e imágenes asociadas
     */
    public function destroy(Comment $comment)
    {
        // 1. Eliminar archivos físicos de las imágenes si existen
        foreach ($comment->images as $image) {
            // Suponiendo que guardas la ruta en un campo 'path'
            if (Storage::exists($image->path)) {
                Storage::delete($image->path);
            }
        }

        // 2. Eliminar los registros de las imágenes en la DB
        $comment->images()->delete();

        // 3. Eliminar el comentario
        $comment->delete();

        return redirect()
            ->route('comments.index')
            ->with('success', 'Comentario e imágenes eliminados');
    }
}