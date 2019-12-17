<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NfseController extends Controller
{
    public function generate(Request $request)
    {
        $name = $request->input('name');
        // TODO colocar a mágica de gerar notas fiscais utilizando alguma biblioteca e enviar elas para o S3.
        // no retorno desse método, adicionar o status 201 caso a nota tenha sido gerada e a URL da mesma
        return response()->json('NFs-e gerada com sucesso para o cliente '.$name." através do usuário ".Auth::user()->name);
    }
}
