<?php

declare(strict_types=1);

namespace Cre8\Application;

final class SecurityThreatControlMatrix
{
    /** @var array<string,list<string>> */
    private const THREAT_TO_CONTROLS = [
        'THREAT-001' => ['SEC-CTRL-001', 'SEC-CTRL-004', 'SEC-CTRL-005'],
        'THREAT-002' => ['SEC-CTRL-002', 'SEC-CTRL-005'],
        'THREAT-003' => ['SEC-CTRL-003', 'SEC-CTRL-005'],
    ];

    /** @return list<string> */
    public static function controlsForThreat(string $threatId): array
    {
        return self::THREAT_TO_CONTROLS[$threatId] ?? [];
    }

    public static function hasPreventiveAndDetectiveCoverage(string $threatId): bool
    {
        $controls = self::controlsForThreat($threatId);
        $preventive = false;
        $detective = false;

        foreach ($controls as $control) {
            if (in_array($control, ['SEC-CTRL-001', 'SEC-CTRL-002', 'SEC-CTRL-003', 'SEC-CTRL-004'], true)) {
                $preventive = true;
            }
            if ($control === 'SEC-CTRL-005') {
                $detective = true;
            }
        }

        return $preventive && $detective;
    }
}
