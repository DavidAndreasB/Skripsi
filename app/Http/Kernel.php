<?php
app/Http/Kernel.php

// ... (bagian atas file)

class Kernel extends HttpKernel
{
    // ... (property $middleware dan $middlewareGroups lainnya)

    /**
     * The application's route middleware aliases.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        // ... middleware bawaan lainnya
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Tambahkan alias untuk middleware Admin kita
        // Gunakan namespace penuh yang baru: App\Http\EnsureUserIsAdmin
        'admin' => \App\Http\EnsureUserIsAdmin::class, 
    ];
}