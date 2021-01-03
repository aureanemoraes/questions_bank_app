@extends('adminlte::page')

@section('title', 'Caderno de Questões - Detalhes')

@section('css')
@stop

@section('content_header')
    <h1>Caderno de questões {{$caderno_questao->id}} - Detalhes</h1>
@stop

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{!! nl2br(e($caderno_questao->titulo)) !!}</h3>
                <h4 class="text-muted">{!! nl2br(e($caderno_questao->informacoes_adicionais)) !!}</h4>
            </div>
            <div class="card-body">
                <div class="info-box">
                    <div class="info-box-content">
                        <span class="info-box-text">Privacidade</span>
                        <span class="info-box-number">{{$caderno_questao->privacidade}}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Data inicial</span>
                                <span class="info-box-number">{{date('d/m/Y', strtotime($caderno_questao->data_inicial))}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Data final</span>
                                <span class="info-box-number">{{date('d/m/Y', strtotime($caderno_questao->data_final))}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Duração</span>
                                <span class="info-box-number">{{$caderno_questao->duracao}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Quantidade de questões</span>
                                <span class="info-box-number">{{$caderno_questao->quantidade_questoes}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Nota máxima</span>
                                <span class="info-box-number">{{$caderno_questao->nota_maxima}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Tipo</span>
                                <span class="info-box-number">{{$caderno_questao->tipo}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Categoria</span>
                                <span class="info-box-number">{{$caderno_questao->categoria}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h5>Questões</h5>
                        @if(count($caderno_questao->questoes) > 0)
                            @foreach($caderno_questao->questoes as $questao)
                                <div class="card bg-gradient-info">
                                    <div class="card-header">
                                        <h5 class="card-title">{!! nl2br(e($questao->comando)) !!}</h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach($questao->opcoes as $opcao)
                                            <p>{!! nl2br(e($opcao->texto)) !!}</p>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        <button>Ver</button>
                                        <button>Remover</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Ainda não possui questões.</p>
                        @endif
                    </div>
                    <a href="{{route('questoes.index')}}" class="small-box-footer">
                        Procurar questão <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    <a href="{{route('questoes.create')}}" class="small-box-footer">
                        Criar questão <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>

            </div>
            <div class="card-footer">
                <a type="button" class="btn btn-sm btn-warning" href="{{route('cadernos_questoes.edit', $caderno_questao)}}">Editar</a>
            </div>  
        </div>
    </div>
@stop


@section('js')
@stop