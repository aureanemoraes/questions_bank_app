@extends('adminlte::page')

@section('title', 'Questões - Detalhes')

@section('css')
    <style>
        .row {
            margin: 4px;
            border-radius: 4px;
            padding: 4px;
        }
        .container-fluid {
            max-width: 800px;
        }

        .col-2 {
            text-align: right;
        }

        button {
            margin: 2px;        
        }

        .opcao-correta {
            background: green;
        }

        .letter {
            width: fit-content;
        }

        .detalhes {
            margin: 2px;
        }

        .img {
            max-width: 350px;
            max-height: 350px;
            border: 4px solid white;
        }

        .info-box-icon {
            width: fit-content !important;
            height: fit-content !important;
        }


    </style>
@stop

@section('content_header')
    <h1>Questão {{$questao->id}} - Detalhes</h1>
@stop

@section('content')
<div class="container">
    @if(($questao->tipo_resposta == 'Única Escolha') && ($opcoes_corretas > 1))
    <div class="alert alert-danger" role="alert">
        Esta questão possui mais de uma alternativa correta. Por favor, mude o tipo de resposta para múltipla escolha ou selecione apenas uma alternativa correta.
    </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{!! nl2br(e($questao->comando)) !!}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Tipo de resposta</span>
                            <span class="info-box-number">{{$questao->tipo_resposta}}</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Nível de dificuldade</span>
                            <span class="info-box-number">{{$questao->nivel_dificuldade}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Matriz</span>
                            <span class="info-box-number">{{$questao->matriz->nome}}</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Componente</span>
                            <span class="info-box-number">{{$questao->componente->nome}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Assunto</span>
                            <span class="info-box-number">{{$questao->assunto->nome}}</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Área de conhecimento (ENEM)</span>
                            <span class="info-box-number">{{$questao->area_conhecimento->nome}}</span>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($questao->imagens as $imagem)
                <div class="info-box">
                    <span class="info-box-icon">
                        <img src="{{ asset("imagens/questoes/$imagem->caminho") }}" alt="{{ asset("imagens/questoes/$imagem->caminho") }}" class="img">
                    </span>
                    <div class="info-box-content">
                        
                        
                        <span class="info-box-number">{{$imagem->legenda}}</span>
                    </div>
                </div>
            @endforeach
            @php
                $letra = 'a';
            @endphp
            @foreach($questao->opcoes as $opcao)
            @if($opcao->correta)
                <div class="row bg-lime">
                    <div class="col-2"><strong>{{$letra}})</strong></div>
                    @if(file_exists(public_path() . '/imagens/opcoes/' . $opcao->texto))
                        <div class="col-8"><img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="a" class="img"></div>
                        <div class="col-2"><i class="fas fa-check-circle"></i></div>
                    @else
                        <div class="col-8">{!! nl2br(e($opcao->texto)) !!}</div>
                        <div class="col-2"><i class="fas fa-check-circle"></i></div>
                    @endif
                </div>
            @else
                <div class="row bg-info">
                    <div class="col-2"><strong>{{$letra}})</strong></div>
                    @if(file_exists(public_path() . '/imagens/opcoes/' . $opcao->texto))
                        <div class="col-8"><img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="a" class="img"></div>
                        <div class="col-2"></div>
                    @else
                        <div class="col-8">{!! nl2br(e($opcao->texto)) !!}</div>
                        <div class="col-2"></div>
                    @endif
                    
                </div>
            @endif
            @php
                $letra++;
            @endphp
            @endforeach
            <div class="row">
                <div class="col-auto bg-orange detalhes">{{$questao->tipo_resposta}}</div>
                <div class="col-auto bg-orange detalhes">{{$questao->nivel_dificuldade}}</div>
                <div class="col-auto bg-orange detalhes">{{$questao->matriz->nome}}</div>
                <div class="col-auto bg-orange detalhes">{{$questao->componente->nome}}</div>
                <div class="col-auto bg-orange detalhes">{{$questao->assunto->nome}}</div>
                <div class="col-auto bg-orange detalhes">{{$questao->area_conhecimento->nome}}</div>
            </div>
        </div>    
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <a type="button" class="btn btn-sm btn-warning" href="{{route('questoes.edit', $questao)}}">Editar</a>
                </div>
                <div class="col" align="right">
                    <a type="button" class="btn btn-sm text-info" href="">Adicionar</a>
                </div>
            </div>
        </div>  
    </div>
</div>
@stop


@section('js')
    <script></script>
@stop