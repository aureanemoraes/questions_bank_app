@extends('adminlte::page')

@section('title', 'Questões - Nova')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .input-group-text {
            width: 100px;
        }  
        .has-error ~ .select2 .select2-selection {
  border: 1px solid red !important;
}  </style>
@stop

@section('content_header')
    <h1>Nova Questão</h1>
@stop

@section('content')
    <form action="{{route('questoes.store')}}" method="POST" enctype="multipart/form-data" id="nova_questao">
        @csrf
        <div class="form-group mb-3">
            <div class="input-group-prepend">
                <label for="Comando">Comando*</label>
            </div>
            <textarea name="comando" class="form-control" aria-label="Comando" rows="6"></textarea>
        </div>

        <div class="custom-file mb-3">
            <input name="imagens[]" type="file" class="custom-file-input" id="imagens" multiple>
            <label class="custom-file-label" for="imagens" data-browse="Procurar">Selecione as imagens...</label>
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
@stop

@section('js')
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

    $('#nova_questao').validate({
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

    function salvarNovoAssunto() {
        $.ajax({
            type: "POST",
            url: '/api/assuntos',
            data: {nome: $('#nome_novo_assunto').val()},
            success: function() {
                carregarOpcoes('/api/assuntos', 'assunto_id');
                $('#novo_assunto').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Assunto criado com sucesso!',
                });
            },
        });
    }

    // Função para incrementar caractere do alfabeto
    function nextChar(character) {
        return String.fromCharCode(character.charCodeAt(0) + 1);
    }

    function escolherTipoOpcao(opcao, div_id, i, letra, tipo_resposta) {
        if(opcao == 'texto') {
            if(tipo_resposta == 'Única Escolha') $(div_id).replaceWith(opcaoUnicaEscolha(i, letra, opcao));
            if(tipo_resposta == 'Múltipla Escolha') $(div_id).replaceWith(opcaoMultiplaEscolha(i, letra, opcao));
        }
        if(opcao == 'imagem') {
            if(tipo_resposta == 'Única Escolha') $(div_id).replaceWith(opcaoUnicaEscolha(i, letra, opcao));
            if(tipo_resposta == 'Múltipla Escolha') $(div_id).replaceWith(opcaoMultiplaEscolha(i, letra, opcao));
        }
    }

    function opcaoUnicaEscolha(i, letra, tipo) {
        if(tipo == 'texto') {
            let html = `
            <div class='input-group mb-3' id='opcao_${i}'> 
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Texto</a>
                        <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Imagem</a>
                    </div>
                </div>
                <textarea class='form-control' name='opcoes[${i}][texto]' placeholder='Alternativa ${letra}'></textarea>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>
                        <input type='radio' name='correta' value=${i}>
                    </span>
                </div>
            </div>`;

            return html;
        }
        if(tipo == 'imagem') {
            let html = `
            <div class='input-group mb-3' id='opcao_${i}'> 
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Texto</a>
                        <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Imagem</a>
                    </div>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="imagem_${i}" name="imagem_${i}">
                    <label class="custom-file-label" for="imagem_${i}" id="imagem_${i}_label" data-browse="Procurar">Selecione a imagem...</label>
                </div>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>
                        <input type='radio' name='correta' value=${i}>
                    </span>
                </div>
            </div>`;
            return html;
        }   
    }

    function opcaoMultiplaEscolha(i, letra, tipo) {
        if(tipo == 'texto') {
            let html = `
            <div class='input-group mb-3' id='opcao_${i}'> 
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Texto</a>
                        <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Imagem</a>
                    </div>
                </div>
                <textarea class='form-control' name='opcoes[${i}][texto]' placeholder='Alternativa ${letra}'></textarea> 
                <div class='input-group-prepend'>
                    <span class='input-group-text'>
                        <input type='checkbox' name='opcoes[${i}][correta]'> 
                    </span>
                </div>
            </div>`;

            return html;
        }
        if(tipo == 'imagem') {
            let html = `
            <div class='input-group mb-3' id='opcao_${i}'> 
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Texto</a>
                        <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Imagem</a>
                    </div>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="imagem_${i}" name="imagem_${i}">
                    <label class="custom-file-label" for="imagem_${i}" id="imagem_${i}_label" data-browse="Procurar">Selecione a imagem...</label>
                </div>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>
                        <input type='checkbox' name='opcoes[${i}][correta]'> 
                    </span>
                </div>
            </div>`;
            return html;
        }
    }
  
    // opcoes
    $("#tipo_resposta").change(
        function() {
            let tipo_resposta = $('#tipo_resposta').val();

            if(tipo_resposta == 'Única Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                    opcoes = opcoes + opcaoUnicaEscolha(i, letra, 'texto');
                    letra = nextChar(letra);
                }
                $("#opcoes_container" ).html("<label>Opções</label>" + opcoes);
                
            } else if(tipo_resposta == 'Múltipla Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                    opcoes = opcoes + opcaoMultiplaEscolha(i, letra, 'texto');
                    letra = nextChar(letra);
                }
                $("#opcoes_container" ).html("<label>Opções</label>" + opcoes);
            } else {
                $("#opcoes_container" ).html( "");
            }
        }
    );

    // exibindo as imagens selecionadas
    $('.custom-file input').change(function (e) {
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));
    });

    $("#opcoes_container").on('change', '.custom-file input', function(){
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));
    });
    // fim: exibindo as imagens selecionadas

    $(function() {
        // tipo resposta
        $("#tipo_resposta").select2({
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
                    id: '',
                    text: 'Selecione...',
                    selected: true,
                    disabled: true
                },
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