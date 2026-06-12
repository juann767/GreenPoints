@extends('layouts.app')
@section('title','Ranking')

@section('content')

<div class="gp-card">
    <h4 style="color:var(--gp-text);font-weight:700;">
        🏆 Ranking de Recicladores
    </h4>

    <p style="color:var(--gp-muted);">
        Top 10 usuarios con más GreenPoints acumulados.
    </p>

    <table class="gp-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $index => $u)
                <tr>
                    <td>
                        @if($index == 0)
                            Diego López
                        @elseif($index == 1)
                            Juan Espinal
                        @elseif($index == 2)
                            Carlos Fuentes
                        @else
                            {{ $index + 1 }}
                        @endif
                    </td>

                    <td>{{ $u->name }}</td>

                    <td style="color:#4ade80;font-weight:700;">
                        {{ $u->puntos }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection