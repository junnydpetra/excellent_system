<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct()
    {
        $this->order = new OrderModel();
    }

    public function index()
    {
        $orders = $this->order
                       ->with('client')
                       ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'clients' => ClientModel::all(),
            'products' => ProductModel::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ord_client_id_fk' => 'required|exists:tab_clients,cli_id',
            'products' => 'sometimes|array',
            'products.*.id' => 'sometimes|required|exists:tab_products,pro_id',
            'products.*.quantity' => 'sometimes|required|integer|min:1',
        ]);

        $order = $this->order
                      ->create($request->only('ord_client_id_fk'));

        if (isset($request->products)) {
            $this->addProductsToOrder($order->ord_id, $request->products);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pedido criado com sucesso!',
            'order' => $order
        ], 201);
    }

    protected function addProductsToOrder($orderId, $products)
    {
        foreach ($products as $product) {
            OrderProductModel::create([
                'order_id'   => $orderId,
                'product_id' => $product['id'],
                'quantity'   => $product['quantity'],
            ]);
        }
    }

    public function show($id)
    {
        $order = $this->order
                      ->with(['client', 'products.product'])
                      ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = $this->order
                      ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido não encontrado.'
            ], 404);
        }

        OrderProductModel::where('op_order_id_fk', $id)->delete();

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pedido excluído com sucesso!'
        ]);
    }
}
