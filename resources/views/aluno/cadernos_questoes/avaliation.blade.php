@extends('adminlte::page')

@section('title', 'Caderno de Questões - Avaliação')

@section('css')
@stop

@section('content_header')
@stop

@section('content')
    <div class="container">
        <input type="hidden" id="caderno_questao" value="{{$caderno_questao}}">
        <div class="card card-primary">
            <form action="{{route('aluno_cq.store', $caderno_questao->id)}}" method="POST" enctype="multipart/form-data" id="avaliacao_form">
                <div class="card-header">
                    <h3 class="card-title">{{$caderno_questao->titulo}}</h3>
                </div>
                <div class="card-body">
                        @php 
                            $letra = 'a'; 
                            $contador = 1; 
                        @endphp
                        @foreach($caderno_questao->questoes as $questao)
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">{{$contador}}) {{$questao->comando}}</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-primary" data-card-widget="collapse"><i class="fas fa-minus" style="color:blue;"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($questao->tipo_resposta == 'Única Escolha')
                                        @foreach($questao->opcoes as $opcao)
                                            @if($opcao->imagem)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="resposta[{{$questao->id}}][{{$opcao->id}}]">
                                                    <label class="form-check-label" for="alternativa_{{$opcao->id}}">
                                                        <img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="{{$opcao->texto}}" />
                                                    </label>
                                                </div>
                                            @else
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="resposta[{{$questao->id}}][{{$opcao->id}}]">
                                                    <label class="form-check-label" for="alternativa_{{$opcao->id}}">
                                                        {{$opcao->texto}}
                                                    </label>
                                                </div>
                                                
                                            @endif
                                            @php $letra++; @endphp
                                        @endforeach
                                    @elseif($questao->tipo_resposta == 'Múltipla Escolha')
                                        @foreach($questao->opcoes as $opcao)
                                            @if($opcao->imagem)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="resposta[{{$questao->id}}][{{$opcao->id}}]">
                                                    <label class="form-check-label" for="alternativa_{{$opcao->id}}">
                                                        <img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="{{$opcao->texto}}" />
                                                    </label>
                                                </div>
                                            @else
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="resposta[{{$questao->id}}][{{$opcao->id}}]">
                                                    <label class="form-check-label" for="alternativa_{{$opcao->id}}">
                                                        {{$opcao->texto}}
                                                    </label>
                                                </div>
                                            @endif
                                            @php $letra++; @endphp
                                        @endforeach
                                    @else 
                                        <div class="form-group">
                                            <textarea class="form-control" name="" id="alternativa_{{$questao->id}}" rows="3" placeholder="Responda aqui..."></textarea>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @php $contador++; @endphp
                        @endforeach
                </div>
                <div class="card-footer" align="right">
                    <button type="submit" class="btn btn-primary"> Finalizar</button>
                </div>
            </form>
        </div>
    </div>
@stop


@section('js')
    <script>
        console.log($('#caderno_questao').val());
    </script>
@stop