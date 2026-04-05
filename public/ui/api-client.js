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
  const response = await fetch(path, {
    method: options.method ?? 'GET',
    headers: {
      'Content-Type': 'application/json',
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
