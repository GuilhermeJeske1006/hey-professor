@props([
    'method',
    'action'
    ])

<form action="{{ $action }}" method="{{ $method }}">
    @csrf
    
    @switch($method)
        @case($method == 'PUT')
            @method('PUT')
            @break
        @case($method == 'DELETE')
            @method('DELETE')
            @break
        @default
            
    @endswitch

    {{ $slot }}
</form>