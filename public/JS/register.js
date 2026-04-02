
  /* ── STATUS TOGGLE ── */
  function updateStatus() {
    const active   = document.querySelector('input[name="status"][value="active"]').checked;
    document.getElementById('lbl-active').classList.toggle('checked', active);
    document.getElementById('lbl-inactive').classList.toggle('checked', !active);
  }

  /* ── EYE TOGGLE ── */
  function makeEyeToggle(btnId, inputId, iconId) {
    document.getElementById(btnId).addEventListener('click', () => {
      const input = document.getElementById(inputId);
      const isText = input.type === 'text';
      input.type = isText ? 'password' : 'text';
      document.getElementById(iconId).innerHTML = isText
        ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`
        : `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    });
  }
  makeEyeToggle('togglePwd',     'password',        'eyeIcon');
  makeEyeToggle('toggleConfirm', 'confirmPassword', 'eyeIconConfirm');

  /* ── STRENGTH ── */
  const pwdInput = document.getElementById('password');
  const segs     = [1,2,3,4].map(i => document.getElementById('seg'+i));
  const strengthText = document.getElementById('strengthText');
  const colors = ['#f87171','#fb923c','#facc15','#4ade80'];
  const labels = ['Weak','Fair','Good','Strong'];

  pwdInput.addEventListener('input', () => {
    const v = pwdInput.value;
    let score = 0;
    if (v.length >= 8) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    segs.forEach((s, i) => {
      s.style.background = i < score ? colors[score-1] : 'var(--slate-200)';
    });
    strengthText.textContent = v.length ? labels[score-1] || '' : '';
    strengthText.style.color = v.length ? colors[score-1] : 'var(--slate-400)';
  });

  /* ── VALIDATION ── */
  function setFieldState(id, state, msg) {
    const f = document.getElementById('field-' + id);
    f.classList.toggle('error',   state === 'error');
    f.classList.toggle('success', state === 'success');
    if (msg) {
      const errEl = f.querySelector('.field-error');
      if (errEl) errEl.lastChild.textContent = ' ' + msg;
    }
  }

  function validateField(id) {
    const f = document.getElementById('field-' + id);
    if (!f) return true;
    const input = f.querySelector('input, select');
    const v = input ? input.value.trim() : '';
    if (!v) { setFieldState(id, 'error'); return false; }
    if (id === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
      setFieldState(id, 'error', 'Enter a valid email address.');
      return false;
    }
    if (id === 'password' && v.length < 8) {
      setFieldState(id, 'error', 'Password must be at least 8 characters.');
      return false;
    }
    if (id === 'confirm') {
      const pwd = document.getElementById('password').value;
      if (v !== pwd) { setFieldState(id, 'error', 'Passwords do not match.'); return false; }
    }
    setFieldState(id, 'success');
    return true;
  }

  // Live validation on blur
  ['name','email','phone','password','confirm','language'].forEach(id => {
    const f = document.getElementById('field-' + id);
    if (!f) return;
    const el = f.querySelector('input, select');
    if (el) el.addEventListener('blur', () => validateField(id));
  });

  /* ── RIPPLE ── */
  document.getElementById('submitBtn').addEventListener('click', function(e) {
    const btn  = this;
    const rect = btn.getBoundingClientRect();
    const r    = document.createElement('span');
    const size = Math.max(rect.width, rect.height) * 1.4;
    r.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
    r.classList.add('ripple');
    btn.appendChild(r);
    setTimeout(() => r.remove(), 600);
  });
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const fields = ['name','email','phone','password','confirm','language'];
    const valid  = fields.map(validateField).every(Boolean);

    if (!valid) {
        e.preventDefault(); // فقط إذا فيه خطأ
        return;
    }
});
