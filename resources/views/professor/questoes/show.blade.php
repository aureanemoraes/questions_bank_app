@extends('adminlte::page')

@section('title', 'Questões')

@section('css')
<style>
    .row {
        margin: 4px;
        border-radius: 4px;
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


</style>
@stop

@section('content_header')
    <h1>Questão {{$questao->id}}</h1>
@stop

@section('content')

<div class="card bg-indigo">
  <div class="card-body">
    <div class="container-fluid">
        <div class="row">
            {{$questao->comando}}
        </div>
        @php
            $letra = 'a';
        @endphp
        @foreach($questao->opcoes as $opcao)
        @if($opcao->correta)
            <div class="row bg-olive">
                <div class="col-2"><strong>{{$letra}})</strong></div>
                <div class="col-8">{{$opcao->texto}}</div>
                <div class="col-2"><i class="fas fa-check-circle"></i></div>
            </div>
        @else
            <div class="row bg-purple">
                <div class="col-2"><strong>{{$letra}})</strong></div>
                <div class="col-8">{{$opcao->texto}}</div>
                <div class="col-2"></div>
            </div>
        @endif
        
        @php
            $letra++;
        @endphp
        @endforeach
        
    </div>
  </div>
  <div class="card-footer">
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

@stop


@section('js')
    <script></script>
@stop