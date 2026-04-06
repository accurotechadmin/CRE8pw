<?php

declare(strict_types=1);

namespace Cre8\Modules\Health\Application\UseCases;

final class GetStatus
{
    /**
     * @return array<string,string>
     */
    public function execute(): array
    {
        return [
            'service' => 'cre8',
            'status' => 'ok',
        ];
    }
}
