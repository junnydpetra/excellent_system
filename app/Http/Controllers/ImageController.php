<?php

namespace App\Http\Controllers;

use App\Models\ImageModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected $image;

    public function __construct()
    {
        $this->image = new ImageModel();
    }

    public function index($productId)
    {
        $images = $this->image
                       ->where('ima_pro_id_fk', $productId)
                       ->get();

        return response()->json($images);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'ima_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('ima_path')
                             ->store('images', 'public');

        $image = $this->image
                      ->create([
                            'ima_path' => $imagePath,
                            'ima_pro_id_fk' => $productId,
                        ]);

        return response()->json([
            'success' => true,
            'message' => 'Imagem armazenada com sucesso!',
            'image' => $image
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($productId, $imageId)
    {
        $image = $this->image
                      ->where('ima_pro_id_fk', $productId)
                      ->find($imageId);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Imagem não encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'image' => $image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId, $imageId)
    {
        $request->validate([
            'ima_path' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $this->image
                      ->where('ima_pro_id_fk', $productId)
                      ->find($imageId);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Imagem não encontrada.'
            ], 404);
        }

        if ($request->hasFile('ima_path')) {
            $imagePath = $request->file('ima_path')
                                 ->store('images', 'public');
            $image->ima_path = $imagePath;
        }

        $image->save();

        return response()->json([
            'success' => true,
            'message' => 'Imagem atualizada com sucesso!',
            'image' => $image
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId, $imageId)
    {
        $image = $this->image
                      ->where('ima_pro_id_fk', $productId)
                      ->find($imageId);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Imagem não encontrada.'
            ], 404);
        }

        Storage::disk('public')->delete($image->ima_path);

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Imagem excluída com sucesso!'
        ]);
    }
}
