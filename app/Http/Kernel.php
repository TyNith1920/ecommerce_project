protected $middlewareGroups = [
    'web' => [
        // Other middleware...
        \App\Http\Middleware\SetLocaleMiddleware::class,
    ],
    
];