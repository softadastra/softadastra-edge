<?php
declare(strict_types=1);

namespace Modules\Docs\Core\Services;

final class DocsService
{
    public function info(): string
    {
        return 'Module Docs loaded successfully.';
    }
}