@extends('adminlte::page')

@section('title', 'Cadernos de questões - Novo')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    
    <style></style>
@stop

@section('content_header')
    <h1>Novao Caderno de questões</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('cadernos_questoes.store')}}" method="POST" enctype="multipart/form-data" id="novo_cq">
            @csrf
            <!-- CQ -->
            <div class="form-group mb-3">
                <div class="input-group-prepend">
                    <label for="titulo">Título*</label>
                </div>
                <textarea name="titulo" id="titulo" class="form-control" aria-label="titulo" rows="2" placeholder="Título..."></textarea>
            </div>

            <div class="form-group mb-3">
                <div class="input-group-prepend">
                    <label for="informacoes_adicionais">Informações adicionais</label>
                </div>
                <textarea name="informacoes_adicionais" id="informacoes_adicionais" class="form-control" aria-label="informacoes_adicionais" rows="4" placeholder="Informações adicionais..."></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="privacidade">Privacidade*</label>
                <select class="form-control" id="privacidade" name="privacidade">
                </select>
            </div>

            <div class="form-group mb-3" id="alunos_selecionados"></div>

            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="data_inicial">Data inicial*</label>
                        </div>
                        <input type="text" name="data_inicial" id="data_inicial" class="form-control" aria-label="data_inicial" placeholder="Data inicial..." />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="data_final">Data Final*</label>
                        </div>
                        <input type="text" name="data_final" id="data_final" class="form-control" aria-label="data_final" placeholder="Data final..."/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="duracao">Duração*</label>
                        </div>
                        <input type="text" name="duracao" id="duracao" class="form-control" aria-label="duracao" placeholder="Duração..."/>
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
                        <input type="number" name="quantidade_questoes" id="quantidade_questoes" class="form-control" aria-label="quantidade_questoes" placeholder="Quantidade de questões..."/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <div class="input-group-prepend">
                            <label for="nota_maxima">Nota máxima*</label>
                        </div>
                        <input type="number" name="nota_maxima" id="nota_maxima" class="form-control" aria-label="nota_maxima" placeholder="Nota máxima..."/>
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

            <div class="form-group mb-3" align="right">
                <a type="button" class="btn btn-default">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar e continuar</button>
            </div>
            <!-- CQ -->
        </form>
    </div>

@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    
<script>
        // Validação
        jQuery.validator.setDefaults({
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            }
        });

        $('#novo_cq').validate({
            rules: {
                titulo: "required",
                privacidade: "required",
                data_inicial: "required",
                data_final: "required",
                duracao: "required",
                quantidade_questoes: "required",
                nota_maxima: "required",
                tipo: "required",
                categoria: "required",
            },
            messages: {
                titulo: "Por favor, insira um <b>título</b>.",
                privacidade: "Por favor, selecione uma <b>privacidade</b>.",
                data_inicial: "Por favor, selecione uma <b>data inicial</b>.",
                data_final: "Por favor, selecione uma <b>data final</b>.",
                duracao: "Por favor, selecione uma <b>duracao</b>.",
                quantidade_questoes: "Por favor, insira uma <b>quantidade de questões</b>.",
                nota_maxima: "Por favor, insira uma <b>nota máxima</b>.",
                tipo: "Por favor, selecione um <b>tipo</b>.",
                categoria: "Por favor, selecione uma <b>categoria</b>.",

            }
        });

        // variaveis
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

        //funçoes
        function carregarOpcoes(url, id) {
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    let opcoes = [];
                    data.forEach(element => {
                        opcoes.push({
                            id: element.id,
                            text: `${element.cpf} - ${element.name}`
                        });
                    });
                    
                    $(`#${id}`).select2({
                        placeholder: 'Selecione...',
                        theme: 'classic',
                        width: '100%',
                        height: '100%',
                        multiple: true,
                        data: opcoes
                    });
                }
            });
        }

        //onchange
        $('#privacidade').on('change', function() {
            let privacidade_selecionada = $('#privacidade').val();
            if(privacidade_selecionada == 'Restrito') {
                $('#alunos_selecionados').html(`
                    <label for="alunos">Alunos*</label>
                    <select class="form-control" id="alunos" name="alunos">
                    </select>
                `);
                carregarOpcoes('/api/alunos', 'alunos');
            } else {
                $('#alunos_selecionados').html('');
            }
        });

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

        $('#data_inicial, #data_final, #duracao').val('');

        $(function() {
            // Privacidade
            $("#privacidade").select2({
                theme: 'classic',
                width: '100%',
                height: '100%',
                data: [
                    {
                        id: '',
                        text: 'Selecione...',
                        selected: true,
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
                ]
            });
            // Tipo
            $("#tipo").select2({
                theme: 'classic',
                width: '100%',
                height: '100%',
                data: [
                    {
                        id: '',
                        text: 'Selecione...',
                        selected: true,
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
                ]
            });
            // Tipo
            $("#categoria").select2({
                theme: 'classic',
                width: '100%',
                height: '100%',
                data: [
                    {
                        id: '',
                        text: 'Selecione...',
                        selected: true,
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
                ],
            });
        });
    </script>
@stop