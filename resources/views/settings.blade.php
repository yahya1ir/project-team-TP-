<h1>hello </h1>
{{-- resources/views/settings.blade.php --}}
@extends('layouts.app')

@section('title', __('messages.nav.settings'))

@push('styles')

@endpush

@section('content')

{{-- PAGE HEADER --}}
<link rel="stylesheet" href="{{ url('CSS/settings.css') }}">
<div class="page-header">
    <div>
        <div class="eyebrow">Account</div>
        <h1>{{ __('messages.nav.settings') }}</h1>
        <div class="subtitle">Manage your profile, security and preferences</div>
    </div>
    <div class="date-info">
        <span>Member since</span>
        <strong>{{ Auth::user()->created_at->format('M Y') }}</strong>
    </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div class="toast" id="toast">
    <div class="toast-ico success" id="toastIco">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
    </div>
    <div>
        <div style="font-weight:600;color:var(--text)" id="toastTitle">Saved successfully</div>
        <div id="toastMsg" style="font-size:.75rem;margin-top:.1rem;">Your changes have been applied.</div>
    </div>
</div>

<div class="settings-layout">

    {{-- SETTINGS NAV --}}
    <nav class="settings-nav">
        <div class="settings-nav-header">Settings</div>
        <a class="settings-nav-link active" onclick="switchTab('profile')" href="#">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Profile Info
        </a>
        <a class="settings-nav-link" onclick="switchTab('security')" href="#">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Security
        </a>
       
    </nav>

    {{-- SETTINGS PANELS --}}
    <div>

        {{-- ======================================
             PANEL 1 — PROFILE INFO
        ====================================== --}}
        <div class="settings-panel active" id="panel-profile">

            {{-- Profile Banner --}}
            <div class="profile-banner">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'JD', 0, 2)) }}
                    </div>
                    <div class="profile-avatar-edit" title="Change avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </div>
                </div>
                <div class="profile-info">
                    <h2>{{ Auth::user()->name }}</h2>
                    <div class="role-badge">
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        {{ Auth::user()->role ?? 'User' }}
                    </div>
                    <div class="join-date">{{ Auth::user()->email }}</div>
                </div>
            </div>

            {{-- Quick Info Tiles --}}
            <div class="info-tiles">
                <div class="info-tile">
                    <div class="info-tile-label">Account ID</div>
                    <div class="info-tile-value">#{{ Auth::user()->id }}</div>
                </div>
                <div class="info-tile">
                    <div class="info-tile-label">Status</div>
                    <div class="info-tile-value" style="color:var(--green)">{{ strtoupper(Auth::user()->status) }}</div>
                </div>
                <div class="info-tile">
                    <div class="info-tile-label">Last Login</div>
                    <div class="info-tile-value">{{ Auth::user()->updated_at->diffForHumans() }}</div>
                </div>
            </div>

            {{-- Profile Form --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Personal Information</div>
                        <div class="card-subtitle">Update your name, email and contact details</div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="profileForm" method="POST" action="#">
                    

                        <div class="section-divider">
                            <span class="section-divider-title">Identity</span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name"
                                       value="{{ old('name', Auth::user()->name) }}"
                                       placeholder="Your full name" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email', Auth::user()->email) }}"
                                       placeholder="you@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="section-divider" style="margin-top:.5rem">
                            <span class="section-divider-title">Contact</span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="phone">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone"
                                       value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                       placeholder="+1 (555) 000-0000">
                                <div class="form-hint">Optional — used for account recovery</div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="role_display">Role</label>
                                <input type="text" class="form-control"
                                       id="role_display"
                                       value="{{ Auth::user()->role ?? 'User' }}"
                                       disabled
                                       style="opacity:.5;cursor:not-allowed;">
                                <div class="form-hint">Role is managed by administrators</div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- ======================================
             PANEL 2 — SECURITY / PASSWORD
        ====================================== --}}
        <div class="settings-panel" id="panel-security">

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Change Password</div>
                        <div class="card-subtitle">You must confirm your current password before setting a new one</div>
                    </div>
                    <div style="width:36px;height:36px;background:var(--purple-pale);border-radius:var(--r);display:flex;align-items:center;justify-content:center;color:var(--purple);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <form id="passwordForm" method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="section-divider">
                            <span class="section-divider-title">Verify Identity</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="current_password">Current Password</label>
                            <div class="input-wrap">
                                <input type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password"
                                       placeholder="Enter your current password" required>
                                <button type="button" class="input-reveal" onclick="toggleReveal('current_password', this)" tabindex="-1">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="section-divider" style="margin-top:.5rem">
                            <span class="section-divider-title">New Password</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">New Password</label>
                            <div class="input-wrap">
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       placeholder="Create a strong password"
                                       oninput="checkStrength(this.value)"
                                       required>
                                <button type="button" class="input-reveal" onclick="toggleReveal('password', this)" tabindex="-1">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror

                            {{-- Strength bar --}}
                            <div class="password-strength" id="strengthWrap" style="display:none">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <div class="strength-label" id="strengthLabel">Strength: —</div>
                            </div>

                            {{-- Requirements checklist --}}
                            <div class="password-reqs">
                                <div class="password-reqs-title">Requirements</div>
                                <div class="req-item" id="req-length">
                                    <span class="req-dot"></span> At least 8 characters
                                </div>
                                <div class="req-item" id="req-upper">
                                    <span class="req-dot"></span> One uppercase letter (A-Z)
                                </div>
                                <div class="req-item" id="req-lower">
                                    <span class="req-dot"></span> One lowercase letter (a-z)
                                </div>
                                <div class="req-item" id="req-number">
                                    <span class="req-dot"></span> One number (0-9)
                                </div>
                                <div class="req-item" id="req-special">
                                    <span class="req-dot"></span> One special character (!@#$…)
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Confirm New Password</label>
                            <div class="input-wrap">
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation" name="password_confirmation"
                                       placeholder="Re-enter your new password"
                                       oninput="checkMatch()"
                                       required>
                                <button type="button" class="input-reveal" onclick="toggleReveal('password_confirmation', this)" tabindex="-1">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="form-hint" id="matchHint"></div>
                        </div>

                        <div class="save-bar">
                            <button type="reset" class="btn" onclick="resetPasswordForm()">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="pwSubmitBtn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="15" height="15">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Security info card --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Active Session</div>
                        <div class="card-subtitle">Your current login session information</div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="display:flex;align-items:center;gap:1rem;padding:.75rem 1rem;background:var(--bg3);border-radius:var(--r);border:1px solid var(--border)">
                        <div style="width:40px;height:40px;background:var(--green-bg);border-radius:var(--r);display:flex;align-items:center;justify-content:center;color:var(--green);flex-shrink:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                <line x1="8" y1="21" x2="16" y2="21"/>
                                <line x1="12" y1="17" x2="12" y2="21"/>
                            </svg>
                        </div>
                        <div style="flex:1">
                            <div style="font-size:.83rem;font-weight:600;color:var(--text)">Current Device</div>
                            <div style="font-family:'IBM Plex Mono',monospace;font-size:.65rem;color:var(--text3);margin-top:.15rem" id="deviceInfo">
                                Loading session info…
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:.35rem;font-size:.72rem;color:var(--green)">
                            <span style="width:7px;height:7px;background:var(--green);border-radius:50%;display:inline-block;"></span>
                            Active now
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================================
             PANEL 3 — PREFERENCES
        ====================================== --}}
        

    </div><!-- end panels wrapper -->
</div><!-- end settings-layout -->






<style>
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
}
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: var(--border2);
    border-radius: 99px;
    transition: .3s;
}
.toggle-slider::before {
    content: '';
    position: absolute;
    height: 18px; width: 18px;
    left: 3px; bottom: 3px;
    background: var(--text3);
    border-radius: 50%;
    transition: .3s;
}
.toggle-switch input:checked + .toggle-slider { background: var(--purple); }
.toggle-switch input:checked + .toggle-slider::before {
    transform: translateX(20px);
    background: #fff;
}
</style>

@endsection

@push('scripts')
<script src="{{ url('js/settings.js') }}"></script>
<script>
    
@if(session('success'))
    document.addEventListener('DOMContentLoaded', () => {
        showToast('Saved successfully', '{{ session("success") }}', 'success');
    });
@endif


</script>
@endpush