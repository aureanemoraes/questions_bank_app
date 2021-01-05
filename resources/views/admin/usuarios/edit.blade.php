@extends('adminlte::page')

@section('title', 'Usuários - Edição')

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
    <h1>Editar Usuário</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('users.update', $user)}}" method="POST" id="editar_usuario">
            @csrf
            @method('put')

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Cpf</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo de Usuário</th>
                    </thead>
                    <tbody>
                        <td>{{$user->id}}</td>
                        <td>{{$user->cpf}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->user_type}}</td>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <label for="user_type">Mudar tipo de usuário</label>
                <select class="form-control" id="user_type" name="user_type">
                    <option disabled selected>Selecione...</option>
                    <option value="administrador">Administrador</option>
                    <option value="professor">Professor</option>
                    <option value="estudante">Estudante</option>
                </select>
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

@stop

@section('js')
@stop