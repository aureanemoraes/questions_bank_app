@extends('adminlte::page')

@section('title', 'Questões - Edição')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .input-group-text {
            width: 100px;
        } 

        table {
            text-align: center;
        }

        img { 
            border: 4px solid white;
        }

        .imagem {
            height: 120px;
        }
    </style>
@stop

@section('content_header')
    <h1>Editar Questão</h1>
@stop

@section('content')
    <form action="{{route('questoes.update', $questao)}}" method="POST" enctype="multipart/form-data" id="editar_questao">
        <input type="hidden" name="_METHOD" value="PUT">
        @csrf
        <div class="form-group mb-3">
            <div class="input-group-prepend">
                <label for="Comando">Comando*</label>
            </div>
            <textarea name="comando" class="form-control" aria-label="Comando" rows="6">{{$questao->comando}}</textarea>
        </div>
        @if(count($questao->imagens) > 0)
            <table class="table table-sm table-bordered">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col">Imagem</th>
                        <th scope="col">Legenda</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($questao->imagens as $imagem)
                    <tr id="linha_{{$imagem->id}}">
                        <td><img src="{{asset("imagens/questoes/$imagem->caminho")}}" alt="{{$imagem->legenda}}"></td>
                        <td id="legenda_{{$imagem->id}}">{{$imagem->legenda}}</td>
                        <td>
                            <a type="button" class="btn btn-sm btn-warning" onclick="alterarLegendaModal({{$imagem->id}})">Alterar legenda</a>
                            <a type="button" class="btn btn-sm btn-danger" onclick="excluirImagem({{$imagem->id}})">Excluir</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
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
        <input type="hidden" id="questao" value="{{$questao}}">

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
                        <input type="text" class="form-control" aria-label="Username" aria-describedby="novo_assunto_input" id="nome_novo_assunto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="salvarNovoAssunto()">Salvar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal: alterar legenda imagem -->
    <div class="modal fade" id="alterar_legenda_imagem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="alterar_legenda_imagem_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alterar_legenda_imagem_label">Alterar legenda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="alterar_legenda_imagem_input">Legenda</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Username" placeholder="Insira aqui..." aria-describedby="alterar_legenda_imagem_input" id="nova_legenda">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="salvar_imagem_modal">Salvar</button>
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

    let questao = JSON.parse($('#questao').val());
    console.log(questao);
    // função
    function excluirImagem(imagem_id) {
        Swal.fire({
            title: 'Confirmação',
            text: "Você tem certeza que deseja excluir essa imagem?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, tenho certeza!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/api/imagens/${imagem_id}`,
                    success: function() {
                        $(`#linha_${imagem_id}`).remove();

                        Swal.fire(
                            'Sucessso!',
                            'Imagem excluída com sucesso.',
                            'success'
                        );
                    },
                });
            }
        })
    }

    function alterarLegendaModal(imagem_id) {
        $('#alterar_legenda_imagem').modal('show');
        $('#salvar_imagem_modal').attr('onclick', `alterarLegenda(${imagem_id})`);
    }

    function alterarLegenda(imagem_id) {
        $.ajax({
            type: "POST",
            url: '/api/imagens',
            data: {
                imagem_id: imagem_id,
                legenda: $('#nova_legenda').val()
            },
            success: function(data) {
                $('#alterar_legenda_imagem').modal('hide');
                $(`#legenda_${imagem_id}`).html(data);

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Legenda alterada com sucesso!',
                });
            },
        });
    }

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
            if(tipo_resposta == 'Única Escolha') $(div_id).replaceWith(opcaoUnicaEscolha(i, letra, opcao, questao.opcoes[i] && questao.opcoes[i]));
            if(tipo_resposta == 'Múltipla Escolha') $(div_id).replaceWith(opcaoMultiplaEscolha(i, letra, opcao,questao.opcoes[i] && questao.opcoes[i]));
        }
        if(opcao == 'imagem') {
            if(tipo_resposta == 'Única Escolha') $(div_id).replaceWith(opcaoUnicaEscolha(i, letra, opcao, questao.opcoes[i] && questao.opcoes[i]));
            if(tipo_resposta == 'Múltipla Escolha') $(div_id).replaceWith(opcaoMultiplaEscolha(i, letra, opcao, questao.opcoes[i] && questao.opcoes[i]));
        }
    }

    function opcaoUnicaEscolha(i, letra, tipo, opcao = '') {
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
                <textarea class='form-control' name='opcoes[${i}][texto]' placeholder='Alternativa ${letra}'>${opcao && opcao.texto}</textarea>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>
                        <input type='radio' name='correta' value=${i} ${(opcao && opcao.correta) && 'checked'}>
                    </span>
                </div>
            </div>`;

            return html;
        }
        if(tipo == 'imagem') {
            if(opcao.imagem) {
                let html = `
                <div class='input-group mb-3 imagem' id='opcao_${i}'> 
                    <div class="input-group-prepend imagem">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Texto</a>
                            <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Imagem</a>
                        </div>
                    </div>
                    <div class="custom-file" imagem>
                        <input type="file" class="custom-file-input" id="imagem_${i}" name="imagem_${i}" >
                        <label class="custom-file-label imagem" for="imagem_${i}" id="imagem_${i}_label" data-browse="Procurar"><img src="/imagens/opcoes/${opcao.texto}" width="100px;" length="100px"/></label>
                    </div>
                    <div class='input-group-prepend' imagem>
                        <span class='input-group-text'>
                            <input type='radio' name='correta' value=${i} ${(opcao && opcao.correta) && 'checked'}>
                        </span>
                    </div>
                </div>`;
                return html;
            } else {
                let html = `
                <div class='input-group mb-3 imagem' id='opcao_${i}'> 
                    <div class="input-group-prepend imagem">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Texto</a>
                            <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Única Escolha')">Imagem</a>
                        </div>
                    </div>
                    <div class="custom-file" imagem>
                        <input type="file" class="custom-file-input" id="imagem_${i}" name="imagem_${i}" >
                        <label class="custom-file-label imagem" for="imagem_${i}" id="imagem_${i}_label" data-browse="Procurar">Procurar imagem...</label>
                    </div>
                    <div class='input-group-prepend' imagem>
                        <span class='input-group-text'>
                            <input type='radio' name='correta' value=${i} ${(opcao && opcao.correta) && 'checked'}>
                        </span>
                    </div>
                </div>`;
                return html;
            }
            
        }   
    }

    function opcaoMultiplaEscolha(i, letra, tipo, opcao = '') {
        ////
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
                <textarea class='form-control' name='opcoes[${i}][texto]' placeholder='Alternativa ${letra}'>${opcao && opcao.texto}</textarea> 
                <div class='input-group-prepend'>
                    <span class='input-group-text'>
                        <input type='checkbox' name='opcoes[${i}][correta]' ${(opcao && opcao.correta) && 'checked'}> 
                    </span>
                </div>
            </div>`;

            return html;
        }
        if(tipo == 'imagem') {
            if(opcao.imagem) {
                let html = `
                <div class='input-group mb-3 imagem' id='opcao_${i}'> 
                    <div class="input-group-prepend imagem">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Texto</a>
                            <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Imagem</a>
                        </div>
                    </div>
                    <div class="custom-file imagem">
                        <input type="file" class="custom-file-input" id="imagem_${i}" name="imagem_${i}">
                        <label class="custom-file-label imagem" for="imagem_${i}" id="imagem_${i}_label" data-browse="Procurar"><img src="/imagens/opcoes/${opcao.texto}" width="100px;" length="100px"/></label>
                    </div>
                    <div class='input-group-prepend imagem'>
                        <span class='input-group-text'>
                            <input type='checkbox' name='opcoes[${i}][correta]' ${(opcao && opcao.correta) && 'checked'}> 
                        </span>
                    </div>
                </div>`;
                return html;
            } else {
                let html = `
                <div class='input-group mb-3 imagem' id='opcao_${i}'> 
                    <div class="input-group-prepend imagem">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Texto</a>
                            <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', '#opcao_${i}', '${i}', '${letra}', 'Múltipla Escolha')">Imagem</a>
                        </div>
                    </div>
                    <div class="custom-file imagem">
                        <input type="file" class="custom-file-input" id="imagem_${i}" name="imagem_${i}">
                        <label class="custom-file-label imagem" for="imagem_${i}" id="imagem_${i}_label" data-browse="Procurar">Procurar imagem...</label>
                    </div>
                    <div class='input-group-prepend imagem'>
                        <span class='input-group-text'>
                            <input type='checkbox' name='opcoes[${i}][correta]' ${(opcao && opcao.correta) && 'checked'}> 
                        </span>
                    </div>
                </div>`;
                return html;
            }
            
        }   
        ///
    }
  
    // opcoes
    $("#tipo_resposta").change(
        function() {
            let tipo_resposta = $('#tipo_resposta').val();

            if(tipo_resposta == 'Única Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                    let opcao = questao.opcoes[i];
                    if(opcao) {
                        if(opcao.imagem) {
                            opcoes = opcoes + opcaoUnicaEscolha(i, letra, 'imagem', opcao);
                            letra = nextChar(letra);
                        } else {
                            opcoes = opcoes + opcaoUnicaEscolha(i, letra, 'texto', opcao);
                            letra = nextChar(letra);
                        }  
                    } else {
                        opcoes = opcoes + opcaoUnicaEscolha(i, letra, 'texto', opcao);
                        letra = nextChar(letra);
                    }
                }
                $("#opcoes_container" ).html("<label>Opções</label>" + opcoes);
            } else if(tipo_resposta == 'Múltipla Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                    let opcao = questao.opcoes[i];
                    if(opcao) {
                        if(opcao.imagem) {
                            opcoes = opcoes + opcaoMultiplaEscolha(i, letra, 'imagem', opcao);
                            letra = nextChar(letra);
                        } else {
                            opcoes = opcoes + opcaoMultiplaEscolha(i, letra, 'texto', opcao);
                            letra = nextChar(letra);
                        }  
                    } else {
                        opcoes = opcoes + opcaoMultiplaEscolha(i, letra, 'texto', opcao);
                        letra = nextChar(letra);
                    }
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
        // teste
        // tipo resposta
        let tipo_resposta_data = [
            {
                id: '',
                text: 'Selecione...',
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
        ];

        tipo_resposta_data.forEach(element => {
            if(element.text == questao.tipo_resposta) {
                element.selected = true;
            }
        });

        $("#tipo_resposta").select2({
            theme: 'classic',
            width: '100%',
            height: '100%',
            data: tipo_resposta_data
        });

        // nível de dificuldade
        let nivel_dificuldade_data = [
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
        ];

        nivel_dificuldade_data.forEach(element => {
            if(element.text == questao.nivel_dificuldade) {
                element.selected = true;
            }
        });

        $("#nivel_dificuldade").select2({
            theme: 'classic',
            width: '100%',
            height: '100%',
            data: nivel_dificuldade_data
        });
        carregarOpcoes('/api/matrizes', 'matriz_id');
        carregarOpcoes('/api/componentes', 'componente_id');
        carregarOpcoes('/api/assuntos', 'assunto_id');

        // opções
        if(questao.opcoes.length > 0) {
            console.log('tem alternativas');
            if(questao.tipo_resposta == 'Única Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                    let opcao = questao.opcoes[i];
                    if(opcao) {
                        if(opcao.imagem) {
                            opcoes = opcoes + opcaoUnicaEscolha(i, letra, 'imagem', opcao);
                            letra = nextChar(letra);
                        } else {
                            opcoes = opcoes + opcaoUnicaEscolha(i, letra, 'texto', opcao);
                            letra = nextChar(letra);
                        }  
                    } else {
                        opcoes = opcoes + opcaoUnicaEscolha(i, letra, 'texto', opcao);
                    }
                }
                $("#opcoes_container" ).html("<label>Opções</label>" + opcoes);
            }
            if(questao.tipo_resposta == 'Múltipla Escolha') {
                let opcoes = '';
                let letra ='A';
                for(let i = 0; i < 5; i++) {
                    let opcao = questao.opcoes[i];
                    if(opcao) {
                        if(opcao.imagem) {
                            opcoes = opcoes + opcaoMultiplaEscolha(i, letra, 'imagem', opcao);
                            letra = nextChar(letra);
                        } else {
                            opcoes = opcoes + opcaoMultiplaEscolha(i, letra, 'texto', opcao);
                            letra = nextChar(letra);
                        }  
                    } else {
                        opcoes = opcoes + opcaoMultiplaEscolha(i, letra, 'texto', opcao);
                    }
                }
                $("#opcoes_container" ).html("<label>Opções</label>" + opcoes);
            }
        }
    });
</script>
@stop