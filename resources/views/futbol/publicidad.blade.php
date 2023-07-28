@extends('layouts.plantilla')
@section('title', 'Publicidad')

@section('content')
    <h1>Estas en Publicidad de Mi.Futbol</h1>

    <h2>Agregar Futbol</h2>
    <form action="{{ route('futbol.addpublicidad') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="name">Nombre de la Marca:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Descripción:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <label for="time">Tiempo (meses):</label>
        <input type="number" id="time" name="time" min="1" required><br><br>

        <label for="image">Imagen:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <input type="submit" value="Agregar Publicidad">
        <a href="{{ route('futbol.index') }}">cancelar</a>

    </form>
@endsection
