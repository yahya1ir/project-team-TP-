<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ __('messages.auth.login') }} - TP</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ url('CSS/login.css') }}">
 
</head>
<body>

<!-- TOAST -->
<div class="toast" id="toast">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
  </svg>
  {{ __('messages.auth.welcomeBackRedirecting') }}
</div>

<div class="page">
  <div class="card">

    <!-- BRAND -->
    

    <div class="welcome-badge"><span></span> {{ __('messages.auth.welcomeBack') }}</div>

    <h1 class="card-title">{{ __('messages.auth.signInToYourAccount') }}</h1>
    <p class="card-sub">{{ __('messages.auth.enterCredentials') }}</p>

    <div class="divider"></div>

 <form id="registerForm" method="POST" action="{{ route('login.post') }}">
       @csrf

      <!-- EMAIL -->
      <div class="field" id="field-email">
        <label for="email">{{ __('messages.auth.email') }}</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
          </svg>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="jane@example.com" autocomplete="email"/>
        </div>
        @error('email')
        <span class="field-error">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          {{ $message }}
        </span>
        @enderror
      </div>

      <!-- PASSWORD -->
      <div class="field" id="field-password">
        <div class="label-row">
          <label for="password">{{ __('messages.auth.password') }}</label>
          <a href="#" class="forgot-link">{{ __('messages.auth.forgotPassword') }}</a>
        </div>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password" id="password" name="password" placeholder="Your password" autocomplete="current-password"/>
          <button type="button" class="eye-btn" id="togglePwd" aria-label="Toggle password visibility">
            <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
        @error('password')
        <span class="field-error">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          {{ $message }}
        </span>
        @enderror
      </div>

      <!-- REMEMBER ME -->
      <div class="remember-row">
        <label class="checkbox-wrap">
          <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
          <div class="checkbox-box">
            <svg width="10" height="10" viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="2 6 5 9 10 3"/>
            </svg>
          </div>
        </label>
        <label class="remember-label" for="remember">{{ __('messages.auth.rememberMe') }}</label>
      </div>

      <!-- SUBMIT -->
      <button type="submit" class="btn-submit" id="submitBtn">
        <span>
          <span class="spinner" id="spinner"></span>
          <span id="btnText">{{ __('messages.auth.login') }}</span>
          <span class="arrow" id="btnArrow">→</span>
        </span>
      </button>

      <!-- OR -->
      <div class="or-divider">
        <span class="or-text">{{ __('messages.auth.orContinueWith') }}</span>
      </div>

      <!-- SSO -->
    

    </form>

    <p class="form-footer">{{ __('messages.auth.noAccount') }} <a href="{{ route('register') }}">{{ __('messages.auth.createOne') }}</a></p>

  </div>
</div>

<script src="{{ url('js/login.js') }}"></script>
</body>
</html>