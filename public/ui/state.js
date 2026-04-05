const SESSION_KEY = 'cre8_ui_session_v1';

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
