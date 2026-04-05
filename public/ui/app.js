import { apiRequest } from '/ui/api-client.js';
import { clearSession, readSession, writeSession } from '/ui/state.js';

const staticRoutes = {
  '/login': ownerLoginView,
  '/key-login': keyLoginView,
  '/signup-owner': signupOwnerView,
  '/feed': feedView,
  '/posts/new': postCreateView,
  '/console/posts': consolePostsView,
  '/console/posts/new': consolePostCreateView,
};

const dynamicRoutes = [
  { pattern: /^\/posts\/([^/]+)$/, view: postDetailView, paramNames: ['postId'] },
  { pattern: /^\/posts\/([^/]+)\/edit$/, view: postEditView, paramNames: ['postId'] },
  { pattern: /^\/posts\/([^/]+)\/flag$/, view: postFlagView, paramNames: ['postId'] },
  { pattern: /^\/posts\/([^/]+)\/comments$/, view: commentsView, paramNames: ['postId'] },
  { pattern: /^\/posts\/([^/]+)\/comments\/new$/, view: commentCreateView, paramNames: ['postId'] },
  { pattern: /^\/console\/posts\/([^/]+)\/moderation$/, view: consolePostModerationView, paramNames: ['postId'] },
  { pattern: /^\/console\/posts\/([^/]+)\/comments\/([^/]+)\/moderation$/, view: consoleCommentModerationView, paramNames: ['postId', 'commentId'] },
];

const navItems = [
  { path: '/login', label: 'Owner Login' },
  { path: '/key-login', label: 'Key Login' },
  { path: '/signup-owner', label: 'Owner Signup' },
  { path: '/feed', label: 'Gateway Feed' },
  { path: '/posts/new', label: 'Create Post' },
  { path: '/console/posts', label: 'Console Posts' },
  { path: '/console/posts/new', label: 'Console New Post' },
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

const consolePostsState = {
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

function keyCapabilities() {
  const session = readSession();
  const key = session.key ?? {};

  return {
    isKeySession: session.activeSurface === 'key' && Boolean(key.accessToken),
    keyClass: key.keyClass ?? null,
    permissions: Array.isArray(key.permissions) ? key.permissions : [],
    commentsEnabled: Boolean(key.commentsEnabled),
  };
}

function hasPermission(permission) {
  return keyCapabilities().permissions.includes(permission);
}

function canCreatePost() {
  const caps = keyCapabilities();

  return caps.isKeySession && caps.permissions.includes('posts:create') && caps.keyClass !== 'use';
}

function canEditPost() {
  const caps = keyCapabilities();

  return caps.isKeySession && caps.permissions.includes('posts:edit');
}

function canCreateComment(post) {
  const caps = keyCapabilities();
  const blockedStates = ['locked', 'archived', 'hidden', 'deleted'];

  return caps.isKeySession
    && caps.permissions.includes('comments:create')
    && caps.commentsEnabled
    && !(post && blockedStates.includes(post.state));
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

function bindInternalLinks(scope = document) {
  scope.querySelectorAll('a[data-path]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
      event.preventDefault();
      navigate(anchor.dataset.path);
    });
  });
}

function fieldErrorMap(details) {
  return details.reduce((acc, detail) => {
    if (typeof detail.path === 'string' && !acc[detail.path]) {
      acc[detail.path] = detail.message ?? detail.code ?? 'invalid value';
    }

    return acc;
  }, {});
}

function mapGatewayError(error, fallback = 'Request failed.') {
  if (error.status === 403) {
    const reason = error.raw?.error?.details?.reason;
    if (reason === 'use_key_post_create_forbidden') {
      return 'Use-class keys cannot create posts.';
    }
    if (reason === 'posts_edit_forbidden') {
      return 'Your key does not include posts:edit permission.';
    }
    if (reason === 'comments_permission_missing') {
      return 'Your key does not include comments:create permission.';
    }
    if (reason === 'comments_toggle_off') {
      return 'Comments are disabled for this key.';
    }
    if (reason === 'post_state_blocks_comment_create') {
      return 'This post state does not allow new comments.';
    }

    return 'This action is forbidden for the current key/session.';
  }

  if (error.status === 404) {
    return 'The target resource was not found or is not visible.';
  }

  if (error.status === 422) {
    return 'Please fix validation errors and retry.';
  }

  return error.message ?? fallback;
}

