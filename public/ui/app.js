import { apiRequest } from '/ui/api-client.js';
import { clearSession, readSession, writeSession } from '/ui/state.js';

const staticRoutes = {
  '/login': ownerLoginView,
  '/key-login': keyLoginView,
  '/signup-owner': signupOwnerView,
  '/feed': feedView,
};

const dynamicRoutes = [
  { pattern: /^\/posts\/([^/]+)$/, view: postDetailView, paramNames: ['postId'] },
  { pattern: /^\/posts\/([^/]+)\/comments$/, view: commentsView, paramNames: ['postId'] },
];

const navItems = [
  { path: '/login', label: 'Owner Login' },
  { path: '/key-login', label: 'Key Login' },
  { path: '/signup-owner', label: 'Owner Signup' },
  { path: '/feed', label: 'Gateway Feed' },
];

let flashMessage = null;
let lastResponse = null;

const feedState = {
  status: 'idle',
  items: [],
  paging: null,
  scope: 'delegated',
  limit: 20,
  error: null,
};

const postState = {
  postId: null,
  status: 'idle',
  item: null,
  error: null,
};

const commentsState = {
  postId: null,
  status: 'idle',
  items: [],
  error: null,
};

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

function resolveRoute() {
  const path = location.pathname.replace('/ui', '') || '/login';

  if (staticRoutes[path]) {
    return { path, view: staticRoutes[path], params: {} };
  }

  for (const route of dynamicRoutes) {
    const match = path.match(route.pattern);
    if (!match) {
      continue;
    }

    const params = route.paramNames.reduce((acc, name, index) => {
      acc[name] = decodeURIComponent(match[index + 1]);

      return acc;
    }, {});

    return { path, view: route.view, params };
  }

  return { path: '/login', view: staticRoutes['/login'], params: {} };
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

function renderNav(activePath) {
  navRoot.innerHTML = navItems
    .map(({ path: itemPath, label }) => `<a href="/ui${itemPath}" data-path="${itemPath}" ${itemPath === activePath ? 'aria-current="page"' : ''}>${label}</a>`)
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
  const route = resolveRoute();
  updateSessionChip();
  renderNav(route.path);
  renderFlash();
  route.view(route.params);
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

function requireGatewaySession() {
  const session = readSession();
  if (session.activeSurface === 'key' && session.key?.accessToken) {
    return true;
  }

  viewRoot.innerHTML = `<article class="panel"><h2>Gateway key login required</h2><p>Use Key Login to access gateway read flows.</p><p><a href="/ui/key-login" data-path="/key-login">Go to key login</a></p></article>`;
  const link = viewRoot.querySelector('a[data-path]');
  if (link) {
    link.addEventListener('click', (event) => {
      event.preventDefault();
      navigate('/key-login');
    });
  }

  return false;
}

async function gatewayRequest(path, options = {}) {
  try {
    return await apiRequest(path, { ...options, authSurface: 'key', requireDeviceId: true });
  } catch (error) {
    if (error.status === 401) {
      clearSession();
      flashMessage = { type: 'error', text: 'Session expired for gateway surface. Please sign in again.' };
    }

    throw error;
  }
}

function feedView() {
  if (!requireGatewaySession()) {
    return;
  }

  if (feedState.status === 'idle') {
    fetchFeed({ reset: true });
  }

  if (feedState.status === 'loading') {
    viewRoot.innerHTML = '<article class="panel"><h2>Feed</h2><p>Loading feed…</p></article>';
    return;
  }

  if (feedState.status === 'error') {
    viewRoot.innerHTML = `<article class="panel"><h2>Feed</h2><p class="error-text">${feedState.error?.message ?? 'Failed to load feed.'}</p><button type="button" id="retry-feed">Retry</button></article>`;
    document.getElementById('retry-feed').addEventListener('click', () => fetchFeed({ reset: true }));
    return;
  }

  const hasItems = feedState.items.length > 0;
  const hasMore = Boolean(feedState.paging?.has_more && feedState.paging?.cursor);

  viewRoot.innerHTML = `<article class="panel">
      <h2>Feed</h2>
      <form id="feed-controls" class="row-controls">
        <label>Scope
          <select name="scope">
            ${['delegated', 'public', 'private'].map((scope) => `<option value="${scope}" ${feedState.scope === scope ? 'selected' : ''}>${scope}</option>`).join('')}
          </select>
        </label>
        <label>Limit
          <input type="number" min="1" max="200" name="limit" value="${feedState.limit}" />
        </label>
        <button type="submit">Reload</button>
      </form>
      ${hasItems ? `<ul class="list">${feedState.items.map((post) => `<li><strong>${escapeHtml(post.title ?? '(untitled)')}</strong><br /><small>${escapeHtml(post.id)} · ${escapeHtml(post.state ?? 'n/a')} · ${escapeHtml(post.visibility_scope ?? 'n/a')}</small><br /><a href="/ui/posts/${encodeURIComponent(post.id)}" data-path="/posts/${encodeURIComponent(post.id)}">Open post</a></li>`).join('')}</ul>` : '<p>No posts available for this scope.</p>'}
      <div class="row-actions">
        <button type="button" id="load-more" ${hasMore ? '' : 'disabled'}>Load more</button>
      </div>
    </article>`;

  document.getElementById('feed-controls').addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(event.currentTarget);
    const limit = Number.parseInt(String(formData.get('limit') ?? '20'), 10);
    feedState.scope = String(formData.get('scope') ?? 'delegated');
    feedState.limit = Number.isNaN(limit) ? 20 : Math.max(1, Math.min(200, limit));
    fetchFeed({ reset: true });
  });

  document.querySelectorAll('a[data-path]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
      event.preventDefault();
      navigate(anchor.dataset.path);
    });
  });

  document.getElementById('load-more').addEventListener('click', () => {
    fetchFeed({ reset: false });
  });
}

