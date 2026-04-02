{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', __('messages.dashboard.title'))

@section('fab-actions')
    @can('manage users')
    <div class="fab-action" data-action="add-user" onclick="alert('Add user feature coming soon')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/>
            <line x1="22" y1="11" x2="16" y2="11"/>
        </svg>
    <span><a href="#" style="color: white; text-decoration: none;">{{ __('messages.dashboard.addUser') }}</a></span>
    </div>
    @endcan

    @can('manage formations')
    <div class="fab-action" data-action="new-formation" onclick="window.location.href='{{ route('formation') }}'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            <line x1="12" y1="10" x2="12" y2="16"/>
            <line x1="9" y1="13" x2="15" y2="13"/>
        </svg>
        <span>{{ __('messages.formations.newFormation') }}</span>
    </div>
    @endcan

    @can('manage sessions')
    <div class="fab-action" data-action="schedule" onclick="window.location.href='#'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
            <line x1="12" y1="14" x2="12" y2="18"/>
            <line x1="10" y1="16" x2="14" y2="16"/>
        </svg>
        <span>{{ __('messages.dashboard.scheduleSession') }}</span>
    </div>
    @endcan
@endsection

@section('content')
    <div class="page-header">
        <div>
            <div class="eyebrow">{{ __('messages.dashboard.overview') }}</div>
            <h1>{{ __('messages.dashboard.title') }}</h1>
            <p class="subtitle">{{ __('messages.dashboard.welcome', ['name' => Auth::user()->name ?? 'Jane']) }}</p>
        </div>
        <div class="date-info">
            {{ now()->format('l') }}
            <strong>{{ now()->format('F d, Y') }}</strong>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat">
            <div class="stat-top">
                <div class="stat-ico" style="background:var(--purple-pale);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--purple)">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <span class="chip-up">↑ 12%</span>
            </div>
            <div class="stat-num">{{ $totalUsers ?? '1,284' }}</div>
            <div class="stat-lbl">{{ __('messages.dashboard.totalUsers') }}</div>
            <div class="stat-desc">// {{ __('messages.dashboard.newThisMonth', ['count' => $newUsers ?? '48']) }}</div>
        </div>
        
        <div class="stat">
            <div class="stat-top">
                <div class="stat-ico" style="background:var(--cyan-bg);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--cyan)">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                </div>
                <span class="chip-up">↑ 5%</span>
            </div>
            <div class="stat-num">{{ $totalFormations ?? '342' }}</div>
            <div class="stat-lbl">{{ __('messages.dashboard.totalFormations') }}</div>
            <div class="stat-desc">// {{ __('messages.dashboard.addedThisQuarter', ['count' => $newFormations ?? '18']) }}</div>
        </div>
        
        <div class="stat">
            <div class="stat-top">
                <div class="stat-ico" style="background:var(--green-bg);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--green)">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <span class="chip-up">↑ 8%</span>
            </div>
            <div class="stat-num">{{ $activeSessions ?? '57' }}</div>
            <div class="stat-lbl">{{ __('messages.dashboard.activeSessions') }}</div>
            <div class="stat-desc">// {{ __('messages.dashboard.startingThisWeek', ['count' => $sessionsThisWeek ?? '12']) }}</div>
        </div>
        
        <div class="stat">
            <div class="stat-top">
                <div class="stat-ico" style="background:var(--red-bg);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--red)">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <span class="chip-down">↓ 2%</span>
            </div>
            <div class="stat-num">{{ $totalInscriptions ?? '4,821' }}</div>
            <div class="stat-lbl">{{ __('messages.dashboard.totalInscriptions') }}</div>
            <div class="stat-desc">// {{ __('messages.dashboard.pendingApproval', ['count' => $pendingInscriptions ?? '221']) }}</div>
        </div>
    </div>

    <!-- Recent Activity Card -->
    
@endsection

@section('scripts')
<script src="{{ url('js/dashboard.js') }}"></script>
@endsection