<?php

declare(strict_types=1);

namespace Cre8\Application;

final class PipelineDefinition
{
    /**
     * @return list<PipelineStage>
     */
    public static function orderedStages(): array
    {
        return [
            PipelineStage::TransportSecurityHeaders,
            PipelineStage::RequestCorrelation,
            PipelineStage::InputParsing,
            PipelineStage::AuthenticationProofVerification,
            PipelineStage::AuthorizationDecisionGate,
            PipelineStage::HandlerExecution,
            PipelineStage::EnvelopeRendering,
            PipelineStage::StructuredErrorMapping,
        ];
    }
}
