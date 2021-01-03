@extends('adminlte::page')

@section('title', 'Cadernos de Questões - Edição')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
    </style>
@stop

@section('content_header')
    <h1>Editar Cadernos de Questões</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('cadernos_questoes.update', $caderno_questao)}}" method="POST" enctype="multipart/form-data" id="editar_cq">
            @csrf
            @method('put')
            <input type="hidden" id="caderno_questao" value="{{$caderno_questao}}">
            <div class="form-group mb-3">
                <div class="input-group-prepend">
                    <label for="titulo">Título*</label>
                </div>
                <textarea name="titulo" class="form-control" aria-label="titulo" rows="4" placeholder="Título...">{{$caderno_questao->titulo}}</textarea>
            </div>

            <div class="form-group mb-3">
                <div class="input-group-prepend">
                    <label for="informacoes_adicionais">Informações adicionais</label>
                </div>
                <textarea name="informacoes_adicionais" id="informacoes_adicionais" class="form-control" aria-label="informacoes_adicionais" rows="4" placeholder="Informações adicionais...">{{$caderno_questao->informacoes_adicionais}}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="privacidade">Privacidade*</label>
                <select class="form-control" id="privacidade" name="privacidade">
                </select>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="data_inicial">Data inicial*</label>
                        </div>
                        <input type="text" name="data_inicial" id="data_inicial" class="form-control" aria-label="data_inicial" placeholder="Data inicial..." value="{{date('d/m/Y', strtotime($caderno_questao->data_inicial))}}"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="data_final">Data Final*</label>
                        </div>
                        <input type="text" name="data_final" id="data_final" class="form-control" aria-label="data_final" placeholder="Data final..." value="{{date('d/m/Y', strtotime($caderno_questao->data_inicial))}}"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="duracao">Duração*</label>
                        </div>
                        <input type="text" name="duracao" id="duracao" class="form-control" aria-label="duracao" placeholder="Duração..." value="{{$caderno_questao->duracao}}"/>
                        <small class="form-text text-muted">Tempo de duração que o aluno terá para finalizar o caderno de questões.</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="quantidade_questoes">Quantidade de questões*</label>
                        </div>
                        <input type="number" name="quantidade_questoes" id="quantidade_questoes" class="form-control" aria-label="quantidade_questoes" placeholder="Quantidade de questões..." value="{{$caderno_questao->quantidade_questoes}}"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="nota_maxima">Nota máxima*</label>
                        </div>
                        <input type="number" name="nota_maxima" id="nota_maxima" class="form-control" aria-label="nota_maxima" placeholder="Nota máxima..." value="{{$caderno_questao->nota_maxima}}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="tipo">Tipo*</label>
                        <select class="form-control" id="tipo" name="tipo">
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="categoria">Categoria*</label>
                        <select class="form-control" id="categoria" name="categoria">
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="questoes_automaticas" disabled>
                <label class="form-check-label" for="questoes_automaticas">
                    Selecionar questões automaticamente
                </label>
            </div>
            
            <div class="form-group mb-3">
                <div class="row">
                    <div class="col">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> Voltar</a>
                    </div>
                    <div class="col" align="right">
                        <button type="submit" class="btn btn-primary"> Salvar  <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal: genérico -->
    <div class="modal fade" id="modal_generico" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_generico_label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_generico_label">Alterar legenda</h5>
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
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
   
    jQuery.validator.setDefaults({
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        }
    });

    $('#editar_questao').validate({
        rules: {
            comando: "required",
            tipo_resposta: "required",
            nivel_dificuldade: "required",
            matriz_id: "required",
            componente_id: "required",
            assunto_id: "required",
        },
        messages: {
            comando: "Por favor, insira um <b>comando</b>.",
            tipo_resposta: "Por favor, selecione um <b>tipo de resposta</b>.",
            nivel_dificuldade: "Por favor, selecione um <b>nível de dificuldade</b>.",
            matriz_id: "Por favor, selecione uma <b>matriz</b>.",
            componente_id: "Por favor, selecione um <b>vomponente</b>.",
            assunto_id: "Por favor, selecione um <b>assunto</b>.",
        }
    });

    let pt_br_daterangepicker = {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "daysOfWeek": [
        "Dom",
        "Seg",
        "Ter",
        "Qua",
        "Qui",
        "Sex",
        "Sab"
        ],
        "monthNames": [
        "Janeiro",	
        "Fevereiro",
        "Março",
        "Abril",
        "Maio",
        "Junho",
        "Julho",
        "Agosto",
        "Setembro",
        "Outubro",
        "Novembro",
        "Dezembro"
        ],
        "firstDay": 1
    };
    // data inicial data final
    $('#data_inicial, #data_final').daterangepicker({
        "locale": pt_br_daterangepicker,
        singleDatePicker: true,
    });

    // duracao
    $('#duracao').daterangepicker({
        timePicker : true,
        singleDatePicker:true,
        timePicker24Hour : true,
        timePickerIncrement : 1,
        timePickerSeconds : true,
        locale : {
            format : 'HH:mm:ss',
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar"
        }
    }).on('show.daterangepicker', function(ev, picker) {
        picker.container.find(".calendar-table").hide();
    });


    let questao = JSON.parse($('#caderno_questao').val());

    // função
    function carregarOpcoes(url, id) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(opcoes) {
                opcoes.forEach(element => {
                    if(element.id == questao[id]) {
                        element.selected = true;
                    }
                });

                $(`#${id}`).select2({
                    theme: 'classic',
                    width: '100%',
                    height: '100%',
                    data: [{
                        id: '',
                        text: 'Selecione...',
                        selected: true,
                        disabled: true
                    }, ...opcoes]
                });
            }
        });
    }


    $(function() {
        // Privacidade
        let privacidade_data = [
            {
                id: '',
                text: 'Selecione...',
                disabled: true
            },
            {
                id: 'Público',
                text: 'Público'
            },
            {
                id: 'Restrito',
                text: 'Restrito'
            }
        ];

        privacidade_data.forEach(element => {
            if(element.text == caderno_questao.privacidade) {
                element.selected = true;
            }
        });

        $("#privacidade").select2({
            theme: 'classic',
            width: '100%',
            height: '100%',
            data: privacidade_data
        });

        // tipo
        let tipo_data = [
            {
                id: '',
                text: 'Selecione...',
                disabled: true
            },
            {
                id: 'Simulado',
                text: 'Simulado'
            },
            {
                id: 'Prova',
                text: 'Prova'
            }
        ];

        tipo_data.forEach(element => {
            if(element.text == caderno_questao.tipo) {
                element.selected = true;
            }
        });

        $("#tipo").select2({
            theme: 'classic',
            width: '100%',
            height: '100%',
            data: tipo_data
        });

        // categoria
        let categoria_data =  [
            {
                id: '',
                text: 'Selecione...',
                disabled: true
            },
            {
                id: '',
                text: "ENEM",
                children: [
                    {
                        id: 'ENEM - LINGUAGENS, CÓDIGO E SUAS TECNOLOGIAS',
                        text: 'LINGUAGENS, CÓDIGO E SUAS TECNOLOGIAS'
                    },
                    {
                        id: 'ENEM - CIÊNCIAS NATURAIS E SUAS TECNOLOGIAS',
                        text: 'CIÊNCIAS NATURAIS E SUAS TECNOLOGIAS'
                    },
                    {
                        id: 'ENEM - CIÊNCIAS HUMANAS E SUAS TECNOLOGIAS',
                        text: 'CIÊNCIAS HUMANAS E SUAS TECNOLOGIAS' 
                    }
                ],
            },
            {
                id: '',
                text: "EJA",
                children: [
                    {
                        id: 'EJA - 1ª Etapa',
                        text: '1ª Etapa'
                    },
                    {
                        id: 'EJA - 2ª Etapa',
                        text: '2ª Etapa'
                    }
                ],
            },     
        ];

        categoria_data.forEach(element => {
            if(element.text == caderno_questao.categoria) {
                element.selected = true;
            }
        });

        $("#categoria").select2({
            theme: 'classic',
            width: '100%',
            height: '100%',
            data: categoria_data
        });

    });
</script>
@stop