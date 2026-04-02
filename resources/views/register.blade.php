<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ __('messages.auth.register') }} TP</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ url('CSS/register.css') }}">
 
</head>
<body>


<div class="toast" id="toast">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
  </svg>

</div>

<div class="page">
  <div class="card">


    <div class="brand">
      <div class="brand-icon">
        
      </div>
      <span class="brand-name">Plateforme bilingue</span>
    </div>

    <h1 class="card-title">{{ __('messages.auth.createYourAccount') }}</h1>
    <p class="card-sub">{{ __('messages.auth.fillDetails') }}</p>

    <div class="divider"></div>

    <form id="registerForm" method="POST" action="{{ route('register.post') }}">
       @csrf
      <div class="form-grid">

     
        <div class="field span-2" id="field-name">
          <label for="fullName">{{ __('messages.auth.fullName') }}</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <input type="text" id="fullName" name="name" placeholder="irfane yahya" autocomplete="name"/>
          </div>
          <span class="field-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ __('messages.auth.fullNameRequired') }}
          </span>
        </div>

        <!-- EMAIL -->
        <div class="field span-2" id="field-email">
          <label for="email">{{ __('messages.auth.email') }}</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
            </svg>
            <input type="email" id="email" name="email" placeholder="jane@example.com" autocomplete="email"/>
          </div>
          <span class="field-error" id="email-err">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ __('messages.auth.enterValidEmail') }}
          </span>
        </div>

        <!-- PHONE -->
        <div class="field span-2" id="field-phone">
          <label for="phone">{{ __('messages.auth.phoneNumber') }}</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.65 3.41 2 2 0 0 1 3.62 1.24h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.83a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.98 16.92z"/>
            </svg>
            <input type="text" id="phone" name="phone" placeholder="+1 (555) 000-0000" autocomplete="tel"/>
          </div>
          <span class="field-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ __('messages.auth.phoneRequired') }}
          </span>
        </div>
        <!-- PASSWORD -->
        <div class="field span-2" id="field-password">
          <label for="password">{{ __('messages.auth.password') }}</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input type="password" id="password" name="password" placeholder="Min 8 characters"/>
            <button type="button" class="eye-btn" id="togglePwd" aria-label="Toggle password">
              <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          <!-- Strength bar -->
          <div class="strength-bar" id="strengthBar">
            <div class="strength-seg" id="seg1"></div>
            <div class="strength-seg" id="seg2"></div>
            <div class="strength-seg" id="seg3"></div>
            <div class="strength-seg" id="seg4"></div>
          </div>
          <span class="strength-text" id="strengthText"></span>
          <span class="field-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ __('messages.auth.passwordMin') }}
          </span>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="field span-2" id="field-confirm">
          <label for="confirmPassword">{{ __('messages.auth.passwordConfirm') }}</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Repeat password"/>
            <button type="button" class="eye-btn" id="toggleConfirm" aria-label="Toggle confirm password">
              <svg id="eyeIconConfirm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          <span class="field-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ __('messages.auth.passwordsDoNotMatch') }}
          </span>
        </div>

        <!-- LANGUAGE -->
        <div class="field" id="field-language">
          <label for="language">{{ __('messages.auth.language') }}</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            <select id="language" name="language">
              <option value="">{{ __('messages.auth.selectOption') }}</option>
              <option value="fr">🇫🇷 French</option>
              <option value="en">🇬🇧 English</option>
            </select>
            <span class="select-arrow">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
            </span>
          </div>
          <span class="field-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ __('messages.auth.selectLanguage') }}
          </span>
        </div>

        <!-- STATUS -->
        <div class="field" id="field-status">
          <label>{{ __('messages.auth.status') }}</label>
          <div class="status-row">
            <label class="toggle-label checked" id="lbl-active">
              <input type="radio" name="status" value="active" checked onchange="updateStatus()"/>
              <span class="toggle-dot"></span>
              <span class="toggle-text">{{ __('messages.auth.active') }}</span>
            </label>
            <label class="toggle-label" id="lbl-inactive">
              <input type="radio" name="status" value="inactive" onchange="updateStatus()"/>
              <span class="toggle-dot"></span>
              <span class="toggle-text">{{ __('messages.auth.inactive') }}</span>
            </label>
          </div>
        </div>

        <!-- SUBMIT -->
        <div class="field span-2">
          <button type="submit" class="btn-submit" id="submitBtn">
            <span>{{ __('messages.auth.createAccount') }} -></span>
          </button>
        </div>

      </div><!-- /form-grid -->
    </form>

    <p class="form-footer">{{ __('messages.auth.haveAccount') }} <a href="{{ route('login') }}">{{ __('messages.auth.login') }}</a></p>

  </div>
</div>


<script src="{{ url('js/register.js') }}"></script>
</body>
</html>