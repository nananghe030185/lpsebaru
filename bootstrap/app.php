<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CorporateMiddleware;
use App\Http\Middleware\GmtMiddleware;
use App\Http\Middleware\MemberMiddleware;
use App\Http\Middleware\NonMemberMiddleware;
use App\Http\Middleware\ReferalSystem;
use App\Http\Middleware\TrialMiddleware;
use App\Http\Middleware\VisitorTracking;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'nonmember' => NonMemberMiddleware::class,
            'member' => MemberMiddleware::class,
            'trial' => TrialMiddleware::class,
            'corporate' => CorporateMiddleware::class,
            'gmt' => GmtMiddleware::class,
        ]);
        $middleware->web(append: [
            \Fahlisaputra\Minify\Middleware\MinifyHtml::class,
            \Fahlisaputra\Minify\Middleware\MinifyCss::class,
            \Fahlisaputra\Minify\Middleware\MinifyJavascript::class,
            VisitorTracking::class,
            ReferalSystem::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
