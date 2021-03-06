@extends('adminlte::page')

@section('title', 'Questões - Todas')

@section('css')
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" />
    <style>
        a {
            cursor: pointer;
        }

        .toggle-vis {
            color: white !important;
        }


    </style>
@stop

@section('content_header')
    <h1>Questões - Todas</h1>
@stop

@section('content')
    <div align="center">
        <a type="button" class="btn btn-primary toggle-vis" data-column="0">ID</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="1">Comando</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="2">Tipo de resposta</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="3">Nível de dificuldade</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="4">Matriz</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="5">Componente</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="6">Assunto</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="7">Área de Conhecimento (ENEM)</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="8">Ações</a>

    </div>
    <div class="table-responsive">
        <table id="questoes" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Comando</th>
                    <th>Tipo de resposta</th>
                    <th>Nível de dificuldade</th>
                    <th>Matriz</th>
                    <th>Componente</th>
                    <th>Assunto</th>
                    <th>Área de Conhecimento (ENEM)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questoes as $questao)
                <tr id={{"questao_$questao->id"}}>
                    <td>{{$questao->id}}</td>
                    <td>{{$questao->comando}}</td>
                    <td>{{$questao->tipo_resposta}}</td>
                    <td>{{$questao->nivel_dificuldade}}</td>
                    <td>{{$questao->matriz->nome}}</td>
                    <td>{{$questao->componente->nome}}</td>
                    <td>{{$questao->assunto->nome}}</td>
                    <td>{{$questao->area_conhecimento->nome}}</td>
                    <td>
                        <a type="button" class="btn btn-sm btn-info" href="{{route('questoes.show', $questao)}}">Ver</a>
                        <a type="button" class="btn btn-sm btn-danger" onclick="excluirQuestao({{$questao->id}})">Excluir</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="pesquisavel"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="pesquisavel"></th>
                    <th></th>
                    <th></th>
            </tfoot>
        </table>
    </div>
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // funções
        function excluirQuestao(questao_id) {
            Swal.fire({
                title: 'Confirmação',
                text: "Você tem certeza que deseja excluir essa questão?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, tenho certeza!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "DELETE",
                        url: `/questoes/${questao_id}`,
                        success: function() {
                            $(`#questao_${questao_id}`).remove();

                            Swal.fire(
                                'Sucessso!',
                                'Questão excluída com sucesso.',
                                'success'
                            );
                        },
                    });
                }
            })
        }


        $(document).ready(function(d) {
            var theadname = ['Comando', 'Assunto'];

            $('.pesquisavel').each( function (d) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + theadname[d] + '"/>');
            });

            let table = $('#questoes').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                },
                "columnDefs": [
            {
                "targets": [2, 3, 6, 7],
                "visible": false
            }
        ],
                initComplete: function () {
                    // columns seach
                    this.api().columns([0, 2, 3, 4, 5, 7]).every( function (d) {
                        var column = this;
                        var theadname = [
                            'ID', 
                            'Comando', 
                            'Tipo de resposta',
                            'Nível de dificuldade',
                            'Matriz',
                            'Componente',
                            'Assunto',
                            'Área de Conhecimento (ENEM)',
                            'Ações'
                        ] //used this specify table name and head
                        var select = $('<select><option value="">' + theadname[d] + '</option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
        
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
        
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+ d.substr(0,30) +'</option>' )
                        } );
                    } );
                    // Apply the search
                    this.api().columns([1, 6]).every( function () {
                        var that = this;
                        $( 'input', this.footer() ).on( 'keyup change clear', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );
                }
            } );
            // Colunas iniciais visiveis
            
            $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
                // Toggle the visibility
                column.visible( ! column.visible() );
            } );
        } );
    </script>
@stop