function formTemplate({ title, fields, buttonText, helper = '' }) {
  return `<article class="panel">
      <h2>${title}</h2>
      ${helper ? `<p>${helper}</p>` : ''}
      <form id="active-form" novalidate>
        ${fields
          .map((field) => {
            const {
              name,
              label,
              type = 'text',
              required = true,
              options = null,
              multiline = false,
              placeholder = '',
              value = '',
            } = field;

            const control = multiline
              ? `<textarea id="${name}" name="${name}" ${required ? 'required' : ''} placeholder="${escapeHtml(placeholder)}">${escapeHtml(value)}</textarea>`
              : options
                ? `<select id="${name}" name="${name}" ${required ? 'required' : ''}>${options.map((option) => `<option value="${escapeHtml(option.value)}" ${option.value === value ? 'selected' : ''}>${escapeHtml(option.label)}</option>`).join('')}</select>`
                : `<input id="${name}" name="${name}" type="${type}" ${required ? 'required' : ''} value="${escapeHtml(value)}" placeholder="${escapeHtml(placeholder)}" />`;

            return `<div class="field"><label for="${name}">${label}</label>${control}<div class="error-text" data-error-for="${name}"></div></div>`;
          })
          .join('')}
        <button id="submit-btn" type="submit">${buttonText}</button>
      </form>
    </article>`;
}

function bindForm({ onSubmit, onSuccess }) {
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
      if (typeof onSuccess === 'function') {
        onSuccess(response);
      }
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
        flashMessage = { type: 'error', text: mapGatewayError(error, 'Request failed.') };
      }
    } finally {
      button.disabled = false;
      render();
    }
  });
}

function requireGatewaySession() {
  const caps = keyCapabilities();
  if (caps.isKeySession) {
    return true;
  }

  viewRoot.innerHTML = `<article class="panel"><h2>Gateway key login required</h2><p>Use Key Login to access gateway flows.</p><p><a href="/ui/key-login" data-path="/key-login">Go to key login</a></p></article>`;
  bindInternalLinks(viewRoot);

  return false;
}

function requireOwnerSession() {
  const session = readSession();
  const hasOwnerSession = session.activeSurface === 'owner' && Boolean(session.owner?.accessToken);
  if (hasOwnerSession) {
    return true;
  }

  viewRoot.innerHTML = `<article class="panel"><h2>Owner login required</h2><p>Use Owner Login to access console flows.</p><p><a href="/ui/login" data-path="/login">Go to owner login</a></p></article>`;
  bindInternalLinks(viewRoot);

  return false;
}