async function fetchFeed({ reset }) {
  feedState.status = 'loading';
  feedState.error = null;
  render();

  try {
    const cursor = reset ? null : feedState.paging?.cursor;
    const query = new URLSearchParams({
      scope: feedState.scope,
      limit: String(feedState.limit),
    });
    if (cursor) {
      query.set('cursor', cursor);
    }

    const response = await gatewayRequest(`/api/feed?${query.toString()}`);
    lastResponse = response;
    const incoming = Array.isArray(response.data) ? response.data : [];
    feedState.items = reset ? incoming : [...feedState.items, ...incoming];
    feedState.paging = response.raw?.paging ?? null;
    feedState.status = 'success';
  } catch (error) {
    lastResponse = error;
    feedState.error = error;
    feedState.status = 'error';
  }

  render();
}

function postDetailView({ postId }) {
  if (!requireGatewaySession()) {
    return;
  }

  if (postState.postId !== postId || postState.status === 'idle') {
    fetchPost(postId);
  }

  if (postState.status === 'loading') {
    viewRoot.innerHTML = '<article class="panel"><h2>Post detail</h2><p>Loading post…</p></article>';
    return;
  }

  if (postState.status === 'error') {
    const notFound = postState.error?.status === 404;
    viewRoot.innerHTML = `<article class="panel"><h2>Post detail</h2><p class="error-text">${notFound ? 'Post not found or not visible for this key.' : postState.error?.message ?? 'Unable to load post.'}</p><button id="retry-post" type="button">Retry</button></article>`;
    document.getElementById('retry-post').addEventListener('click', () => fetchPost(postId));
    return;
  }

  if (!postState.item) {
    viewRoot.innerHTML = '<article class="panel"><h2>Post detail</h2><p>No post data found.</p></article>';
    return;
  }

  const post = postState.item;
  viewRoot.innerHTML = `<article class="panel">
      <h2>${escapeHtml(post.title ?? '(untitled)')}</h2>
      <p>${escapeHtml(post.body ?? '')}</p>
      <dl class="meta-grid">
        <dt>Post ID</dt><dd>${escapeHtml(post.id ?? '')}</dd>
        <dt>Author</dt><dd>${escapeHtml(post.author_id ?? '')}</dd>
        <dt>State</dt><dd>${escapeHtml(post.state ?? '')}</dd>
        <dt>Visibility</dt><dd>${escapeHtml(post.visibility_scope ?? '')}</dd>
        <dt>Created</dt><dd>${escapeHtml(post.created_at_utc ?? '')}</dd>
      </dl>
      <div class="row-actions">
        <a href="/ui/feed" data-path="/feed">Back to feed</a>
        <a href="/ui/posts/${encodeURIComponent(postId)}/comments" data-path="/posts/${encodeURIComponent(postId)}/comments">View comments</a>
      </div>
    </article>`;

  document.querySelectorAll('a[data-path]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
      event.preventDefault();
      navigate(anchor.dataset.path);
    });
  });
}

