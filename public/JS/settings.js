
// =============================================
// TAB SWITCHING
// =============================================
function switchTab(tab) {
    document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.settings-nav-link').forEach(l => l.classList.remove('active'));
    document.getElementById('panel-' + tab).classList.add('active');
    event.currentTarget.classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// =============================================
// PASSWORD REVEAL TOGGLE
// =============================================
function toggleReveal(inputId, btn) {
    const input = document.getElementById(inputId);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.innerHTML = isText
        ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
               <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
               <circle cx="12" cy="12" r="3"/>
           </svg>`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
               <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
               <line x1="1" y1="1" x2="23" y2="23"/>
           </svg>`;
}

// =============================================
// PASSWORD STRENGTH CHECKER
// =============================================
function checkStrength(val) {
    const wrap = document.getElementById('strengthWrap');
    const fill = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';

    let score = 0;
    const reqs = {
        length:  val.length >= 8,
        upper:   /[A-Z]/.test(val),
        lower:   /[a-z]/.test(val),
        number:  /[0-9]/.test(val),
        special: /[^A-Za-z0-9]/.test(val),
    };

    // Update requirement indicators
    Object.entries(reqs).forEach(([key, met]) => {
        const el = document.getElementById('req-' + key);
        if (el) el.classList.toggle('met', met);
        if (met) score++;
    });

    // Strength bar
    const pct = (score / 5) * 100;
    const colors = ['#f05252','#f0a432','#f0a432','#3ecf6e','#3ecf6e'];
    const labels = ['Very Weak','Weak','Fair','Strong','Very Strong'];
    fill.style.width = pct + '%';
    fill.style.background = colors[score - 1] || 'var(--border)';
    label.textContent = 'Strength: ' + (labels[score - 1] || '—');
    label.style.color = colors[score - 1] || 'var(--text3)';
}

// =============================================
// PASSWORD MATCH CHECKER
// =============================================
function checkMatch() {
    const pw = document.getElementById('password').value;
    const conf = document.getElementById('password_confirmation').value;
    const hint = document.getElementById('matchHint');
    const confInput = document.getElementById('password_confirmation');

    if (!conf) { hint.textContent = ''; return; }

    if (pw === conf) {
        hint.textContent = '✓ Passwords match';
        hint.style.color = 'var(--green)';
        confInput.classList.remove('is-invalid');
        confInput.classList.add('is-valid');
    } else {
        hint.textContent = '✗ Passwords do not match';
        hint.style.color = 'var(--red)';
        confInput.classList.remove('is-valid');
        confInput.classList.add('is-invalid');
    }
}

// =============================================
// RESET PASSWORD FORM
// =============================================
function resetPasswordForm() {
    document.getElementById('passwordForm').reset();
    document.getElementById('strengthWrap').style.display = 'none';
    document.getElementById('matchHint').textContent = '';
    document.querySelectorAll('.req-item').forEach(r => r.classList.remove('met'));
    ['password', 'password_confirmation', 'current_password'].forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.classList.remove('is-valid', 'is-invalid'); }
    });
}

// =============================================
// TOAST NOTIFICATION
// =============================================
function showToast(title, msg, type = 'success') {
    const toast = document.getElementById('toast');
    const toastIco = document.getElementById('toastIco');
    const toastTitle = document.getElementById('toastTitle');
    const toastMsg = document.getElementById('toastMsg');

    toastTitle.textContent = title;
    toastMsg.textContent = msg;
    toastIco.className = 'toast-ico ' + type;
    toastIco.innerHTML = type === 'success'
        ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`;

    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 4000);
}

// Auto-show toast if session messages exist




function switchTabDirect(tab) {
    document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.settings-nav-link').forEach(l => l.classList.remove('active'));
    document.getElementById('panel-' + tab).classList.add('active');
    const links = document.querySelectorAll('.settings-nav-link');
    const tabMap = { profile: 0, security: 1, preferences: 2 };
    links[tabMap[tab]]?.classList.add('active');
}

// Auto-switch to security tab if password errors


// =============================================
// SESSION/DEVICE INFO
// =============================================

});
