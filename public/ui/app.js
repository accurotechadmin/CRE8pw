import { apiRequest } from '/ui/api-client.js';
import { clearSession, readSession, writeSession } from '/ui/state.js';

const routes = {
  '/login': ownerLoginView,
  '/key-login': keyLoginView,
  '/signup-owner': signupOwnerView,
};

const navItems = [
  { path: '/login', label: 'Owner Login' },
  { path: '/key-login', label: 'Key Login' },
  { path: '/signup-owner', label: 'Owner Signup' },
];

let flashMessage = null;
let lastResponse = null;

const navRoot = document.getElementById('main-nav');
const viewRoot = document.getElementById('view-root');
const flashRegion = document.getElementById('flash-region');
const responseInspector = document.getElementById('response-inspector');
const sessionChip = document.getElementById('session-chip');

document.getElementById('clear-session').addEventListener('click', () => {
  clearSession();
  flashMessage = { type: 'success', text: 'Session cleared.' };
  navigate('/login');
});

function navigate(path) {
  history.pushState({}, '', `/ui${path}`);
  render();
}

window.addEventListener('popstate', () => render());

function currentPath() {
  const path = location.pathname.replace('/ui', '') || '/login';

  if (!routes[path]) {
    return '/login';
  }

  return path;
}

function updateSessionChip() {
  const session = readSession();

  if (!session.activeSurface) {
    sessionChip.textContent = 'No active session';
    return;
  }

  const token = session[session.activeSurface];
  const tokenBits = token?.permissions ? ` (${token.permissions.join(', ')})` : '';
  sessionChip.textContent = `Surface: ${session.activeSurface}${tokenBits}`;
}

function renderNav(path) {
  navRoot.innerHTML = navItems
    .map(({ path: itemPath, label }) => `<a href="/ui${itemPath}" data-path="${itemPath}" ${itemPath === path ? 'aria-current="page"' : ''}>${label}</a>`)
    .join('');

  navRoot.querySelectorAll('a[data-path]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
      event.preventDefault();
      navigate(anchor.dataset.path);
    });
  });
}

function renderFlash() {
  if (!flashMessage) {
    flashRegion.innerHTML = '';
    return;
  }

  flashRegion.innerHTML = `<div class="flash flash-${flashMessage.type}">${flashMessage.text}</div>`;
}

function renderInspector() {
  if (!lastResponse) {
    responseInspector.innerHTML = '<strong>Response inspector:</strong> No response yet.';
    return;
  }

  responseInspector.innerHTML = `<strong>Response inspector</strong>
    <p>Status: ${lastResponse.status} | Request ID: ${lastResponse.requestId ?? 'n/a'}</p>
    <pre>${JSON.stringify(lastResponse.raw, null, 2)}</pre>`;
}

function render() {
  const path = currentPath();
  updateSessionChip();
  renderNav(path);
  renderFlash();
  routes[path]();
  renderInspector();
}

function fieldErrorMap(details) {
  return details.reduce((acc, detail) => {
    if (typeof detail.path === 'string' && !acc[detail.path]) {
      acc[detail.path] = detail.message ?? detail.code ?? 'invalid value';
    }

    return acc;
  }, {});
}

function formTemplate({ title, fields, buttonText }) {
  return `<article class="panel">
      <h2>${title}</h2>
      <form id="active-form" novalidate>
        ${fields
          .map(({ name, label, type = 'text' }) => `<div class="field"><label for="${name}">${label}</label><input id="${name}" name="${name}" type="${type}" required /><div class="error-text" data-error-for="${name}"></div></div>`)
          .join('')}
        <button id="submit-btn" type="submit">${buttonText}</button>
      </form>
    </article>`;
}

function bindForm({ onSubmit }) {
  const form = document.getElementById('active-form');
  const button = document.getElementById('submit-btn');

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    flashMessage = null;
    form.querySelectorAll('[data-error-for]').forEach((node) => {
      node.textContent = '';
    });

    const body = Object.fromEntries(new FormData(form).entries());

    button.disabled = true;

    try {
      const response = await onSubmit(body);
      lastResponse = response;
      flashMessage = { type: 'success', text: 'Request completed successfully.' };
    } catch (error) {
      lastResponse = error;
      if (error.status === 422) {
        const fieldErrors = fieldErrorMap(error.details);
        Object.entries(fieldErrors).forEach(([field, message]) => {
          const slot = form.querySelector(`[data-error-for="${field}"]`);
          if (slot) {
            slot.textContent = message;
          }
        });
      }
      if (error.status === 401) {
        flashMessage = { type: 'error', text: 'Authentication failed. Check credentials and retry.' };
      } else if (error.status === 409) {
        flashMessage = { type: 'error', text: 'Owner already exists for this email.' };
      } else {
        flashMessage = { type: 'error', text: error.message ?? 'Request failed.' };
      }
    } finally {
      button.disabled = false;
      render();
    }
  });
}

function ownerLoginView() {
  viewRoot.innerHTML = formTemplate({
    title: 'Owner Login',
    buttonText: 'Login',
    fields: [
      { name: 'email', label: 'Email', type: 'email' },
      { name: 'password', label: 'Password', type: 'password' },
    ],
  });

  bindForm({
    onSubmit: async (body) => {
      const response = await apiRequest('/api/auth/login', { method: 'POST', body });
      const now = Date.now();
      writeSession({
        ...readSession(),
        activeSurface: 'owner',
        owner: {
          accessToken: response.data.access_token,
          refreshToken: response.data.refresh_token,
          expiresIn: response.data.expires_in,
          expiresAtMs: now + response.data.expires_in * 1000,
        },
      });

      return response;
    },
  });
}

function keyLoginView() {
  viewRoot.innerHTML = formTemplate({
    title: 'Gateway Key Login',
    buttonText: 'Login with Key',
    fields: [
      { name: 'key_id', label: 'Key ID' },
      { name: 'api_key', label: 'API Key', type: 'password' },
    ],
  });

  bindForm({
    onSubmit: async (body) => {
      const response = await apiRequest('/api/auth/key-login', { method: 'POST', body });
      const now = Date.now();
      writeSession({
        ...readSession(),
        activeSurface: 'key',
        key: {
          accessToken: response.data.access_token,
          refreshToken: response.data.refresh_token,
          expiresIn: response.data.expires_in,
          expiresAtMs: now + response.data.expires_in * 1000,
          keyId: response.data.key_id,
          keyClass: response.data.key_class,
          permissions: response.data.permissions,
          scope: response.data.scope,
          commentsEnabled: response.data.comments_enabled,
        },
      });

      return response;
    },
  });
}

function signupOwnerView() {
  viewRoot.innerHTML = formTemplate({
    title: 'Create Owner',
    buttonText: 'Create Owner',
    fields: [
      { name: 'email', label: 'Email', type: 'email' },
      { name: 'password', label: 'Password', type: 'password' },
    ],
  });

  bindForm({
    onSubmit: async (body) => apiRequest('/console/owners', { method: 'POST', body }),
  });
}

render();
