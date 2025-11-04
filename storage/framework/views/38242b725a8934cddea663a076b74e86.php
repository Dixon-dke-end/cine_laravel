<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="<?php echo e(route('movies.update', $registro->id)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <label>Título</label>
    <input type="text" name="titulo" value="<?php echo e($registro->titulo); ?>">
    <label>Descripción</label>
    <textarea name="descripcion"><?php echo e($registro->descripcion); ?></textarea>
    <label>Duracion</label>
    <textarea name="duracion"><?php echo e($registro->duracion); ?></textarea>
    <label>Año</label>
    <textarea name="año"><?php echo e($registro->año); ?></textarea>
    <label>Autor</label>
    <textarea name="autor"><?php echo e($registro->autor); ?></textarea>
    <?php if($registro->ruta_imagen): ?>
    <div>
        <p>Imagen actual</p>
        <img src="<?php echo e(asset('storage/' . $registro->ruta_imagen)); ?>" alt="Imagen de <?php echo e($registro->titulo); ?>" width="150">
    </div>
    <?php endif; ?>
    <div>
        <label for="imagen">Cambiar imagen</label>
        <input type="file" name="imagen" id="imagen">
    </div>
    <button type="submit">Actualizar</button>
</form>
</div>
</body>
</html><?php /**PATH C:\backup\cine_laravel\resources\views/movies/edit.blade.php ENDPATH**/ ?>