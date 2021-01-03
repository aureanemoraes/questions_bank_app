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

        .imagem-container {
            height: 110px;
        }
        .imagem {
            max-height: 100px;
            max-width: 100px;
        }

        a.btn-warning {
            color: black ;
        }

        a.btn-danger {
            color: white;
        }

        .opcao {
            display: flex;
            align-items: center;
            margin: 4px;
            border-radius: 4px;
            padding: 4px;
        }

        .col-8 {
            color: white;
        }

        
    </style>
@stop

@section('content_header')
    <h1>Editar Questão</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('questoes.update', $questao)}}" method="POST" enctype="multipart/form-data" id="editar_questao">
            @csrf
            @method('put')
            <input type="hidden" id="questao" value="{{$questao}}">
            <div class="form-group mb-3">
                <div class="input-group-prepend">
                    <label for="Comando">Comando*</label>
                </div>
                <textarea name="comando" class="form-control" aria-label="Comando" rows="4">{{$questao->comando}}</textarea>
            </div>
            @if(count($questao->imagens) > 0)
                <div class="table-responsive">
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
                </div>
            @endif
            <div class="custom-file mb-3">
                <input name="imagens[]" type="file" class="custom-file-input" id="imagens" multiple>
                <label class="custom-file-label" for="imagens" data-browse="Procurar">Selecione as imagens...</label>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="tipo_resposta">Tipo de resposta*</label>
                        <select class="form-control" id="tipo_resposta" name="tipo_resposta">
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="nivel_dificuldade">Nível de dificuldade*</label>
                        <select class="form-control" id="nivel_dificuldade" name="nivel_dificuldade">
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="matriz_id">Matriz*</label>
                        <select class="form-control" id="matriz_id" name="matriz_id">
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="componente_id">Componente*</label>
                        <select class="form-control" id="componente_id" name="componente_id">
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="assunto_id">Assunto*</label>
                <select class="form-control" id="assunto_id" name="assunto_id">
                </select>
                <!-- Novo assunto -->
                <a type="button" class="btn btn-sm text-info" onclick="novoAssuntoModal()">
                    <i class="fas fa-plus-circle"></i>
                    Novo assunto
                </a>
            </div>

            <div id="opcoes_container" class="container">
                <label>Alternativas</label>
                <a type="button" class="btn btn-sm text-info" onclick="adicionarOpcaoModal()">
                    <i class="fas fa-plus-circle"></i>
                    Adicionar alternativa
                </a>
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

    // função
    function alterarOpcao(index_alternativa) {
        let opcao_id = questao.opcoes[index_alternativa].id;
        let alternativa_correta = '';

        if($('#correta').is(':checked')) { 
            alternativa_correta = true;
        }
        if($('#incorreta').is(':checked')) { 
            alternativa_correta = false;
        }

        $.ajax({
            type: 'PUT',
            url: `/api/opcoes/${opcao_id}`,
            data: {
                nova_opcao: $('#nova_opcao').val(),
                correta: alternativa_correta
            },
            success: function(data) {
                questao.opcoes[index_alternativa] = data;

                let opcao = '';
                if(data.imagem) {
                    opcao += `
                        <div class="col-8">
                            <img class="imagem" src="/imagens/opcoes/${data.texto}"/>
                        </div>
                        <div class="col-1">
                            ${data.correta ? '<i class="fas fa-check-circle"></i>' : ''}
                        </div>
                        <div class="col-3">
                            <a type="button" class="btn btn-sm btn-warning" onclick="alterarOpcaoModal('${index_alternativa}')">Alterar</a>
                            <a type="button" class="btn btn-sm btn-danger" onclick="excluirOpcao('${data.id}')">Excluir</a>
                        </div>
                    `;
                } else {
                    opcao += `
                        <div class="col-8">${data.texto}</div>
                        <div class="col-1">${data.correta ? '<i class="fas fa-check-circle"></i>' : ''}</div>
                        <div class="col-3">
                            <a type="button" class="btn btn-sm btn-warning" onclick="alterarOpcaoModal('${index_alternativa}')">Alterar</a>
                            <a type="button" class="btn btn-sm btn-danger" onclick="excluirOpcao('${data.id}')">Excluir</a>
                        </div>
                    `;
                }

                if(data.correta) {
                    $(`#opcao_${data.id}`).addClass('bg-gradient-success');
                } else {
                    $(`#opcao_${data.id}`).removeClass('bg-gradient-success');
                }

                $(`#opcao_${data.id}`).html(opcao);


                $('#modal_generico').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Alternativa adicionada.',
                });
            },
        });
    }
    function alterarOpcaoModal(index_alternativa) {
        $('#modal_generico_label').html('Alterar alternativa');

        if(questao.opcoes[index_alternativa].imagem) {
            let html = opcaoInputHtml('imagem', index_alternativa);
            $('#modal_generico_body').html(html);
        } else {
            let html = opcaoInputHtml('texto', index_alternativa);
            $('#modal_generico_body').html(html);
        }

        $('#modal_generico_footer').html(`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="alterarOpcao('${index_alternativa}')">Salvar</button>
        `);

        $('#modal_generico').modal('show');
    }

    function excluirOpcao(opcao_id) {
        Swal.fire({
            title: 'Confirmação',
            text: "Você tem certeza que deseja excluir essa alternativa?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, tenho certeza!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/api/opcoes/${opcao_id}`,
                    success: function() {
                        $(`#opcao_${opcao_id}`).remove();

                        Swal.fire(
                            'Sucessso!',
                            'Alternativa excluída com sucesso.',
                            'success'
                        );
                    },
                });
            }
        })
    }

    function adicionarOpcao() {
        let fd = new FormData();
        let files = '';
        if(typeof $('#nova_opcao_imagem')[0] != 'undefined') {
            files = $('#nova_opcao_imagem')[0].files;
        }

        fd.append('nova_opcao', $('#nova_opcao').val());
        if($('#correta').is(':checked')) { 
            fd.append('correta', true);
        }

        // Check file selected or not
        if(files.length > 0 ) {
            fd.append('nova_opcao_imagem', files[0]);
        }

        $.ajax({
            type: 'POST',
            url: `/api/opcoes/${questao.id}`,
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Falha!',
                        text: 'Esta questão já possui uma alternativa correta. Para cadastrar duas ou mais alternativas corretas, mude o tipo de resposta para múltipla escolha.',
                    });
                } else {
                    questao.opcoes.push(data);
                    $('#modal_generico').modal('hide');
                    let opcao = '';
                    if(data.imagem) {
                        opcao += `
                            <div id="opcao_${data.id}" class="row align-middle opcao imagem-container ${data.correta ? 'bg-gradient-success' : 'bg-gradient-info'}">
                                <div class="col-8">
                                    <img class="imagem" src="/imagens/opcoes/${data.texto}"/>
                                </div>
                                <div class="col-1">
                                    ${data.correta ? '<i class="fas fa-check-circle"></i>' : ''}
                                </div>
                                <div class="col-3">
                                    <a type="button" class="btn btn-sm btn-warning" onclick="alterarOpcaoModal('${questao.opcoes.length-1}')">Alterar</a>
                                    <a type="button" class="btn btn-sm btn-danger" onclick="excluirOpcao('${data.id}')">Excluir</a>
                                </div>
                            </div>
                        `;
                    } else {
                        opcao += `
                            <div id="opcao_${data.id}" class="row opcao ${data.correta ? 'bg-gradient-success' : 'bg-gradient-info'}">
                                <div class="col-8">${data.texto}</div>
                                <div class="col-1">${data.correta ? '<i class="fas fa-check-circle"></i>' : ''}</div>
                                <div class="col-3">
                                    <a type="button" class="btn btn-sm btn-warning" onclick="alterarOpcaoModal('${questao.opcoes.length-1}')">Alterar</a>
                                    <a type="button" class="btn btn-sm btn-danger" onclick="excluirOpcao('${data.id}')">Excluir</a>
                                </div>
                            </div>
                        `;
                    }
                    $('#opcoes_container').append(opcao);

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Alternativa adicionada.',
                    });
                }
            },
        });
    }

    function adicionarOpcaoModal() {
        $('#modal_generico_label').html('Nova alternativa');

        let html = opcaoInputHtml('texto');
        $('#modal_generico_body').html(html);
        
        $('#modal_generico_footer').html(`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="adicionarOpcao()">Salvar</button>
        `);

        $('#modal_generico').modal('show');
    }

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
        $('#modal_generico_label').html('Alterar legenda');
        $('#modal_generico_body').html(`
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Legenda</span>
                </div>
                <input type="text" class="form-control" id="nova_legenda">
            </div>
        `);
        $('#modal_generico_footer').html(`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="alterarLegenda(${imagem_id})">Salvar</button>
        `);
        $('#modal_generico').modal('show');
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

    function novoAssuntoModal() {
        $('#modal_generico_label').html('Novo assunto');
        $('#modal_generico_body').html(`
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nome</span>
                </div>
                <input type="text" class="form-control" id="nome_novo_assunto">
            </div>
        `);
        $('#modal_generico_footer').html(`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="salvarNovoAssunto()">Salvar</button>
        `);
        $('#modal_generico').modal('show');
    }
    
    function salvarNovoAssunto() {
        $.ajax({
            type: "POST",
            url: '/api/assuntos',
            data: {nome: $('#nome_novo_assunto').val()},
            success: function() {
                carregarOpcoes('/api/assuntos', 'assunto_id');
                $('#modal_generico').modal('hide');
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

    function escolherTipoOpcao(opcao, tipo_resposta) {
        if(opcao == 'texto') {
            if(tipo_resposta == 'Única Escolha') $('#nova_opcao_div').replaceWith(opcaoInputHtml(opcao));
        }
        if(opcao == 'imagem') {
            if(tipo_resposta == 'Única Escolha') $('#nova_opcao_div').replaceWith(opcaoInputHtml(opcao));
        }
    }

    function opcaoInputHtml(tipo, index_alternativa = '') {
         if(index_alternativa != '') {
            if(tipo == 'texto') {
                let html = `
                <div class='input-group mb-3' id='nova_opcao_div'>
                    <textarea class='form-control' name='nova_opcao' id="nova_opcao" placeholder='Nova alternativa...'>${questao.opcoes[index_alternativa].texto}</textarea>
                    <div class='input-group-prepend'>
                        <span class='input-group-text'>
                            <label style="margin: 4px;font-size:14px;">Correta</label>
                            <input type='radio' name='correta' id="correta" ${questao.opcoes[index_alternativa].correta && 'checked'}>
                        </span>
                        <span class='input-group-text'>
                            <label style="margin: 4px;font-size:14px;">Incorreta</label>
                            <input type='radio' name='correta' id="incorreta" ${!questao.opcoes[index_alternativa].correta && 'checked'}>
                        </span>
                    </div>
                </div>`;

                return html;
            }
            if(tipo == 'imagem') {
                let html = `
                    <div class='input-group mb-3 imagem-div' id='nova_opcao_div'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>
                                <label style="margin: 4px;font-size:14px;">Correta</label>
                                <input type='radio' name='correta' id="correta" ${questao.opcoes[index_alternativa].correta && 'checked'}>
                            </span>
                            <span class='input-group-text'>
                                <label style="margin: 4px;font-size:14px;">Incorreta</label>
                                <input type='radio' name='correta' id="incorreta" ${!questao.opcoes[index_alternativa].correta && 'checked'}>
                            </span>
                        </div>
                    </div>`;
                return html;
            }  
         } else {
            if(tipo == 'texto') {
                let html = `
                <div class='input-group mb-3' id='nova_opcao_div'> 
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', 'Única Escolha')">Texto</a>
                            <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', 'Única Escolha')">Imagem</a>
                        </div>
                    </div>
                    <textarea class='form-control' name='nova_opcao' id="nova_opcao" placeholder='Nova alternativa...'></textarea>
                    <div class='input-group-prepend'>
                        <span class='input-group-text'>
                            <label style="margin: 4px;font-size:14px;">Correta</label>
                            <input type='radio' name='correta' id="correta">
                        </span>
                        <span class='input-group-text'>
                            <label style="margin: 4px;font-size:14px;">Incorreta</label>
                            <input type='radio' name='correta' id="incorreta"checked>
                        </span>
                    </div>
                </div>`;

                return html;
            }
            if(tipo == 'imagem') {
                let html = `
                    <div class='input-group mb-3 imagem-div' id='nova_opcao_div'> 
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tipo</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" type="button" id="opcao_texto" onclick="escolherTipoOpcao('texto', 'Única Escolha')">Texto</a>
                                <a class="dropdown-item" type="button" id="opcao_imagem" onclick="escolherTipoOpcao('imagem', 'Única Escolha')">Imagem</a>
                            </div>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="nova_opcao_imagem" id="nova_opcao_imagem" >
                            <label class="custom-file-label " for="imagem_nova_opcao" data-browse="Procurar">Procurar imagem...</label>
                        </div>
                        <div class='input-group-prepend'>
                        <span class='input-group-text'>
                            <label style="margin: 4px;font-size:14px;">Correta</label>
                            <input type='radio' name='correta' id="correta">
                        </span>
                        <span class='input-group-text'>
                            <label style="margin: 4px;font-size:14px;">Incorreta</label>
                            <input type='radio' name='correta' id="incorreta" checked>
                        </span>
                    </div>
                    </div>`;
                return html;
            }  
         }
    }

    // verificando se a questão foi modificada para discursiva
    $('#tipo_resposta').on('change', function() {
        if($('#tipo_resposta').val() == 'Discursiva') {
            $('#opcoes_container').hide();
        } else {
            $('#opcoes_container').show();
        }
    });

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
            let opcao = '';
            for(let i=0 ; i<questao.opcoes.length ; i++) {
                if(questao.opcoes[i]) {
                    if(questao.opcoes[i].imagem) {
                        opcao += `
                            <div id="opcao_${questao.opcoes[i].id}" class="row align-middle opcao imagem-container ${questao.opcoes[i].correta ? 'bg-gradient-success' : 'bg-gradient-info'}">
                                <div class="col-8">
                                    <img class="imagem" src="/imagens/opcoes/${questao.opcoes[i].texto}"/>
                                </div>
                                <div class="col-1">
                                    ${questao.opcoes[i].correta ? '<i class="fas fa-check-circle"></i>' : ''}
                                </div>
                                <div class="col-3">
                                    <a type="button" class="btn btn-sm btn-warning" onclick="alterarOpcaoModal('${questao.opcoes.indexOf(questao.opcoes[i])}')">Alterar</a>
                                    <a type="button" class="btn btn-sm btn-danger" onclick="excluirOpcao('${questao.opcoes[i].id}')">Excluir</a>
                                </div>
                            </div>
                        `;
                    } else {
                        opcao += `
                            <div id="opcao_${questao.opcoes[i].id}" class="row opcao ${questao.opcoes[i].correta ? 'bg-gradient-success' : 'bg-gradient-info'}">
                                <div class="col-8">${questao.opcoes[i].texto}</div>
                                <div class="col-1">${questao.opcoes[i].correta ? '<i class="fas fa-check-circle"></i>' : ''}</div>
                                <div class="col-3">
                                    <a type="button" class="btn btn-sm btn-warning" onclick="alterarOpcaoModal('${questao.opcoes.indexOf(questao.opcoes[i])}')">Alterar</a>
                                    <a type="button" class="btn btn-sm btn-danger" onclick="excluirOpcao('${questao.opcoes[i].id}')">Excluir</a>
                                </div>
                            </div>
                        `;
                    }
                }
            }

            $('#opcoes_container').append(opcao);

        } else {
            $('#opcoes_container').hide();

        }
    });
</script>
@stop