<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Listado de Películas</h1>
<?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<img src="<?php echo e(asset('storage/' . $peli->ruta_imagen)); ?>" alt="Imagen de <?php echo e($peli->titulo); ?>" width="200">

    <h2><?php echo e($peli->titulo); ?></h2>

    <p><?php echo e($peli->descripcion); ?></p>

    <small>Duración: <?php echo e($peli->duracion); ?> minutos</small>

    <a href="<?php echo e(route('movies.edit',$peli->id)); ?>" class="btn btn-success">editar película</a>

    <form action="<?php echo e(route('movies.destroy',$peli->id)); ?>" method="POST" >
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" onclick="return confirm('estas seguro de eliminar?')">Eliminar</button>
    </form>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<br>
<a href="<?php echo e(route('movies.create')); ?>" class="btn btn-success">Agregar película</a>

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
</html><?php /**PATH C:\backup\cine_laravel\resources\views/movies/index.blade.php ENDPATH**/ ?>