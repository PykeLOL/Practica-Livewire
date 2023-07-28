@extends('layouts.plantilla')

@section('title', 'Mi.Futbol')

@section('content')
    <h1>Estas en mi futbol</h1>
    <h2>Tabla de demostracion:</h2>
    <table class="table" style="width: 60%;" border= 5px;>
        <thead class="thead-dark"><tr>
            <td rowspan="3">NOMBRE</td>
            <td>DESCRIPTION</td>
            <td>TIEMPO PACTADO</td>
            <td>IMAGEN</td>
        </tr></thead>
        <tbody>
            <tr>
                <td><h3>BetPlay</h3></td>
                <td>
                    <p>BetPlay es la marca de apuestas Online que pone a
                    tu disposición más de 300,000 eventos al año de tus
                    disciplinas deportivas favoritas, las cuales permiten
                    un sin número de posibilidades de apuesta y están
                    disponible todos los días, las 24 horas.</p>
                </td>
                <td>1 mes</td>
                <td><img src="images/betplay.jpg" alt="" width="300px"></td>
            </tr>
    </tbody>
</table>

<h2>Publicidad en Vivo</h2>
<br>
<table class="table" style="width: 60%;" border= 5px;>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Duración (meses)</th>
            <th>Imagen</th>
        </tr>
    </thead>
    <tbody align="center">
        @foreach ($futbols as $futbol)
            @if($futbol->status)
                <tr>
                    <td>{{ $futbol->name }}</td>
                    <td>{{ $futbol->description }}</td>
                    <td>{{ $futbol->time }}</td>
                    <td><img src="{{ asset('storage/images/' . $futbol->image_path) }}" alt="Imagen" width="300px" height="200px"></td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<h2>Publicidades agregadas:</h2>
<button class="btn btn-success"><a href="{{ route('futbol.publicidad') }}" style="color: white;">Pactar Publicidad</a></button><br>
<br>
<table class="table" style="width: 60%;" border= 5px;>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Duración (meses)</th>
            <th>Imagen</th>
            <th>PAGAR</th>
        </tr>
    </thead>
    <tbody align="center">
        @foreach ($futbols as $futbol)
                <tr>
                    <td>{{ $futbol->name }}</td>
                    <td>{{ $futbol->description }}</td>
                    <td>{{ $futbol->time }}</td>
                    <td><img src="{{ asset('storage/images/' . $futbol->image_path) }}" alt="Imagen" width="300px" height="200px"></td>
                    <td>
                        <button class="btn btn-success"><a target="_blank" style="color: white;" href="{{ route('pasarela.publicidad', ['id' => $futbol->id]) }}">Pagar con PayU</a>
                        </button>
                    </td>
                </tr>
        @endforeach
    </tbody>
</table>

@endsection
