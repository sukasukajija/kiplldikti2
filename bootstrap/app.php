<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([

            'superadmin' => \App\Http\Middleware\superadmin::class,
            'operatorpt' => \App\Http\Middleware\OperatorPT::class,
            /* 'berita' => \App\Http\Middleware\berita::class,
            'pt' => \App\Http\Middleware\dataperguruantinggi::class,
            'prodi' => \App\Http\Middleware\dataprodi::class,
            'fasilitas_pt' => \App\Http\Middleware\fasilitas_pt::class,
            'fasilitasprodi' => \App\Http\Middleware\fasilitasprodi::class,
            'pedoman' => \App\Http\Middleware\pedoman::class,
            'statuta' => \App\Http\Middleware\statuta::class,
            'struktural' => \App\Http\Middleware\struktural::class,
            'sdm' => \App\Http\Middleware\sdm::class, */
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
