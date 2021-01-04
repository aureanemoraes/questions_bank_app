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
    <input type="hidden" id="cadernos_questoes" value="{{$cadernos_questoes}}">
    <div class="container">
        <div align="center">
            <a type="button" class="btn btn-primary toggle-vis" data-column="0">ID</a>
            <a type="button" class="btn btn-primary toggle-vis" data-column="1">Titulo</a>
            <a type="button" class="btn btn-primary toggle-vis" data-column="2">Data inicial</a>
            <a type="button" class="btn btn-primary toggle-vis" data-column="3">Data final</a>
            <a type="button" class="btn btn-primary toggle-vis" data-column="4">Tipo</a>
            <a type="button" class="btn btn-primary toggle-vis" data-column="5">Categoria</a>
            <a type="button" class="btn btn-primary toggle-vis" data-column="6">Situacao</a>
            <a type="button" class="btn btn-primary toggle-vis" data-column="7">Ações</a>

        </div>
        <div class="table-responsive">
            <table id="cadernos_questoes_table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Data inicial</th>
                        <th>Data final</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Situacao</th>
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
                        <td>{{ucfirst($caderno_questao->pivot->situacao)}}</td>
                        <td>
                            <a type="button" class="btn btn-sm btn-info" href="{{route('aluno_cq.show', $caderno_questao)}}">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                    @foreach($cadernos_questoes_publicos as $caderno_questao)
                    <tr id={{"caderno_questao_$caderno_questao->id"}}>
                        <td>{{$caderno_questao->id}}</td>
                        <td>{{$caderno_questao->titulo}}</td>
                        <td>{{date('d/m/Y', strtotime($caderno_questao->data_inicial))}}</td>
                        <td>{{date('d/m/Y', strtotime($caderno_questao->data_final))}}</td>
                        <td>{{$caderno_questao->tipo}}</td>
                        <td>{{$caderno_questao->categoria}}</td>
                        <td>Aberto</td>
                        <td>
                            <a type="button" class="btn btn-sm btn-info" href="{{route('aluno_cq.show', $caderno_questao)}}">Ver</a>
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
                </tfoot>
            </table>
        </div>
    </div>
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        let cadernos_questoes = $('#cadernos_questoes').val();
        console.log(cadernos_questoes);

        $(document).ready(function(d) {
            var theadname = ['Título', 'Data inicial', 'Data final'];

            $('.pesquisavel').each( function (d) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + theadname[d] + '"/>');
            });

            let table = $('#cadernos_questoes_table').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                },
                "columnDefs": [
                    {
                        "targets": [4, 5],
                        "visible": false
                    }
                ],
                initComplete: function () {
                    // columns seach
                    this.api().columns([0, 4, 5, 6]).every( function (d) {
                        var column = this;
                        var theadname = [
                            'ID', 
                            'Título', 
                            'Data inicial',
                            'Data final',
                            'Tipo',
                            'Categoria',
                            'Situacao',
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
                            });
        
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
            });
            // Colunas iniciais visiveis
            
            $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
                // Toggle the visibility
                column.visible( ! column.visible() );
            });
        });
    </script>
@stop