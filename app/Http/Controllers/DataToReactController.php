<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use Illuminate\Http\Request;

class DataToReactController extends Controller
{
    public function getClients()
    {
        $clients = ClientModel::all();

        return response()->json([
            'success' => true,
            'clients' => $clients->map(function ($client) {
                return [
                    'cli_id' => $client->cli_id,
                    'api_id' => $client->cli_api_id,
                    'razao_social' => $client->cli_company_name,
                    'cnpj' => $client->cli_cnpj,
                    'email' => $client->cli_email
                ];
            })
        ]);
    }

    public function getProducts()
    {
        $products = ProductModel::all();

        return response()->json([
            'success' => true,
            'products' => $products->map(function ($product) {
                return [
                    'pro_id' => $product->pro_id,
                    'pro_description' => $product->pro_description,
                    'pro_sale_price' => $product->pro_sale_price,
                    'pro_stock' => $product->pro_stock,
                ];
            })
        ]);
    }

    public function getOrders()
    {
        $orders = OrderModel::with('client', 'products.product')->get();

        return response()->json([
            'success' => true,
            'orders' => $orders->map(function ($order) {
                return [
                    'ord_id' => $order->ord_id,
                    'client' => $order->client ? [
                        'cli_id' => $order->client->cli_id,
                        'razao_social' => $order->client->cli_company_name,
                    ] : null,
                    'products' => $order->products->map(function ($orderProduct) {
                        return [
                            'prod_id' => $orderProduct->op_product_id_fk,
                            'quantity' => $orderProduct->op_product_quantity,
                        ];
                    }),
                ];
            })
        ]);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:tab_clients,cli_id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:tab_products,pro_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = new OrderModel();
        $order->ord_client_id_fk = $request->client_id;
        $order->save();

        foreach ($request->products as $product) {
            $orderProduct = new OrderProductModel();
            $orderProduct->op_order_id_fk = $order->ord_id; // ID do pedido
            $orderProduct->op_product_id_fk = $product['id'];
            $orderProduct->op_product_quantity = $product['quantity'];
            $orderProduct->save();
        }

        return response()->json(['success' => true, 'message' => 'Pedido criado com sucesso!']);
    }
}