function renderForbiddenGuard(title, body) {
  viewRoot.innerHTML = `<article class="panel"><h2>${title}</h2><p class="error-text">${body}</p><p><a href="/ui/feed" data-path="/feed">Return to feed</a></p></article>`;
  bindInternalLinks(viewRoot);
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

async function ownerRequest(path, options = {}) {
  try {
    return await apiRequest(path, { ...options, authSurface: 'owner' });
  } catch (error) {
    if (error.status === 401) {
      clearSession();
      flashMessage = { type: 'error', text: 'Session expired for console surface. Please sign in again.' };
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
      ${canCreatePost() ? '<p><a href="/ui/posts/new" data-path="/posts/new">Create a new post</a></p>' : '<p class="muted-text">Current key cannot create posts.</p>'}
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

  bindInternalLinks(viewRoot);

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
  const commentBlockedStates = ['locked', 'archived', 'hidden', 'deleted'];
  const commentStateBlocked = commentBlockedStates.includes(post.state);

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
        <a href="/ui/posts/${encodeURIComponent(postId)}/flag" data-path="/posts/${encodeURIComponent(postId)}/flag">Flag post</a>
        ${canEditPost() ? `<a href="/ui/posts/${encodeURIComponent(postId)}/edit" data-path="/posts/${encodeURIComponent(postId)}/edit">Edit post</a>` : '<span class="muted-text">Edit unavailable (posts:edit required)</span>'}
        ${canCreateComment(post) ? `<a href="/ui/posts/${encodeURIComponent(postId)}/comments/new" data-path="/posts/${encodeURIComponent(postId)}/comments/new">Add comment</a>` : `<span class="muted-text">Comment create unavailable${commentStateBlocked ? ' (post state blocked)' : ''}</span>`}
      </div>
    </article>`;

  bindInternalLinks(viewRoot);
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
        ${canCreateComment(postState.postId === postId ? postState.item : null) ? `<a href="/ui/posts/${encodeURIComponent(postId)}/comments/new" data-path="/posts/${encodeURIComponent(postId)}/comments/new">Add comment</a>` : '<span class="muted-text">Comment create unavailable</span>'}
      </div>
    </article>`;

  bindInternalLinks(viewRoot);
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

function postCreateView() {
  if (!requireGatewaySession()) {
    return;
  }
  if (!canCreatePost()) {
    renderForbiddenGuard('Create post unavailable', 'This key cannot create posts. Required: posts:create and non-use key class.');
    return;
  }

  viewRoot.innerHTML = formTemplate({
    title: 'Create post',
    buttonText: 'Publish post',
    helper: 'Create a new gateway post with visibility and state controls.',
    fields: [
      { name: 'title', label: 'Title', required: true },
      { name: 'body', label: 'Body', multiline: true, required: true },
      {
        name: 'visibility_scope',
        label: 'Visibility scope',
        options: [
          { value: 'delegated', label: 'delegated' },
          { value: 'public', label: 'public' },
          { value: 'private', label: 'private' },
        ],
        value: 'delegated',
      },
      {
        name: 'state',
        label: 'State',
        options: [
          { value: 'published', label: 'published' },
          { value: 'draft', label: 'draft' },
        ],
        value: 'published',
        required: false,
      },
    ],
  });

  bindForm({
    onSubmit: (body) => gatewayRequest('/api/posts', { method: 'POST', body }),
    onSuccess: (response) => {
      const createdId = response.data?.id;
      if (createdId) {
        flashMessage = { type: 'success', text: `Post created (${createdId}). Redirected to post detail.` };
        navigate(`/posts/${encodeURIComponent(createdId)}`);
      }
    },
  });
}

async function postEditView({ postId }) {
  if (!requireGatewaySession()) {
    return;
  }
  if (!canEditPost()) {
    renderForbiddenGuard('Edit unavailable', 'This key lacks posts:edit permission.');
    return;
  }

  viewRoot.innerHTML = '<article class="panel"><h2>Edit post</h2><p>Loading post editor…</p></article>';

  try {
    const response = await gatewayRequest(`/api/posts/${encodeURIComponent(postId)}`);
    lastResponse = response;
    const post = response.data ?? {};
    viewRoot.innerHTML = formTemplate({
      title: `Edit post ${escapeHtml(postId)}`,
      buttonText: 'Save changes',
      fields: [
        { name: 'title', label: 'Title', required: true, value: post.title ?? '' },
        { name: 'body', label: 'Body', multiline: true, required: true, value: post.body ?? '' },
        { name: 'change_reason_code', label: 'Change reason code', required: false, value: 'manual_edit' },
      ],
    });

    bindForm({
      onSubmit: (body) => gatewayRequest(`/api/posts/${encodeURIComponent(postId)}`, { method: 'PATCH', body }),
      onSuccess: () => {
        flashMessage = { type: 'success', text: `Post ${postId} updated.` };
        navigate(`/posts/${encodeURIComponent(postId)}`);
      },
    });
  } catch (error) {
    lastResponse = error;
    viewRoot.innerHTML = `<article class="panel"><h2>Edit post</h2><p class="error-text">${mapGatewayError(error, 'Unable to load post for editing.')}</p><p><a href="/ui/posts/${encodeURIComponent(postId)}" data-path="/posts/${encodeURIComponent(postId)}">Back to post</a></p></article>`;
    bindInternalLinks(viewRoot);
  }
}

function postFlagView({ postId }) {
  if (!requireGatewaySession()) {
    return;
  }

  viewRoot.innerHTML = formTemplate({
    title: `Flag post ${escapeHtml(postId)}`,
    buttonText: 'Submit flag',
    helper: 'Provide a short reason code for the flag report (for example: spam, abuse, policy).',
    fields: [
      { name: 'reason_code', label: 'Reason code', required: true, placeholder: 'spam' },
    ],
  });

  bindForm({
    onSubmit: (body) => gatewayRequest(`/api/posts/${encodeURIComponent(postId)}/flags`, { method: 'POST', body }),
    onSuccess: () => {
      flashMessage = { type: 'success', text: `Flag submitted for post ${postId}.` };
      navigate(`/posts/${encodeURIComponent(postId)}`);
    },
  });
}

async function commentCreateView({ postId }) {
  if (!requireGatewaySession()) {
    return;
  }

  viewRoot.innerHTML = '<article class="panel"><h2>Create comment</h2><p>Checking comment permissions…</p></article>';

  try {
    const postResponse = await gatewayRequest(`/api/posts/${encodeURIComponent(postId)}`);
    lastResponse = postResponse;
    const post = postResponse.data;

    if (!canCreateComment(post)) {
      renderForbiddenGuard('Comment create unavailable', 'This key cannot create comments for this post (permission, comments toggle, or post state restriction).');
      return;
    }

    viewRoot.innerHTML = formTemplate({
      title: `Add comment to ${escapeHtml(postId)}`,
      buttonText: 'Post comment',
      fields: [
        { name: 'body', label: 'Comment body', multiline: true, required: true },
      ],
    });

    bindForm({
      onSubmit: (body) => gatewayRequest(`/api/posts/${encodeURIComponent(postId)}/comments`, { method: 'POST', body }),
      onSuccess: () => {
        flashMessage = { type: 'success', text: `Comment created on post ${postId}.` };
        navigate(`/posts/${encodeURIComponent(postId)}/comments`);
      },
    });
  } catch (error) {
    lastResponse = error;
    viewRoot.innerHTML = `<article class="panel"><h2>Create comment</h2><p class="error-text">${mapGatewayError(error, 'Unable to prepare comment creation.')}</p><p><a href="/ui/posts/${encodeURIComponent(postId)}" data-path="/posts/${encodeURIComponent(postId)}">Back to post</a></p></article>`;
    bindInternalLinks(viewRoot);
  }
}

function consolePostsView() {
  if (!requireOwnerSession()) {
    return;
  }

  if (consolePostsState.status === 'idle') {
    fetchConsolePosts();
  }

  if (consolePostsState.status === 'loading') {
    viewRoot.innerHTML = '<article class="panel"><h2>Console posts</h2><p>Loading posts…</p></article>';
    return;
  }

  if (consolePostsState.status === 'error') {
    viewRoot.innerHTML = `<article class="panel"><h2>Console posts</h2><p class="error-text">${consolePostsState.error?.message ?? 'Failed to load console posts.'}</p><button id="retry-console-posts" type="button">Retry</button></article>`;
    document.getElementById('retry-console-posts').addEventListener('click', () => fetchConsolePosts());
    return;
  }

  const hasItems = consolePostsState.items.length > 0;
  viewRoot.innerHTML = `<article class="panel">
      <h2>Console posts</h2>
      <p class="muted-text">Owner-scoped content with direct links to post and comment moderation.</p>
      <p><a href="/ui/console/posts/new" data-path="/console/posts/new">Create console post</a></p>
      ${hasItems
        ? `<ul class="list">${consolePostsState.items.map((post) => {
          const safePostId = encodeURIComponent(post.id ?? '');

          return `<li>
              <strong>${escapeHtml(post.title ?? '(untitled)')}</strong><br />
              <small>${escapeHtml(post.id ?? '')} · state: ${escapeHtml(post.state ?? 'n/a')} · visibility: ${escapeHtml(post.visibility_scope ?? 'n/a')}</small>
              <div class="row-actions">
                <a href="/ui/console/posts/${safePostId}/moderation" data-path="/console/posts/${safePostId}/moderation">Moderate post</a>
                <a href="/ui/posts/${safePostId}" data-path="/posts/${safePostId}">Open gateway detail</a>
              </div>
              <form class="inline-form" data-comment-nav-for="${escapeHtml(post.id ?? '')}">
                <label for="comment-id-${safePostId}">Moderate comment by ID</label>
                <input id="comment-id-${safePostId}" name="comment_id" type="text" placeholder="comment-id" />
                <button type="submit">Go</button>
              </form>
            </li>`;
        }).join('')}</ul>`
        : '<p>No console posts found yet.</p>'}
    </article>`;

  bindInternalLinks(viewRoot);
  viewRoot.querySelectorAll('form[data-comment-nav-for]').forEach((form) => {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const postId = form.getAttribute('data-comment-nav-for');
      const data = new FormData(form);
      const commentId = String(data.get('comment_id') ?? '').trim();
      if (!commentId) {
        flashMessage = { type: 'error', text: `Enter a comment ID for post ${postId}.` };
        render();
        return;
      }

      navigate(`/console/posts/${encodeURIComponent(postId)}/comments/${encodeURIComponent(commentId)}/moderation`);
    });
  });
}

async function fetchConsolePosts() {
  consolePostsState.status = 'loading';
  consolePostsState.error = null;
  render();

  try {
    const response = await ownerRequest('/console/api/posts');
    lastResponse = response;
    consolePostsState.items = Array.isArray(response.data) ? response.data : [];
    consolePostsState.status = 'success';
  } catch (error) {
    lastResponse = error;
    consolePostsState.error = error;
    consolePostsState.status = 'error';
  }

  render();
}

function consolePostCreateView() {
  if (!requireOwnerSession()) {
    return;
  }

  viewRoot.innerHTML = formTemplate({
    title: 'Create console post',
    buttonText: 'Create post',
    helper: 'Owner-authenticated post creation for internal moderation workflows.',
    fields: [
      { name: 'title', label: 'Title', required: true },
      { name: 'body', label: 'Body', multiline: true, required: true },
      {
        name: 'visibility_scope',
        label: 'Visibility scope',
        options: [
          { value: 'private', label: 'private' },
          { value: 'delegated', label: 'delegated' },
          { value: 'public', label: 'public' },
        ],
        value: 'private',
      },
      {
        name: 'state',
        label: 'State',
        options: [
          { value: 'published', label: 'published' },
          { value: 'draft', label: 'draft' },
        ],
        value: 'published',
        required: false,
      },
    ],
  });

  bindForm({
    onSubmit: (body) => ownerRequest('/console/api/posts', { method: 'POST', body }),
    onSuccess: (response) => {
      const createdId = response.data?.id;
      flashMessage = {
        type: 'success',
        text: createdId ? `Console post created (${createdId}).` : 'Console post created.',
      };
      consolePostsState.status = 'idle';
      navigate('/console/posts');
    },
  });
}

function moderationSummary({ subject, action, reasonCode }) {
  return `<div class="summary-box">
    <strong>Action summary</strong>
    <p>You are about to <strong>${escapeHtml(action || '(select action)')}</strong> ${escapeHtml(subject)}.</p>
    <p>Reason code: <strong>${escapeHtml(reasonCode || 'none')}</strong></p>
  </div>`;
}

function bindModerationConfirmation({ formId, actionFieldName, reasonFieldName, onConfirm }) {
  const form = document.getElementById(formId);
  const confirmToggle = form.querySelector('[name="confirm_action"]');
  const actionControl = form.querySelector(`[name="${actionFieldName}"]`);
  const reasonControl = form.querySelector(`[name="${reasonFieldName}"]`);
  const summarySlot = form.querySelector('[data-summary-slot]');
  const submitButton = form.querySelector('button[type="submit"]');

  const syncSummary = () => {
    summarySlot.innerHTML = moderationSummary({
      subject: form.dataset.subjectLabel ?? 'resource',
      action: actionControl.value,
      reasonCode: reasonControl.value.trim(),
    });
  };

  syncSummary();
  actionControl.addEventListener('change', syncSummary);
  reasonControl.addEventListener('input', syncSummary);

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    flashMessage = null;
    if (!confirmToggle.checked) {
      flashMessage = { type: 'error', text: 'Please confirm the moderation action before submitting.' };
      render();
      return;
    }

    submitButton.disabled = true;
    const payload = {
      action: actionControl.value,
      reason_code: reasonControl.value.trim() || undefined,
    };

    try {
      const response = await onConfirm(payload);
      lastResponse = response;
      const resultState = response.data?.state ?? response.data?.status ?? 'updated';
      flashMessage = {
        type: 'success',
        text: `Moderation completed: ${payload.action} applied (${resultState}).`,
      };
    } catch (error) {
      lastResponse = error;
      if (error.status === 422) {
        flashMessage = { type: 'error', text: 'Moderation request is invalid. Check action/reason and retry.' };
      } else if (error.status === 404) {
        flashMessage = { type: 'error', text: 'Target resource not found for moderation.' };
      } else {
        flashMessage = { type: 'error', text: error.message ?? 'Moderation request failed.' };
      }
    } finally {
      submitButton.disabled = false;
      render();
    }
  });
}

