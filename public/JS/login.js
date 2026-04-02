
  /* ── EYE TOGGLE ── */
  document.getElementById('togglePwd').addEventListener('click', () => {
    const input = document.getElementById('password');
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    document.getElementById('eyeIcon').innerHTML = isText
      ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`
      : `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
  });

  /* ── VALIDATION ── */
  function setFieldState(id, state) {
    const f = document.getElementById('field-' + id);
    f.classList.toggle('error',   state === 'error');
    f.classList.toggle('success', state === 'success');
  }

  function validateEmail() {
    const v = document.getElementById('email').value.trim();
    if (!v || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { setFieldState('email', 'error'); return false; }
    setFieldState('email', 'success'); return true;
  }

  function validatePassword() {
    const v = document.getElementById('password').value;
    if (!v) { setFieldState('password', 'error'); return false; }
    setFieldState('password', 'success'); return true;
  }

  document.getElementById('email').addEventListener('blur', validateEmail);
  document.getElementById('password').addEventListener('blur', validatePassword);

  /* ── RIPPLE ── */
  document.getElementById('submitBtn').addEventListener('click', function(e) {
    const rect = this.getBoundingClientRect();
    const r = document.createElement('span');
    const size = Math.max(rect.width, rect.height) * 1.4;
    r.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
    r.classList.add('ripple');
    this.appendChild(r);
    setTimeout(() => r.remove(), 600);
  });

  /* ── SUBMIT ── */
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const ok = validateEmail() & validatePassword();
    if (!ok) return;

    const btn     = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    const text    = document.getElementById('btnText');
    const arrow   = document.getElementById('btnArrow');

    btn.disabled = true;
    spinner.style.display = 'block';
    text.textContent = 'Signing in…';
    arrow.style.display = 'none';

    setTimeout(() => {
      btn.disabled = false;
      spinner.style.display = 'none';
      text.textContent = 'Sign In';
      arrow.style.display = 'inline';
      const toast = document.getElementById('toast');
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3500);
    }, 1400);
  });
