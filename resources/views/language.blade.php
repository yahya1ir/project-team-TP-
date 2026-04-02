{{-- Example usage of multilingual strings in Blade --}}

@extends('layouts.app')

@section('title', __('messages.dashboard.title'))

@section('content')
    <div class="page-header">
        <div>
            <div class="eyebrow">{{ __('messages.dashboard.overview') }}</div>
            <h1>{{ __('messages.dashboard.title') }}</h1>
            <p class="subtitle">
                {{ __('messages.dashboard.welcome', ['name' => Auth::user()->name ?? 'Guest']) }}
            </p>
        </div>
    </div>

    <!-- Example Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Translation Examples</div>
            <div class="card-subtitle">How to use the i18n system</div>
        </div>
        <div class="card-body">
            <h3>Basic Translation</h3>
            <p>{{ __('messages.nav.dashboard') }}</p>

            <h3>Translation with Parameters</h3>
            <p>{{ __('messages.dashboard.newThisMonth', ['count' => 48]) }}</p>

            <h3>Get Current Locale</h3>
            <p>Current Language: <strong>{{ app()->getLocale() }}</strong></p>

            <h3>Available Methods</h3>
            <ul style="list-style: disc; margin-left: 1.5rem;">
                <li><code>__('key')</code> - Translate with helper function</li>
                <li><code>trans('key')</code> - Translate with trans function</li>
                <li><code>app()->getLocale()</code> - Get current locale</li>
                <li><code>app()->setLocale('fr')</code> - Set locale</li>
                <li><code>session(['locale' => 'en'])</code> - Store locale in session</li>
            </ul>

            <h3>Language Switcher</h3>
            <p>
                <a href="{{ route('language', 'en') }}" class="btn btn-sm">English</a>
                <a href="{{ route('language', 'fr') }}" class="btn btn-sm">Français</a>
            </p>
        </div>
    </div>
@endsection
