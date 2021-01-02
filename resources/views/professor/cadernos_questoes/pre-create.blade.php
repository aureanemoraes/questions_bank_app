@extends('adminlte::page')

@section('title', 'Cadernos de questões - Novo')

@section('css')
@stop

@section('content_header')
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Novo caderno de questões</h3>
                <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <p>Por favor, selecione a qual categoria pertence o novo caderno de questões.</p>
                
                <a href="/cadernos_questoes/create" class="card-link">EJA</a>
                <a href="#" class="card-link">ENEM</a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@stop

@section('js')
@stop