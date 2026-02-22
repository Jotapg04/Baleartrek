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
     * SHOW - Ver el detalle de un comentario específico
     */
    public function show(Comment $comment)
    {
        // Cargamos las relaciones para que la vista tenga los datos del usuario y la excursión
        $comment->load(['user', 'meeting.trek']);

        // Retornamos la vista que me enseñaste antes
        return view('admin.comments.show', compact('comment'));
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
    public function update(Request $request, $id)
{
    // 1. Buscamos el comentario
    $comment = Comment::findOrFail($id);

    // 2. Validamos que el status sea 'y' o 'n'
    $request->validate([
        'status' => 'required|in:y,n',
    ]);

    // 3. Actualizamos solo el estado
    $comment->status = $request->status;
    $comment->save();

    $comment->touch();

    // 4. Redirigimos al INDEX de comentarios
    return redirect()->route('comments.index')
        ->with('success', 'El estado del comentario se ha actualizado correctamente.');
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