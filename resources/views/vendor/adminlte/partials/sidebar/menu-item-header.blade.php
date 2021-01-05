@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<li @if(isset($item['id'])) id="{{ $item['id'] }}" @endif class="nav-header {{ $item['class'] ?? '' }}">


    @if (is_string($item))
        @if ($item == 'Administrador' && $user->user_type == 'administrador')
            {{ $item }}
        @endif
        @if ($item == 'Professor' && $user->user_type == 'professor')
            {{ $item }}
        @endif
        @if ($item == 'Estudante' && $user->user_type == 'estudante')
            {{ $item }}
        @endif
    @else 
        @if ($item['header'] == 'Administrador' && $user->user_type == 'administrador')
            {{ $item['header'] }}
        @endif
        @if ($item['header'] == 'Professor' && $user->user_type == 'professor')
            {{ $item['header'] }}
        @endif
        @if ($item['header'] == 'Estudante' && $user->user_type == 'estudante')
            {{ $item['header'] }}
        @endif
    @endif

</li>