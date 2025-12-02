<?php

// Importa las clases principales del framework Laravel necesarias
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Retorna la configuración principal de la aplicación Laravel.
// Este archivo define cómo se arranca la app y qué rutas, middlewares y excepciones se cargan.
return Application::configure(basePath: dirname(__DIR__))
    
    // 👇 Sección de enrutamiento (rutas del proyecto)
    ->withRouting(
        // Rutas web normales: vistas, controladores, etc.
        web: __DIR__.'/../routes/web.php',

        // Rutas de API (si el proyecto usa endpoints para servicios o apps externas)
        api: __DIR__.'/../routes/api.php',

        // Rutas de comandos de consola personalizados (Artisan)
        commands: __DIR__.'/../routes/console.php',

        // Ruta de "health check", usada para verificar que el servidor está en línea
        health: '/up',
    )

    // 👇 Configuración de los middlewares personalizados
    ->withMiddleware(function (Middleware $middleware): void {
        // Se definen alias para los middlewares, es decir, nombres cortos
        // que luego pueden usarse en las rutas sin tener que escribir la clase completa.
        $middleware->alias([
            // Alias 'role' → se vincula con la clase RoleRedirect
            // Esto permite usar ->middleware(['role']) directamente en las rutas.
            'role' => \App\Http\Middleware\RoleRedirect::class,
        ]);
    })

    // 👇 Manejo global de excepciones (errores)
    ->withExceptions(function (Exceptions $exceptions): void {
        // Aquí podrías registrar o personalizar la forma en que Laravel
        // maneja las excepciones (errores de servidor, validación, etc.)
        // Por ahora está vacío, pero se puede usar para capturar errores globalmente.
    })

    // 👇 Finalmente, crea y retorna la instancia completa de la aplicación
    ->create();
