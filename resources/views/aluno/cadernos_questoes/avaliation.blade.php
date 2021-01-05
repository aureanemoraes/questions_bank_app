@extends('adminlte::page')

@section('title', 'Caderno de Questões - Avaliação')

@section('css')
    <style>
        .countdown {
            background: orange;
            width: fit-content;
            padding: 8px;
            border-radius: 8px;
            margin: 8px;
            font-weight: bold;
            align: center;
        }
    </style>
@stop

@section('content_header')
@stop

@section('content')
    @if($caderno_questao->pivot->situacao == 'aberto')
    <div class="container">
        <input type="hidden" id="caderno_questao" value="{{$caderno_questao}}">
        <div class="card card-primary">
            <form action="{{route('aluno_cq.salvar', $caderno_questao->id)}}" method="POST" enctype="multipart/form-data" id="avaliacao_form">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">{{$caderno_questao->titulo}}</h3>
                </div>
                <div class="card-body">
                        <div align="center">
                            <div class="row countdown" id="countdown" ></div>
                        </div>

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
                                        @if(count($questao->imagens) > 0)
                                            @foreach($questao->imagens as $imagem)
                                                <div align="center">
                                                    <img src="{{ asset("imagens/questoes/$imagem->caminho") }}" alt="{{$imagem->caminho}}" />
                                                    <p><em>{{$imagem->legenda}}</em></p>
                                                </div>
                                            @endforeach
                                        @endif
                                        @foreach($questao->opcoes as $opcao)
                                            @if($opcao->imagem)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="resposta_unica_escolha" value="resposta[{{$questao->id}}][{{$opcao->id}}]">
                                                    <label class="form-check-label" for="alternativa_{{$opcao->id}}">
                                                        <img src="{{ asset("imagens/opcoes/$opcao->texto") }}" alt="{{$opcao->texto}}" />
                                                    </label>
                                                </div>
                                            @else
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="resposta_unica_escolha"  value="resposta[{{$questao->id}}][{{$opcao->id}}]">
                                                    <label class="form-check-label" for="alternativa_{{$opcao->id}}">
                                                        {{$opcao->texto}}
                                                    </label>
                                                </div>
                                                
                                            @endif
                                            @php $letra++; @endphp
                                        @endforeach
                                    @elseif($questao->tipo_resposta == 'Múltipla Escolha')
                                        @if(count($questao->imagens) > 0)
                                            @foreach($questao->imagens as $imagem)
                                                <div align="center">
                                                    <img src="{{ asset("imagens/questoes/$imagem->caminho") }}" alt="{{$imagem->caminho}}" />
                                                    <p><em>{{$imagem->legenda}}</em></p>
                                                </div>
                                            @endforeach
                                        @endif
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
                                            <textarea class="form-control" name="resposta_discursiva[{{$questao->id}}][texto]" id="alternativa_{{$questao->id}}" rows="3" placeholder="Responda aqui..."></textarea>
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
    @endif
@stop


@section('js')
    <script>
        let cq = JSON.parse($('#caderno_questao').val());
            // Set the date we're counting down to
            //var countDownDate = new Date("Oct 01, 2019 08:00:00").getTime();
            let duracao_hora = new Date(`Oct 01, 2019 ${cq.duracao}`).getHours(); // valor duração
            let duracao_minuto = new Date(`Oct 01, 2019 ${cq.duracao}`).getMinutes(); // valor duração
            let duracao_segundo = new Date(`Oct 01, 2019 ${cq.duracao}`).getSeconds(); // valor duração

            let countDownDate = new Date(cq.pivot.started_at);
            countDownDate.setHours(countDownDate.getHours() + duracao_hora);
            countDownDate.setMinutes(countDownDate.getMinutes() + duracao_minuto);
            countDownDate.setSeconds(countDownDate.getSeconds() + duracao_segundo);


            // Update the count down every 1 second
            var x = setInterval(function () {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="countdown"
                document.getElementById("countdown").innerHTML = "Tempo restante: " + hours + "h "
                    + minutes + "m " + seconds + "s ";

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown").innerHTML = "EXPIRED";
                    $( "#avaliacao_form" ).submit();
                }
            }, 1000);
    </script>
@stop