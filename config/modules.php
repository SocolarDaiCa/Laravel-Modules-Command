<?php

use Nwidart\Modules\Activators\FileActivator;

return [
    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => true,
        'path' => base_path('vendor/socoladaica/laravel-modules-command/stubs'),
        'files' => $files = [
            // // 'views/index' => 'resources/views/index.blade.php',
            // 'views/master' => 'resources/views/layouts/master.blade.php',
            // 'scaffold/config' => 'config/config.php',
            // /**/
            // /**/
            /* Folder */
            '.github/workflows/audit.yml' => '.github/workflows/audit.yml',
            '.github/dependabot.yml' => '.github/dependabot.yml',
            'config/config.php' => 'config/__LOWER_NAME__.php',
            'public/.gitkeep' => 'public/vendor/__VENDOR__/__LOWER_NAME__/.gitkeep',
            'resources/assets/js/app.js' => 'resources/assets/js/app.js',
            'resources/assets/sass/app.scss' => 'resources/assets/sass/app.scss',
            'resources/assets/img/.gitkeep' => 'resources/assets/img/.gitkeep',
            'resources/views/pages/.gitkeep' => 'resources/views/pages/.gitkeep',
            'routes/api.php' => 'routes/api.php',
            'routes/channels.php' => 'routes/channels.php',
            'routes/console.php' => 'routes/console.php',
            'routes/web.php' => 'routes/web.php',
            'src/Console/Kernel.php' => 'src/Console/Kernel.php',
            'src/Exceptions/Handler.php' => 'src/Exceptions/Handler.php',
            'src/Http/Controllers/Controller.php' => 'src/Http/Controllers/Controller.php',
            'src/Http/Kernel.php' => 'src/Http/Kernel.php',
            'src/Providers/AppServiceProvider.php' => 'src/Providers/__STUDLY_NAME__ServiceProvider.php',
            'src/Providers/BroadcastServiceProvider.php' => 'src/Providers/BroadcastServiceProvider.php',
            'src/Providers/EventServiceProvider.php' => 'src/Providers/EventServiceProvider.php',
            'src/Providers/RouteServiceProvider.php' => 'src/Providers/RouteServiceProvider.php',
            /* File */
            '.editorconfig.stub' => '.editorconfig',
            '.gitattributes.stub' => '.gitattributes',
            '.gitignore.stub' => '.gitignore',
            'composer.json' => 'composer.json',

            'LICENSE/'.config('laravel-modules-command.composer.license') => 'LICENSE',
            'package.json' => 'package.json',
            'phpunit.xml.stub' => 'phpunit.xml',
            'README.md' => 'README.md',
            'webpack.mix.js' => 'webpack.mix.js',
        ],
        'force_overwire' => [
            '.github/workflows/php-cs-fixer.yml',
            '.github/dependabot.yml',
        ],
        'replacements' => array_merge(
            [
                'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            ],
            array_map(fn ($item) => [
                'AUTHOR_EMAIL',
                'AUTHOR_NAME',
                'AUTHOR_ROLE',
                'AUTHOR_HOMEPAGE',
                'PHP',
                'LOWER_NAME',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
                'STUDLY_NAME',
                'VENDOR',
                'YEAR',
                'LICENSE',
                'PATH_CONFIG',
                'PATH_VIEWS',
                'PATH_LANG',
                'PATH_MIGRATIONS',
            ], $files)
        ),
        'gitkeep' => true,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('Modules'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'config' => ['path' => 'config', 'generate' => false],
            'command' => ['namespace' => 'Console/Commands', 'path' => 'src/Console/Commands', 'generate' => false],
            'cast' => ['namespace' => 'Casts', 'path' => 'src/Casts', 'generate' => false],
            'migration' => ['namespace' => 'Database/Migrations', 'path' => 'database/migrations', 'generate' => true],
            'seeder' => ['namespace' => 'Database/Seeders', 'path' => 'database/seeders', 'generate' => false],
            'factory' => ['namespace' => 'Database/Factories', 'path' => 'database/factories', 'generate' => true],
            'model' => ['namespace' => 'Models', 'path' => 'src/Models', 'generate' => false],
            'routes' => ['path' => 'routes', 'generate' => false],
            'controller' => ['namespace' => 'Http/Controllers', 'path' => 'src/Http/Controllers', 'generate' => false],
            // 'filter' => ['namespace' => 'Http/Middleware', 'path' => 'src/Http/Middleware', 'generate' => false],
            'middleware' => ['namespace' => 'Http/Middleware', 'path' => 'src/Http/Middleware', 'generate' => false],
            'request' => ['namespace' => 'Http/Requests', 'path' => 'src/Http/Requests', 'generate' => false],
            'provider' => ['namespace' => 'Providers', 'path' => 'src/Providers', 'generate' => false],
            'assets' => ['path' => 'resources/assets', 'generate' => true],
            'lang' => ['path' => 'resources/lang', 'generate' => true],
            'views' => ['path' => 'resources/views', 'generate' => true],
            'test' => ['namespace' => 'Tests/Unit', 'path' => 'tests/Unit', 'generate' => true],
            'test-feature' => ['namespace' => 'Tests/Feature', 'path' => 'tests/Feature', 'generate' => true],
            'repository' => ['namespace' => 'Repositories', 'path' => 'src/Repositories', 'generate' => false],
            'event' => ['namespace' => 'Events', 'path' => 'src/Events', 'generate' => false],
            'listener' => ['namespace' => 'Listeners', 'path' => 'src/Listeners', 'generate' => false],
            'policies' => ['namespace' => 'Policies', 'path' => 'src/Policies', 'generate' => false],
            'policy' => ['namespace' => 'Policies', 'path' => 'src/Policies', 'generate' => false],
            'rules' => ['namespace' => 'Rules', 'path' => 'src/Rules', 'generate' => false],
            'rule' => ['namespace' => 'Rules', 'path' => 'src/Rules', 'generate' => false],
            'jobs' => ['namespace' => 'Jobs', 'path' => 'src/Jobs', 'generate' => false],
            'job' => ['namespace' => 'Jobs', 'path' => 'src/Jobs', 'generate' => false],
            'emails' => ['namespace' => 'Mail', 'path' => 'src/Mail', 'generate' => false],
            'exception' => ['namespace' => 'Exceptions', 'path' => 'src/Exceptions', 'generate' => false],
            'notifications' => ['namespace' => 'Notifications', 'path' => 'src/Notifications', 'generate' => false],
            'notification' => ['namespace' => 'Notifications', 'path' => 'src/Notifications', 'generate' => false],
            'resource' => ['namespace' => 'Resources', 'path' => 'src/Resources', 'generate' => false],
            'component-view' => ['path' => 'resources/views/components', 'generate' => false],
            'component-class' => ['namespace' => 'View/Components', 'path' => 'src/View/Components', 'generate' => false],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
    */
    'commands' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        // 'enabled' => true,
        // 'paths' => [
        //     base_path('vendor/*/*'),
        // ],

        'enabled' => false,
        'paths' => [
            base_path('Modules/*'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        // 'enabled' => false && app()->runningInConsole() == false,
        'enabled' => false,
        'key' => 'laravel-modules',
        'lifetime' => 0,

        // 'enabled' => true,
        // 'lifetime' => 60000,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method.
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
            // 'cache-lifetime' => 0,
        ],
    ],

    'activator' => 'file',
];
