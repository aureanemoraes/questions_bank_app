@extends('adminlte::page')

@section('title', 'Questões')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .input-group-text {
            width: 100px;
        }  
    </style>
@stop

@section('content_header')
    <h1>Nova Questão</h1>
@stop

@section('content')
    <form action="{{route('questoes.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Comando*</span>
            </div>
            <textarea name="comando" class="form-control" aria-label="Comando" rows="6"></textarea>
        </div>

        <div class="custom-file mb-3">
            <input name="imagens" type="file" class="custom-file-input" id="imagens">
            <label class="custom-file-label" for="imagens" data-browse="Procurar">Selecione as imagens</label>
        </div>
        
        <div class="alert alert-info" role="alert">
            Por padrão as imagens serão legendadas como: "Figura 1", "Figura 2" e assim sucessivamente. É possível editar a legenda na opção "Editar Questão".
        </div>

        <div class="form-group">
            <label for="tipo_resposta">Tipo de resposta*</label>
            <select class="form-control" id="tipo_resposta" name="tipo_resposta">
            </select>
        </div>

        <div class="form-group">
            <label for="nivel_dificuldade">Nível de dificuldade*</label>
            <select class="form-control" id="nivel_dificuldade" name="nivel_dificuldade">
                <option value="Fácil">Fácil</option>
                <option value="Intermediário">Intermediário</option>
                <option value="Difícil">Difícil</option>
            </select>
        </div>

        <div class="form-group">
            <label for="matriz_id">Matriz*</label>
            <select class="form-control" id="matriz_id" name="matriz_id">
            </select>
        </div>

        <div class="form-group">
            <label for="componente_id">Componente*</label>
            <select class="form-control" id="componente_id" name="componente_id">
            </select>
        </div>

        <div class="form-group">
            <label for="assunto_id">Assunto*</label>
            <select class="form-control" id="assunto_id" name="assunto_id">
            </select>
            <!-- Novo assunto -->
            <a type="button" class="btn btn-link" role="button" data-toggle="modal" data-target="#novo_assunto">
                Novo assunto
            </a>
        </div>

        <div id="opcoes_container"></div>
        
        <a type="button" class="btn btn-default">Cancelar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>


    <!-- Modal: novo assunto -->
    <div class="modal fade" id="novo_assunto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="novo_assunto_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novo_assunto_label">Novo assunto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="novo_assunto_input">Nome</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="novo_assunto_input" id="nome_novo_assunto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="salvarNovoAssunto()">Salvar</button>
            </div>
            </div>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" >
        <!-- Position it -->
        <div style="position: absolute; top: 0; right: 0;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="assunto_salvo_sucesso" data-autohide="false">
                <div class="toast-header">
                    <i class="fas fa-check-square" style="margin: 2px;color:green"></i>
                    <strong class="mr-auto" style="color:green">Sucesso!</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    Novo assunto adicionado.
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>

    // função
    function carregarOpcoes(url, id) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(opcoes) {
                $(`#${id}`).select2({
                    theme: 'classic',
                    width: '100%',
                    height: '100%',
                    data: opcoes
                });
            }
        });
    }

    function salvarNovoAssunto() {
        $.ajax({
            type: "POST",
            url: '/api/assuntos',
            data: {nome: $('#nome_novo_assunto').val()},
            success: function() {
                carregarOpcoes('/api/assuntos', 'assunto');
                $('#assunto_salvo_sucesso').toast('show');
                $('#novo_assunto').modal('hide');

            },
        });
    }

    // Função para incrementar caractere do alfabeto
    function nextChar(character) {
        return String.fromCharCode(character.charCodeAt(0) + 1);
    }

    // opcoes
    $("#tipo_resposta").change(
        function() {
            let tipo_resposta = $('#tipo_resposta').val();

            if(tipo_resposta == 'Única Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                        opcoes = opcoes + "<div class='input-group mb-3'>" +
                            `<textarea class='form-control' name='opcoes[${i}][texto]' placeholder='Alternativa ${letra}'></textarea>` +
                            "<div class='input-group-prepend'>" +
                                "<span class='input-group-text'>" +
                                    `<input type='radio' name='correta' value=${i}>` +
                                "</span>" +
                            "</div>" +
                        "</div>" +
                    "</div>";
                    letra = nextChar(letra);
                }
                $("#opcoes_container" ).html("<label>Opções</label>" + opcoes);
            } else if(tipo_resposta == 'Múltipla Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                    opcoes = opcoes + "<div class='input-group mb-3'>" +
                            `<textarea class='form-control' name='opcoes[${i}][texto]' placeholder='Alternativa ${letra}'></textarea>` +
                            "<span class='input-group-text'>" +
                                `<input type='checkbox' name='opcoes[${i}][correta]'>` +
                            "</span>" +
                        "</div>" +
                    "</div>";
                    letra = nextChar(letra);
                }
                $("#opcoes_container" ).html("<label>Opções</label>" + opcoes);
            } else {
                $("#opcoes_container" ).html( "");
            }
        }
    );

    $(function() {
        // tipo resposta
        $("#tipo_resposta").select2({
            theme: 'classic',
            width: '100%',
            height: '100%',
            data: [
                {
                    id: 'Discursiva',
                    text: 'Discursiva'
                },
                {
                    id: 'Única Escolha',
                    text: 'Única Escolha'
                },
                {
                    id: 'Múltipla Escolha',
                    text: 'Múltipla Escolha'
                },
            ]
        });

        // nível de dificuldade
        $("#nivel_dificuldade").select2({
            theme: 'classic',
            width: '100%',
            height: '100%',
            data: [
                {
                    id: 'Fácil',
                    text: 'Fácil'
                },
                {
                    id: 'Intermediário',
                    text: 'Intermediário'
                },
                {
                    id: 'Difícil',
                    text: 'Difícil'
                },
            ]
        });
        carregarOpcoes('/api/matrizes', 'matriz_id');
        carregarOpcoes('/api/componentes', 'componente_id');
        carregarOpcoes('/api/assuntos', 'assunto_id');
    });
</script>
@stop