function consolePostModerationView({ postId }) {
  if (!requireOwnerSession()) {
    return;
  }

  viewRoot.innerHTML = `<article class="panel">
    <h2>Moderate post</h2>
    <p class="muted-text">Post ID: <code>${escapeHtml(postId)}</code></p>
    <p><a href="/ui/console/posts" data-path="/console/posts">Back to console posts</a></p>
    <form id="post-moderation-form" data-subject-label="post ${escapeHtml(postId)}" novalidate>
      <div class="field">
        <label for="post-action">Action</label>
        <select id="post-action" name="action" required>
          ${['hide', 'lock', 'archive', 'delete'].map((value) => `<option value="${value}">${value}</option>`).join('')}
        </select>
      </div>
      <div class="field">
        <label for="post-reason">Reason code (optional)</label>
        <input id="post-reason" name="reason_code" type="text" placeholder="policy_violation" />
      </div>
      <div data-summary-slot></div>
      <label class="confirm-check"><input type="checkbox" name="confirm_action" /> I confirm this moderation action.</label>
      <div class="row-actions">
        <button type="submit">Submit moderation</button>
      </div>
    </form>
  </article>`;

  bindInternalLinks(viewRoot);
  bindModerationConfirmation({
    formId: 'post-moderation-form',
    actionFieldName: 'action',
    reasonFieldName: 'reason_code',
    onConfirm: (payload) => ownerRequest(`/console/api/posts/${encodeURIComponent(postId)}/moderation`, { method: 'POST', body: payload }),
  });
}