async function fetchPost(postId) {
  postState.postId = postId;
  postState.status = 'loading';
  postState.error = null;
  postState.item = null;
  render();

  try {
    const response = await gatewayRequest(`/api/posts/${encodeURIComponent(postId)}`);
    lastResponse = response;
    postState.item = response.data ?? null;
    postState.status = 'success';
  } catch (error) {
    lastResponse = error;
    postState.error = error;
    postState.status = 'error';
  }

  render();
}

function commentsView({ postId }) {
  if (!requireGatewaySession()) {
    return;
  }

  if (commentsState.postId !== postId || commentsState.status === 'idle') {
    fetchComments(postId);
  }

  if (commentsState.status === 'loading') {
    viewRoot.innerHTML = '<article class="panel"><h2>Comments</h2><p>Loading comments…</p></article>';
    return;
  }

  if (commentsState.status === 'error') {
    const notFound = commentsState.error?.status === 404;
    viewRoot.innerHTML = `<article class="panel"><h2>Comments</h2><p class="error-text">${notFound ? 'Comments unavailable because post is missing or hidden.' : commentsState.error?.message ?? 'Failed to load comments.'}</p><button id="retry-comments" type="button">Retry</button></article>`;
    document.getElementById('retry-comments').addEventListener('click', () => fetchComments(postId));
    return;
  }

  const hasItems = commentsState.items.length > 0;

  viewRoot.innerHTML = `<article class="panel">
      <h2>Comments for post ${escapeHtml(postId)}</h2>
      ${hasItems ? `<ul class="list">${commentsState.items.map((comment) => `<li><p>${escapeHtml(comment.body ?? '')}</p><small>${escapeHtml(comment.id ?? '')} · ${escapeHtml(comment.author_id ?? '')} · ${escapeHtml(comment.created_at_utc ?? '')}</small></li>`).join('')}</ul>` : '<p>No comments yet for this post.</p>'}
      <div class="row-actions">
        <a href="/ui/posts/${encodeURIComponent(postId)}" data-path="/posts/${encodeURIComponent(postId)}">Back to post</a>
        <a href="/ui/feed" data-path="/feed">Back to feed</a>
      </div>
    </article>`;

  document.querySelectorAll('a[data-path]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
      event.preventDefault();
      navigate(anchor.dataset.path);
    });
  });
}

async function fetchComments(postId) {
  commentsState.postId = postId;
  commentsState.status = 'loading';
  commentsState.error = null;
  commentsState.items = [];
  render();

  try {
    const response = await gatewayRequest(`/api/posts/${encodeURIComponent(postId)}/comments`);
    lastResponse = response;
    commentsState.items = Array.isArray(response.data) ? response.data : [];
    commentsState.status = 'success';
  } catch (error) {
    lastResponse = error;
    commentsState.error = error;
    commentsState.status = 'error';
  }

  render();
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

      navigate('/feed');

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

function escapeHtml(value) {
  return String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#39;');
}

render();
