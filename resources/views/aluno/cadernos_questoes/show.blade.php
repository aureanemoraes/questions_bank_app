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

                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Situacao</span>
                                @if(isset($caderno_questao->pivot->situacao))
                                    <span class="info-box-number">{{ucfirst($caderno_questao->pivot->situacao)}}</span>
                                @else
                                    <span class="info-box-number">Aberto</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Nota alcançada</span>
                                @if(isset($caderno_questao->pivot->situacao) && ($caderno_questao->pivot->situacao == 'finalizado'))
                                    <span class="info-box-number">{{$caderno_questao->pivot->nota}}</span>
                                @else
                                    <span class="info-box-number">Não avaliado</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <!-- Disponível somente se: situação estiver em 'aberto' ou 'iniciado' e, se estiver entre a data inicial e a final, e se a duração não estiver esgotada.-->
                <!-- Quando a duração esgotar, enviar o formulário.-->
                <!-- Se for um caderno público, quando o usuário clickar em iniciar avaliação, criar o registro dele natabela alunos_cadernos_questoes-->
                @php
                    if(isset($caderno_questao->pivot->started_at)) {
                        $started_at = Carbon\Carbon::parse($caderno_questao->pivot->started_at);
                        $duracao_hora = Carbon\Carbon::parse($caderno_questao->duracao)->format('H');
                        $duracao_minuto = Carbon\Carbon::parse($caderno_questao->duracao)->format('i');
                        $duracao_segundo = Carbon\Carbon::parse($caderno_questao->duracao)->format('s');
                        $duracao = Carbon\Carbon::parse($caderno_questao->duracao);

                        $started_at->addHours($duracao_hora);
                        $started_at->addMinutes($duracao_minuto);
                        $started_at->addSeconds($duracao_segundo);

                        $duracao_valida = $started_at->diffInSeconds(now(), false);


                        //$teste = $started_at + $duracao;
                        //$started_at->addHours()
                        //$diferenca_duracao = Carbon\Carbon::parse($caderno_questao->pivot->started_at)->diff(now(), false)->format('%H:%I:%S');
                        //$duracao_valida = Carbon\Carbon::parse($caderno_questao->duracao)->diffInSeconds($diferenca_duracao, false);

                    }
                    $diferenca_dias_data_inicial = Carbon\Carbon::parse($caderno_questao->data_inicial)->diffInDays(now(), false);
                    $diferenca_horas_data_inicial = Carbon\Carbon::parse($caderno_questao->data_inicial)->diffInHours(now(), false);

                    $diferenca_dias_data_final = Carbon\Carbon::parse($caderno_questao->data_final)->diffInDays(now(), false);

                @endphp

                @if(isset($diferenca_dias_data_inicial) && ($diferenca_dias_data_inicial == 0) && isset($diferenca_horas_data_inicial) && ($diferenca_horas_data_inicial > 0))
                    @if(isset($diferenca_dias_data_final) && ($diferenca_dias_data_final <= 0))
                        @if(isset($caderno_questao->pivot->started_at))
                            @if($duracao_valida < 0 )
                                @if(isset($caderno_questao->pivot->situacao) && ($caderno_questao->pivot->situacao == 'aberto'))
                                    <a type="button" class="btn btn-warning" onclick="iniciarAvaliacao({{$caderno_questao->id}}, {{auth()->user()->id}})">Continuar</a>
                                @endif
                            @endif
                        @else
                            <a type="button" class="btn btn-success" onclick="iniciarAvaliacao({{$caderno_questao->id}}, {{auth()->user()->id}})">Iniciar</a>
                        @endif
                    @endif
                @endif

               
                
            </div>  
        </div>
    </div>

@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function iniciarAvaliacao(caderno_questao_id, aluno_id) {
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
                    $.ajax({
                        type: "POST",
                        url: `/api/cadernos_questoes/${caderno_questao_id}/${aluno_id}`,
                        success: function() {
                            window.open(`/estudante/responder/caderno_questao/${caderno_questao_id}`, '_blank');
                        },
                    });
                }
            })
        }
    </script>
@stop