function consoleCommentModerationView({ postId, commentId }) {
  if (!requireOwnerSession()) {
    return;
  }

  viewRoot.innerHTML = `<article class="panel">
    <h2>Moderate comment</h2>
    <p class="muted-text">Post: <code>${escapeHtml(postId)}</code> · Comment: <code>${escapeHtml(commentId)}</code></p>
    <p><a href="/ui/console/posts/${encodeURIComponent(postId)}/moderation" data-path="/console/posts/${encodeURIComponent(postId)}/moderation">Back to post moderation</a> · <a href="/ui/console/posts" data-path="/console/posts">Console posts</a></p>
    <form id="comment-moderation-form" data-subject-label="comment ${escapeHtml(commentId)} on post ${escapeHtml(postId)}" novalidate>
      <div class="field">
        <label for="comment-action">Action</label>
        <select id="comment-action" name="action" required>
          ${['hide', 'lock', 'delete'].map((value) => `<option value="${value}">${value}</option>`).join('')}
        </select>
      </div>
      <div class="field">
        <label for="comment-reason">Reason code (optional)</label>
        <input id="comment-reason" name="reason_code" type="text" placeholder="abuse" />
      </div>
      <div data-summary-slot></div>
      <label class="confirm-check"><input type="checkbox" name="confirm_action" /> I confirm this moderation action.</label>
      <div class="row-actions">
        <button type="submit">Submit comment moderation</button>
      </div>
    </form>
  </article>`;

  bindInternalLinks(viewRoot);
  bindModerationConfirmation({
    formId: 'comment-moderation-form',
    actionFieldName: 'action',
    reasonFieldName: 'reason_code',
    onConfirm: (payload) => ownerRequest(`/console/api/posts/${encodeURIComponent(postId)}/comments/${encodeURIComponent(commentId)}/moderation`, { method: 'POST', body: payload }),
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
