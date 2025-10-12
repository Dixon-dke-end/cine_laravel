
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1>Creacion de peliculas</h1>
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="duracion" class="form-label">Duración (min)</label>
            <input type="number" id="duracion" name="duracion" class="form-control" value="{{ old('duracion') }}">
        </div>

        <div class="mb-3">
            <label for="año" class="form-label">Año</label>
            <input type="number" id="año" name="año" class="form-control" value="{{ old('año') }}">
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Autor / Director</label>
            <input type="text" id="autor" name="autor" class="form-control" value="{{ old('autor') }}">
        </div>
        <div class="mb-3">
            <label for="ruta_imagen" class="form-label">Ruta de la imagen</label>
            <input  type="file" id="ruta_imagen" name="ruta_imagen" class="form-control" value="{{ old('ruta_imagen') }}">
        </div>

        <button type="submit" class="btn btn-primary">Crear película</button>
        <a href="{{route('movies.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
</body>
</html>

