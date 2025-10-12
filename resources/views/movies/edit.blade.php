<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{ route('movies.update', $registro->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Título</label>
    <input type="text" name="titulo" value="{{ $registro->titulo }}">
    <label>Descripción</label>
    <textarea name="descripcion">{{ $registro->descripcion }}</textarea>
    <label>Duracion</label>
    <textarea name="duracion">{{ $registro->duracion }}</textarea>
    <label>Año</label>
    <textarea name="año">{{ $registro->año }}</textarea>
    <label>Autor</label>
    <textarea name="autor">{{ $registro->autor }}</textarea>
    @if($registro->ruta_imagen)
    <div>
        <p>Imagen actual</p>
        <img src="{{ asset('storage/' . $registro->ruta_imagen) }}" alt="Imagen de {{ $registro->titulo }}" width="150">
    </div>
    @endif
    <div>
        <label for="imagen">Cambiar imagen</label>
        <input type="file" name="imagen" id="imagen">
    </div>
    <button type="submit">Actualizar</button>
</form>
</div>
</body>
</html>