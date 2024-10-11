<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;

class ProductController extends Controller
{
    protected $product;

    public function __construct()
    {
        $this->product = new ProductModel();
    }

    public function index()
    {
        $products = $this->product
                         ->all();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pro_description' => 'required|string|max:255',
            'pro_sale_price' => 'required|numeric',
            'pro_stock' => 'required|integer'
        ]);

        $product = $this->product
                        ->create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produto cadastrado com sucesso!',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product
                        ->find($id);

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = $this->product
                        ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = $this->product
                        ->find($id);

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado.'
            ], 404);
        }

        $request->validate([
            'pro_description' => 'required|string|max:255',
            'pro_sale_price' => 'required|numeric',
            'pro_stock' => 'required|integer'
        ]);

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso!',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = $this->product
                        ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado.'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produto excluído com sucesso.'
        ]);
    }
}
