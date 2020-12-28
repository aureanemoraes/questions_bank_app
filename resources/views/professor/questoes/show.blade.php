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
            border: 4px solid white;
        }


    </style>
@stop

@section('content_header')
    <h1>Questão {{$questao->id}} - Detalhes</h1>
@stop

@section('content')
    <div class="card bg-primary">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    {{$questao->comando}}
                </div>
                @foreach($questao->imagens as $imagem)
                <div class="row " >
                <div class="col" align="center">
                <img src="{{ asset("imagens/questoes/$imagem->caminho") }}" alt="a" class="img"><br>
                        <em>{{$imagem->legenda}}</em>
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
                            <div class="col-8">{{$opcao->texto}}</div>
                            <div class="col-2"><i class="fas fa-check-circle"></i></div>
                        @endif
                    </div>
                @else
                    <div class="row bg-navy">
                        <div class="col-2"><strong>{{$letra}})</strong></div>
                        @if(file_exists(public_path() . '/imagens/opcoes/' . $opcao->texto))
                            <div class="col-8"><img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="a" class="img"></div>
                            <div class="col-2"></div>
                        @else
                            <div class="col-8">{{$opcao->texto}}</div>
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
        </div>      
    <div class="card-footer">
    <div class="row">
    <div class="col">
                <a type="button" class="btn btn-warning" href="">Editar</a>
            </div>
            <div class="col" align="right">
                <a type="button" class="btn btn-light" href="">Adicionar</a>
            </div>
    </div>

    </div>

@stop


@section('js')
    <script></script>
@stop