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
        <a type="button" class="btn btn-primary toggle-vis" data-column="1">Nome</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="2">Cpf</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="3">E-mail</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="4">Tipo de Usuários</a>
        <a type="button" class="btn btn-primary toggle-vis" data-column="5">Ações</a>

    </div>
    <div class="table-responsive">
        <table id="users" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cpf</th>
                    <th>E-mail</th>
                    <th>Tipo de Usuários</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr id={{"user_$user->id"}}>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->cpf}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->user_type}}</td>
                    <td>
                        <a type="button" class="btn btn-sm btn-info" href="{{route('users.edit', $user)}}">Editar</a>
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
            </tfoot>
        </table>
    </div>
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // funçõe

        $(document).ready(function(d) {
            var theadname = ['Nome', 'Cpf', 'E-mail'];

            $('.pesquisavel').each( function (d) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + theadname[d] + '"/>');
            });

            let table = $('#users').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                },
                initComplete: function () {
                    // columns seach
                    this.api().columns([0, 4]).every( function (d) {
                        var column = this;
                        var theadname = [
                            'ID', 
                            'Nome', 
                            'Cpf',
                            'E-mail',
                            'Tipo de Usuários',
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