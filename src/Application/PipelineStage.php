<?php

declare(strict_types=1);

namespace Cre8\Application;

enum PipelineStage: string
{
    case TransportSecurityHeaders = 'transport_security_headers';
    case RequestCorrelation = 'request_correlation';
    case InputParsing = 'input_parsing';
    case AuthenticationProofVerification = 'authentication_proof_verification';
    case AuthorizationDecisionGate = 'authorization_decision_gate';
    case HandlerExecution = 'handler_execution';
    case EnvelopeRendering = 'envelope_rendering';
    case StructuredErrorMapping = 'structured_error_mapping';
}
