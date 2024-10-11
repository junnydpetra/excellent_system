<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientModel;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cnpj' => 'required|string|max:14',
        ]);

        $response = $this->consultaCNPJ($request->cnpj);

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao consultar CNPJ.',
            ], 400);
        }

        $client = ClientModel::create([
            'cli_api_id' => $response['porte']['id'] ?? null,
            'cli_company_name' => $response['razao_social'],
            'cli_cnpj' => $response['cnpj_raiz'],
            'cli_email' => $response['estabelecimento']['email'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente cadastrado com sucesso!',
            'client' => [
                'cli_id' => $client->cli_id,
                'api_id' => $client->cli_api_id,
                'razao_social' => $client->cli_company_name,
                'cnpj' => $client->cli_cnpj,
                'email' => $client->cli_email,
            ],
        ], 201);
    }

    public function consultaCNPJ(string $cnpj)
    {
        $url = "https://www.cnpj.ws/api/v1/cnpj/{$cnpj}";

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = ClientModel::find($id);

        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Cliente não encontrado.'], 404);
        }

        return response()->json([
            'success' => true,
            'client' => [
                'cli_id' => $client->cli_id,
                'api_id' => $client->cli_api_id,
                'razao_social' => $client->cli_company_name,
                'cnpj' => $client->cli_cnpj,
                'email' => $client->cli_email,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = ClientModel::find($id);

        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Cliente não encontrado.'], 404);
        }

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente excluído com sucesso.'
        ]);
    }
}
