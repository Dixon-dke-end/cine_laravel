<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Mensual - CineVel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #0099cc;
        }

        .header h1 {
            color: #0099cc;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #555;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .header p {
            color: #777;
            font-size: 11px;
        }

        .summary-section {
            margin-bottom: 25px;
        }

        .summary-section h3 {
            background: #0099cc;
            color: white;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-row {
            display: table-row;
        }

        .summary-card {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            background: #f9f9f9;
        }

        .summary-card-label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .summary-card-value {
            font-size: 18px;
            color: #0099cc;
            font-weight: bold;
        }

        .table-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .table-section h3 {
            background: #0099cc;
            color: white;
            padding: 8px 12px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table thead {
            background: #e6f7ff;
        }

        table thead th {
            padding: 10px;
            text-align: left;
            border: 1px solid #0099cc;
            font-weight: bold;
            color: #0099cc;
            font-size: 11px;
        }

        table tbody td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            font-size: 11px;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
            background: #f5f5f5;
            border: 1px dashed #ccc;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>🎬 CineVel</h1>
        <h2>Reporte Mensual - <?php echo e($reporte['mes']); ?> <?php echo e($reporte['año']); ?></h2>
        <p>Generado el <?php echo e(date('d/m/Y H:i')); ?></p>
    </div>

    <!-- RESUMEN GENERAL -->
    <div class="summary-section">
        <h3>📊 Resumen General</h3>
        
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-card">
                    <div class="summary-card-label">Películas Exhibidas</div>
                    <div class="summary-card-value"><?php echo e($reporte['resumen']['total_peliculas']); ?></div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-label">Total de Funciones</div>
                    <div class="summary-card-value"><?php echo e($reporte['resumen']['total_funciones']); ?></div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-label">Boletos Vendidos</div>
                    <div class="summary-card-value"><?php echo e($reporte['resumen']['total_boletos']); ?></div>
                </div>
            </div>
        </div>

        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-card">
                    <div class="summary-card-label">Ingresos por Boletos</div>
                    <div class="summary-card-value">$<?php echo e($reporte['resumen']['ingresos_boletos']); ?></div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-label">Ingresos por Confitería</div>
                    <div class="summary-card-value">$<?php echo e($reporte['resumen']['ingresos_confiteria']); ?></div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-label">Ingresos Totales</div>
                    <div class="summary-card-value">$<?php echo e($reporte['resumen']['ingresos_totales']); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DE PELÍCULAS -->
    <div class="table-section">
        <h3>🎬 Detalles por Película</h3>
        <?php if(count($reporte['peliculas']) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Película</th>
                        <th class="text-center">Funciones</th>
                        <th class="text-center">Boletos Vendidos</th>
                        <th class="text-right">Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $reporte['peliculas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelicula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($pelicula['titulo']); ?></td>
                            <td class="text-center"><?php echo e($pelicula['funciones']); ?></td>
                            <td class="text-center"><?php echo e($pelicula['boletos_vendidos']); ?></td>
                            <td class="text-right">$<?php echo e(number_format($pelicula['ingresos'], 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No hay datos de películas para este período</div>
        <?php endif; ?>
    </div>

    <!-- TABLA DE CONFITERÍA -->
    <div class="table-section">
        <h3>🍿 Ventas de Confitería</h3>
        <?php if(count($reporte['confiteria']) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad Vendida</th>
                        <th class="text-right">Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $reporte['confiteria']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item['producto']); ?></td>
                            <td class="text-center"><?php echo e($item['cantidad']); ?></td>
                            <td class="text-right">$<?php echo e(number_format($item['ingresos'], 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No hay ventas de confitería para este período</div>
        <?php endif; ?>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        CineVel - Sistema de Gestión de Cine | Este documento es confidencial
    </div>
</body>
</html>
<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/reportes/pdf.blade.php ENDPATH**/ ?>