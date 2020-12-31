<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opcao;
use Image;

class OpcoesController extends Controller
{
    public function store($questao_id, Request $request) {
        if($request->hasFile('nova_opcao_imagem')) {
            $nome_imagem = $this->salvarImagem($request->file('nova_opcao_imagem'));
            if($request->correta) {
                $opcao = Opcao::create([
                    'texto' => $nome_imagem,
                    'questao_id' => $questao_id,
                    'correta' => true,
                    'imagem' => true
                ]);
            } else {
                $opcao = Opcao::create([
                    'texto' => $nome_imagem,
                    'questao_id' => $questao_id,
                    'correta' => false,
                    'imagem' => true
                ]);
            }
        } else {
            if($request->correta) {
                $opcao = Opcao::create([
                    'texto' => $request->nova_opcao,
                    'questao_id' => $questao_id,
                    'correta' => true,
                    'imagem' => false
                ]);
            } else {
                $opcao = Opcao::create([
                    'texto' => $request->nova_opcao,
                    'questao_id' => $questao_id,
                    'correta' => false,
                    'imagem' => false
                ]);
            }
        }

        return $opcao;
    }

    public function destroy($id) {
        $opcao = Opcao::find($id);
        if($opcao) {
            if($opcao->imagem) {
                if(file_exists(public_path("imagens/opcoes/$opcao->texto"))){
                    unlink(public_path("imagens/opcoes/$opcao->texto"));
                }
                $opcao->delete();
                return 1;
            } else {
                $opcao->delete();
                return 1;
            }
        }
    }

    private function salvarImagem($imagem) {
        $nome_imagem = time().'_'. $imagem->getClientOriginalName();
        $caminho_arquivo = public_path('imagens/opcoes') . '/' . $nome_imagem;
        // Verificando tamanho da imagem
        $height = Image::make($imagem)->height();
        $width = Image::make($imagem)->width();
        if($height > 350 || $width >350) {
            $img = Image::make($imagem->path());
            $img->resize(350, 350, function ($const) {
                $const->aspectRatio();
            })->save($caminho_arquivo);
        } else {
            $img = Image::make($imagem->path())->save($caminho_arquivo); 
        }

        return $nome_imagem;        
    }
}
