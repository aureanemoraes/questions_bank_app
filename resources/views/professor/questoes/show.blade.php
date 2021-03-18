@extends('adminlte::page')

@section('title', 'Questões - Detalhes')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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
            border: 1px solid black;
        }

        .info-box-icon {
            width: fit-content !important;
            height: fit-content !important;
        }

        .icon {
            width: 4px !important;
            height: 4px !important;
        }

        .small-box {
            height: fit-content !important;
        }

        .row {
            vertical-align: middle;
        }


    </style>
@stop

@section('content_header')
    <h1>Questão {{$questao->id}} - Detalhes</h1>
@stop

@section('content')
<div class="container">
    <input type="hidden" id="questao_id" value="{{$questao->id}}">
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
                <div class="row">
                    <div class="col">
                        @if(file_exists(public_path() . '/imagens/opcoes/' . $opcao->texto))
                            <p>{{$letra}}) <img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="a" class="img" width="80px" height="80px"/></p>
                        @else
                            <p>{{$letra}}) {!! nl2br(e($opcao->texto)) !!}</p>
                        @endif
                    </div>
                    <div class="col-1">
                        <i class="fas fa-check-circle" style="color: mediumseagreen"></i>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col">
                        @if(file_exists(public_path() . '/imagens/opcoes/' . $opcao->texto))
                            <p>{{$letra}}) <img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="a" width="100px" height="50px"/></p>
                        @else
                            <p>{{$letra}}) {!! nl2br(e($opcao->texto)) !!}</p>
                        @endif
                    </div>
                    <div class="col-1">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            @endif

            @php
                $letra++;
            @endphp
            @endforeach
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informações adicionais</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
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
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if($questao->user_id == auth()->user()->id)
                <a type="button" class="btn btn-warning" href="{{route('questoes.edit', $questao)}}">Editar</a>
            @endif
        </div>
        <div class="col" align="right">
            <a type="button" class="btn btn-primary" onclick="adicionarEmUmCqModal()"><i class="fas fa-plus-circle"></i> Caderno de questões</a>
        </div>
    </div>
</div>

    <!-- Modal: genérico -->
    <div class="modal fade" id="modal_generico" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_generico_label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_generico_label"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_generico_body">
                </div>
                <div class="modal-footer" id="modal_generico_footer">
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{auth()->user()->id}}" id="user_id">
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // funcão
        function adicionarEmUmCq() {
            // Esta questão já está adicionada ao cq 0
            // O caderno de questões já atingiu o limite de questões. -1
            let cq_id = $('#caderno_questao_select').val();
            let questao_id = $('#questao_id').val();

            $.ajax({
                type: 'POST',
                url: `/api/cadernos_questoes`,
                data: {
                    cq_id: cq_id,
                    questao_id: questao_id
                },
                success: function(data) {
                    if(data == 1) {
                        // redirecionar para show caderno questao
                        Swal.fire(
                            'Sucessso!',
                            'Questão adicionada ao caderno de questões com sucesso.',
                            'success'
                        );

                        setTimeout(function() {
                            window.location.href=`/cadernos_questoes/${cq_id}`
                        }, 1000);
                    } else if(data == 0) {
                        Swal.fire(
                            'Falha!',
                            'Esta questão já está adicionada ao caderno de questões.',
                            'error'
                        );
                    } else {
                        Swal.fire(
                            'Falha!',
                            'O quantidade limite de questões para este caderno já foi atingida.',
                            'error'
                        );
                    }
                },
            });
        }

        function adicionarEmUmCqModal() {
            $('#modal_generico_label').html('Adicionar a um caderno de questões');
            $('#modal_generico_body').html(`
                <div class="form-group">
                    <label for="caderno_questao_select">Selecione o caderno de questão*</label>
                    <select class="form-control" id="caderno_questao_select" aria-describedby="cq_help"></select>
                    <small id="cq_help" class="form-text text-muted">Aqui estão listados todos os cadernos de questões que você criou, ordenado a partir do mais recentemente.</small>
                </div>
            `);
            $('#modal_generico_footer').html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="adicionarEmUmCq()">Salvar</button>
            `);

            let user_id = $('#user_id').val();

            $.ajax({
                type: 'GET',
                url: `/api/cadernos_questoes/${user_id}`,
                success: function(data) {
                    $(`#caderno_questao_select`).select2({
                        theme: 'classic',
                        width: '100%',
                        height: '100%',
                        data: [{
                            id: '',
                            text: 'Selecione...',
                            selected: true,
                            disabled: true
                        }, ...data]
                    });
                },
            });

            $('#modal_generico').modal('show');

        }
    </script>
@stop
