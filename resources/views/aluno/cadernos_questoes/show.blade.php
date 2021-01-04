@extends('adminlte::page')

@section('title', 'Caderno de Questões - Detalhes')

@section('css')
@stop

@section('content_header')
@stop

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Caderno de questões {{$caderno_questao->id}} - Detalhes</h3>
            </div>
            <div class="card-body">
                <div class="info-box">
                    <div class="info-box-content">
                        <span class="info-box-number">{!! nl2br(e($caderno_questao->titulo)) !!}</span>
                        <span><em>{!! nl2br(e($caderno_questao->informacoes_adicionais)) !!}</em></span>
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

            </div>
            <div class="card-footer">
                @if($caderno_questao->pivot->situacao == 'aberto')
                    <a type="button" class="btn btn-success" onclick="iniciarAvaliacao({{$caderno_questao->id}})">Iniciar</a>
                @elseif($caderno_questao->pivot->situacao == 'iniciado')
                    <a type="button" class="btn btn-warning" onclick="iniciarAvaliacao({{$caderno_questao->id}})">Continuar</a>
                @endif
            </div>  
        </div>
    </div>

@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function iniciarAvaliacao(caderno_questao_id) {
            Swal.fire({
                title: 'Confirmação',
                text: "Ao prosseguir, você confirma que leu todas as instruções e está pronto para iniciar avaliação.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK!',
                cancelButtonText: 'Não confirmo.'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`/estudante/responder/caderno_questao/${caderno_questao_id}`, '_blank');
                }
            })
        }
    </script>
@stop