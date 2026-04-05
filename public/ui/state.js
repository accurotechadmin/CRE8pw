const SESSION_KEY = 'cre8_ui_session_v1';
const DEVICE_KEY = 'cre8_ui_device_id_v1';

const defaultSession = {
  activeSurface: null,
  owner: null,
  key: null,
};

export function readSession() {
  try {
    const raw = localStorage.getItem(SESSION_KEY);
    if (!raw) {
      return { ...defaultSession };
    }

    const parsed = JSON.parse(raw);

    return {
      activeSurface: parsed.activeSurface ?? null,
      owner: parsed.owner ?? null,
      key: parsed.key ?? null,
    };
  } catch (_error) {
    return { ...defaultSession };
  }
}

export function writeSession(nextSession) {
  localStorage.setItem(SESSION_KEY, JSON.stringify(nextSession));
}

export function clearSession() {
  localStorage.removeItem(SESSION_KEY);
}

export function readDeviceId() {
  const existing = localStorage.getItem(DEVICE_KEY);
  if (existing && existing.trim() !== '') {
    return existing;
  }

  const generated = typeof crypto !== 'undefined' && typeof crypto.randomUUID === 'function'
    ? `web-${crypto.randomUUID()}`
    : `web-${Date.now()}-${Math.random().toString(16).slice(2)}`;

  localStorage.setItem(DEVICE_KEY, generated);

  return generated;
}
