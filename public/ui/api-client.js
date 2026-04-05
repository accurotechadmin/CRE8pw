import { readDeviceId, readSession } from '/ui/state.js';

function normalizeError(status, payload) {
  if (payload?.error) {
    return {
      status,
      code: payload.error.code ?? 'request_failed',
      message: payload.error.message ?? 'request failed',
      details: Array.isArray(payload.error.details) ? payload.error.details : [],
      requestId: payload.error.request_id ?? payload?.meta?.request_id ?? null,
      raw: payload,
    };
  }

  return {
    status,
    code: 'request_failed',
    message: `request failed with status ${status}`,
    details: [],
    requestId: payload?.meta?.request_id ?? null,
    raw: payload,
  };
}

export async function apiRequest(path, options = {}) {
  const session = readSession();
  const authSurface = options.authSurface ?? null;
  const resolvedSurface = authSurface === 'active' ? session.activeSurface : authSurface;
  const authToken = resolvedSurface && session[resolvedSurface]?.accessToken ? session[resolvedSurface].accessToken : null;
  const shouldAttachDeviceId = options.requireDeviceId === true;

  const response = await fetch(path, {
    method: options.method ?? 'GET',
    headers: {
      ...(options.body ? { 'Content-Type': 'application/json' } : {}),
      ...(authToken ? { Authorization: `Bearer ${authToken}` } : {}),
      ...(shouldAttachDeviceId ? { 'X-Device-Id': readDeviceId() } : {}),
      ...(options.headers ?? {}),
    },
    body: options.body ? JSON.stringify(options.body) : undefined,
  });

  const text = await response.text();
  let payload = null;

  if (text !== '') {
    try {
      payload = JSON.parse(text);
    } catch (_error) {
      payload = { error: { message: text } };
    }
  }

  const requestId = response.headers.get('X-Request-Id') ?? payload?.meta?.request_id ?? null;

  if (!response.ok) {
    throw normalizeError(response.status, payload);
  }

  return {
    status: response.status,
    requestId,
    envelopeVersion: response.headers.get('X-Envelope-Version') ?? payload?.meta?.envelope_version ?? null,
    data: payload?.data ?? null,
    raw: payload,
  };
}
