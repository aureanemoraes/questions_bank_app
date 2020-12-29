<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Imagem;


class ImagemController extends Controller
{
    public function store(Request $request) {
        $imagem = Imagem::find($request->input('imagem_id'));
        $imagem->fill([
            'legenda' => $request->input('legenda')
        ]);
        $imagem->save();

        return $imagem->legenda;
    }

    public function destroy($id) {
        $imagem = Imagem::find($id);
        if($imagem) {
            $imagem->delete();
            return 1;
        }
    }
}
