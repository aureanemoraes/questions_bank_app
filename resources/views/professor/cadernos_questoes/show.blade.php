@extends('adminlte::page')

@section('title', 'Caderno de Questões - Detalhes')

@section('css')
@stop

@section('content_header')
@stop

@section('content')
    <div class="container">
        @if(count($caderno_questao->questoes) < $caderno_questao->quantidade_questoes)
        <div class="alert alert-danger" role="alert">
            Este caderno não possui a quantidade de questões declaradas. Adicione questões ou altere o valor da quantidade de questões!
        </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Caderno de questões {{$caderno_questao->id}} - Detalhes</h3>
            </div>
            <div class="card-body">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-number">{!! nl2br(e($caderno_questao->titulo)) !!}</span>
                            <span><em>{!! nl2br(e($caderno_questao->informacoes_adicionais)) !!}</em></span>
                        </div>
                    </div>
                <div class="info-box">
                    <div class="info-box-content">
                        <span class="info-box-text">Privacidade</span>
                        <span class="info-box-number">{{$caderno_questao->privacidade}}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Data inicial</span>
                                <span class="info-box-number">{{date('d/m/Y', strtotime($caderno_questao->data_inicial))}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Data final</span>
                                <span class="info-box-number">{{date('d/m/Y', strtotime($caderno_questao->data_final))}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Duração</span>
                                <span class="info-box-number">{{$caderno_questao->duracao}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Quantidade de questões</span>
                                <span class="info-box-number">{{$caderno_questao->quantidade_questoes}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Nota máxima</span>
                                <span class="info-box-number">{{$caderno_questao->nota_maxima}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Tipo</span>
                                <span class="info-box-number">{{$caderno_questao->tipo}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text">Categoria</span>
                                <span class="info-box-number">{{$caderno_questao->categoria}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h5>Questões</h5>
                        @php {{$contador = 1;}} @endphp
                        @if(count($caderno_questao->questoes) > 0)
                            @foreach($caderno_questao->questoes as $questao)
                                <div class="card bg-gradient-info collapsed-card" id="questao_{{$questao->id}}">
                                    <div class="card-header">
                                        <h5 class="card-title">{{$contador}}) {!! nl2br(e($questao->comando)) !!}</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach($questao->opcoes as $opcao)
                                            <p>{!! nl2br(e($opcao->texto)) !!}</p>
                                        @endforeach
                                    </div>
                                    <div class="card-footer" align="right">
                                        <a class="btn btn-sm btn-primary" href="{{route('questoes.show', $questao->id)}}">Ver</a>
                                        <button class="btn btn-sm btn-danger" onclick="removerOpcao({{$questao->id}}, {{$caderno_questao->id}})">Remover</button>
                                    </div>
                                </div>
                                @php {{$contador++;}} @endphp
                            @endforeach
                        @else
                            <p>Ainda não possui questões.</p>
                        @endif
                    </div>
                    <a href="{{route('questoes.index')}}" class="small-box-footer">
                        Procurar questão <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    <a href="{{route('questoes.create')}}" class="small-box-footer">
                        Criar questão <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>

            </div>
            <div class="card-footer">
                @if($caderno_questao->user_id == auth()->user()->id)
                    <a type="button" class="btn btn-sm btn-warning" href="{{route('cadernos_questoes.edit', $caderno_questao)}}">Editar</a>
                @endif
            </div>  
        </div>
    </div>
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        //funções
        function removerOpcao(questao_id, cq_id) {
            Swal.fire({
                title: 'Confirmação',
                text: "Você tem certeza que deseja remover esta questão? A questão não será excluída, apenas removida deste caderno.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, tenho certeza!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: `/api/cadernos_questoes/${questao_id}/${cq_id}`,
                        success: function(data) {
                            if(data == 1) {
                                $(`#questao_${questao_id}`).remove();

                                Swal.fire(
                                    'Sucessso!',
                                    'Imagem excluída com sucesso.',
                                    'success'
                                );
                            }
                        },
                    });
                }
            })
        }
    </script>
@stop