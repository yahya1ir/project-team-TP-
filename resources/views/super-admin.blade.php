@extends('layouts.app')

@section('title', 'Super Admin Panel')

@section('content')
    <div class="page-header">
        <div>
            <div class="eyebrow">System</div>
            <h1>Super Admin Panel</h1>
            <p class="subtitle">Global controls only available to Super Admin.</p>
        </div>
        <div class="date-info">
            {{ now()->format('l') }}
            <strong>{{ now()->format('F d, Y') }}</strong>
        </div>
    </div>

    <div class="card" style="margin-bottom:1rem;">
        <div class="card-header">
            <div>
                <div class="card-title">Access Level</div>
                <div class="card-subtitle">You are authenticated as Super Admin</div>
            </div>
        </div>
        <div class="card-body">
            <p style="color:var(--text2); line-height:1.7;">
                This area is reserved for the highest privilege account.
                Use it for sensitive system tasks, role governance, and advanced operations.
            </p>
        </div>
    </div>

    <div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
        <a href="{{ route('users.index') }}" class="card" style="text-decoration:none; color:inherit;">
            <div class="card-body">
                <div class="card-title">Users Management</div>
                <p style="color:var(--text3); margin-top:.35rem;">Review user access and account status.</p>
            </div>
        </a>
        <a href="{{ route('dashboard') }}" class="card" style="text-decoration:none; color:inherit;">
            <div class="card-body">
                <div class="card-title">Platform Dashboard</div>
                <p style="color:var(--text3); margin-top:.35rem;">View global metrics and health.</p>
            </div>
        </a>
        <a href="{{ route('formation') }}" class="card" style="text-decoration:none; color:inherit;">
            <div class="card-body">
                <div class="card-title">Formations</div>
                <p style="color:var(--text3); margin-top:.35rem;">Oversee all formation content.</p>
            </div>
        </a>
    </div>
@endsection
