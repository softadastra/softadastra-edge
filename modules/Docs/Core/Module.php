<?php

use App\Modules\ModuleContract;
use Ivi\Core\Router\Router;

return new class implements ModuleContract {
    public function name(): string
    {
        return 'Docs/Core';
    }

    public function register(): void
    {
        $path = __DIR__ . '/Config/' . strtolower('Docs') . '.php';
        if (is_file($path)) {
            $cfg = require $path;
            $current = function_exists('config') ? (array) config(strtolower('Docs'), []) : (array) ($GLOBALS['__ivi_config'][strtolower('Docs')] ?? []);
            $merged = array_replace_recursive($current, (array) $cfg);
            if (function_exists('config_set')) {
                config_set(strtolower('Docs'), $merged);
            } else {
                $GLOBALS['__ivi_config'][strtolower('Docs')] = $merged;
            }
        }
    }

    public function boot(Router $router): void
    {
        \App\Controllers\Controller::addViewNamespace(strtolower('Docs'), __DIR__ . '/views');

        $routes = __DIR__ . '/routes/web.php';
        if (is_file($routes)) {
            require $routes;
        }

        $mig = __DIR__ . '/Database/Migrations';
        if (is_dir($mig)) {
            if (function_exists('migrations')) {
                $mgr = migrations();
                if (is_object($mgr) && method_exists($mgr, 'addPath')) {
                    $mgr->addPath($mig);
                } else {
                    $GLOBALS['__ivi_migration_paths'] ??= [];
                    if (!in_array($mig, $GLOBALS['__ivi_migration_paths'], true)) {
                        $GLOBALS['__ivi_migration_paths'][] = $mig;
                    }
                }
            } else {
                $GLOBALS['__ivi_migration_paths'] ??= [];
                if (!in_array($mig, $GLOBALS['__ivi_migration_paths'], true)) {
                    $GLOBALS['__ivi_migration_paths'][] = $mig;
                }
            }
        }

        $seed = __DIR__ . '/Database/Seeders';
        if (is_dir($seed)) {
            $GLOBALS['__ivi_seeder_paths'] ??= [];
            if (!in_array($seed, $GLOBALS['__ivi_seeder_paths'], true)) {
                $GLOBALS['__ivi_seeder_paths'][] = $seed;
            }
        }
    }
};