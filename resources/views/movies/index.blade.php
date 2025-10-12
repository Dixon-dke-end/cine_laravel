




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Listado de Películas</h1>

@foreach($movies as $peli)
    <img src="{{ asset('storage/'.$peli->ruta_imagen) }}" alt="Imagen de {{ $peli->titulo }}">
    <h2>{{ $peli->titulo }}</h2>
    <p>{{ $peli->descripcion }}</p>
    <small>Duración: {{ $peli->ruta_imagen }} minutos</small>
    <a href="{{route('movies.edit',$peli->id) }}" class="btn btn-success">editar película</a>
    <form action="{{route('movies.destroy',$peli->id) }}" method="POST" >
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('estas seguro de eliminar?')">Eliminar</button>
    </form>
@endforeach

<br>
<a href="{{route('movies.create') }}" class="btn btn-success">Agregar película</a>

</body>
<script>
function confirmarAccion() {
  // Muestra el cuadro de diálogo de confirmación
  const respuesta = confirm("¿Estás seguro de que quieres enviar esta acción?");

  // Si el usuario presiona "Aceptar" (respuesta es true)
  if (respuesta) {
    // Aquí pones el código para enviar el formulario o realizar la acción
    alert("¡Acción enviada!");
    // Por ejemplo: document.getElementById("myForm").submit();
  } else {
    // Si el usuario presiona "Cancelar"
    alert("Acción cancelada.");
  }
}
</script>
</html>