@extends('adminlte::page')

@section('title', 'Cadernos de Questões - Todos')

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
    <h1>Cadernos de Questões - Todos</h1>
@stop

@section('content')
    <div align="center">
        <a type="button" class="btn btn-primary toggle-vis" data-column="0">ID</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="1">Titulo</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="2">Data inicial</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="3">Data final</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="4">Tipo</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="5">Categoria</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="6">Privacidade</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="7">Autor</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="8">Ações</a>

    </div>
    <div class="table-responsive">
        <table id="cadernos_questoes" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Data inicial</th>
                    <th>Data final</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Privacidade</th>
                    <th>Autor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cadernos_questoes as $caderno_questao)
                <tr id={{"caderno_questao_$caderno_questao->id"}}>
                    <td>{{$caderno_questao->id}}</td>
                    <td>{{$caderno_questao->titulo}}</td>
                    <td>{{date('d/m/Y', strtotime($caderno_questao->data_inicial))}}</td>
                    <td>{{date('d/m/Y', strtotime($caderno_questao->data_final))}}</td>
                    <td>{{$caderno_questao->tipo}}</td>
                    <td>{{$caderno_questao->categoria}}</td>
                    <td>{{$caderno_questao->privacidade}}</td>
                    <td></td>
                    <td>
                        <a type="button" class="btn btn-sm btn-info" href="{{route('cadernos_questoes.show', $caderno_questao)}}">Ver</a>
                        <a type="button" class="btn btn-sm btn-danger" onclick="excluirCadernoQuestao({{$caderno_questao->id}})">Excluir</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="pesquisavel"></th>
                    <th class="pesquisavel"></th>
                    <th class="pesquisavel"></th>
                    <th></th>
                    <th></th>
                    <th></th>
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
        function excluirCadernoQuestao(caderno_questao) {
            Swal.fire({
                title: 'Confirmação',
                text: "Você tem certeza que deseja excluir esse caderno de questões?",
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
                        url: `/cadernos_questoes/${caderno_questao}`,
                        success: function() {
                            $(`#caderno_questao_${caderno_questao}`).remove();

                            Swal.fire(
                                'Sucessso!',
                                'Caderno de questões excluído com sucesso.',
                                'success'
                            );
                        },
                    });
                }
            })
        }


        $(document).ready(function(d) {
            var theadname = ['Título', 'Data inicial', 'Data final'];

            $('.pesquisavel').each( function (d) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + theadname[d] + '"/>');
            });

            let table = $('#cadernos_questoes').DataTable({
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
                    this.api().columns([0, 4, 5, 7]).every( function (d) {
                        var column = this;
                        var theadname = [
                            'ID', 
                            'Título', 
                            'Data inicial',
                            'Data final',
                            'Tipo',
                            'Categoria',
                            'Privacidade',
                            'Autor',
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
                    this.api().columns([1, 2, 3]).every( function () {
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