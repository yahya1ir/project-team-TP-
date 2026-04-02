{{-- resources/views/users.blade.php --}}
@extends('layouts.app')

@section('title', 'Users Management')

@section('fab-actions')
    @can('manage users')
    <div class="fab-action" data-action="add-user" onclick="alert('Add user feature coming soon')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/>
            <line x1="22" y1="11" x2="16" y2="11"/>
        </svg>
        <span>Add User</span>
    </div>
    @endcan

    @role('Super Admin')
    <div class="fab-action" data-action="super-admin" onclick="window.location.href='{{ route('super-admin.index') }}'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M12 3l2.8 5.67 6.26.91-4.53 4.42 1.07 6.25L12 17.27l-5.6 2.98 1.07-6.25L2.94 9.58l6.26-.91L12 3z"/>
        </svg>
        <span>Super Admin Panel</span>
    </div>
    @endrole
@endsection

@section('content')
    <div class="page-header">
        <div>
            <div class="eyebrow">Administration</div>
            <h1>Users Overview</h1>
            <p class="subtitle">Visible to Admin and Super Admin only.</p>
        </div>
        <div class="date-info">
            {{ now()->format('l') }}
            <strong>{{ now()->format('F d, Y') }}</strong>
        </div>
    </div>

    @if (session('success'))
        <div class="card" style="margin-top:1rem; border-color:rgba(62,207,110,.25); background:var(--green-bg); color:var(--green); padding:1rem 1.1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="margin-top:1rem;">
        <div class="card-header">
            <div>
                <div class="card-title">Assign Teacher Role</div>
                <div class="card-subtitle">Give an existing email access to create formations.</div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('users.assign-teacher') }}" method="POST" style="display:grid; grid-template-columns:1fr auto; gap:.75rem; align-items:end;">
                @csrf
                <div>
                    <label for="teacher_email" style="display:block; margin-bottom:.45rem; color:var(--text2); font-size:.82rem;">Existing email</label>
                    <input
                        id="teacher_email"
                        name="email"
                        list="existing-users"
                        value="{{ old('email') }}"
                        placeholder="teacher@exemple.com"
                        style="width:100%; background:var(--bg3); color:var(--text); border:1px solid var(--border); border-radius:10px; padding:.85rem 1rem; outline:none;"
                    >
                    <datalist id="existing-users">
                        @foreach ($users as $user)
                            <option value="{{ $user->email }}"></option>
                        @endforeach
                    </datalist>
                    @error('email')
                        <div style="margin-top:.45rem; color:var(--red); font-size:.78rem;">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" style="background:var(--purple); color:#fff; border:none; border-radius:10px; padding:.85rem 1.1rem; font-weight:600; cursor:pointer;">
                    Assign Teacher
                </button>
            </form>
        </div>
    </div>

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
                <span class="chip-up">{{ $newUsersThisMonth }}</span>
            </div>
            <div class="stat-num">{{ $totalUsers }}</div>
            <div class="stat-lbl">Total Users</div>
            <div class="stat-desc">// {{ $newUsersThisMonth }} new this month</div>
        </div>

        <div class="stat">
            <div class="stat-top">
                <div class="stat-ico" style="background:var(--green-bg);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--green)">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="chip-up">Active</span>
            </div>
            <div class="stat-num">{{ $activeUsers }}</div>
            <div class="stat-lbl">Active Users</div>
            <div class="stat-desc">// {{ $inactiveUsers }} inactive</div>
        </div>

        <div class="stat">
            <div class="stat-top">
                <div class="stat-ico" style="background:var(--cyan-bg);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--cyan)">
                        <path d="M12 3l2.8 5.67 6.26.91-4.53 4.42 1.07 6.25L12 17.27l-5.6 2.98 1.07-6.25L2.94 9.58l6.26-.91L12 3z"/>
                    </svg>
                </div>
                <span class="chip-up">Privileged</span>
            </div>
            <div class="stat-num">{{ $superAdminUsers }}</div>
            <div class="stat-lbl">Super Admin</div>
            <div class="stat-desc">// full site access</div>
        </div>

        <div class="stat">
            <div class="stat-top">
                <div class="stat-ico" style="background:var(--amber-bg);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--amber)">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="chip-up">Roles</span>
            </div>
            <div class="stat-num">{{ $adminUsers + $teacherUsers + $studentUsers }}</div>
            <div class="stat-lbl">Assigned Roles</div>
            <div class="stat-desc">// Admin, Teacher, Student</div>
        </div>
    </div>

    <div class="card" style="margin-top:1rem;">
        <div class="card-header">
            <div>
                <div class="card-title">Role Breakdown</div>
                <div class="card-subtitle">Current distribution across the system</div>
            </div>
            <span style="background:var(--purple-pale); color:var(--purple); padding:3px 9px; border-radius:99px; font-size:0.6rem;">LIVE</span>
        </div>
        <div class="card-body">
            <div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(180px,1fr));">
                <div class="stat" style="box-shadow:none;">
                    <div class="stat-lbl">Super Admin</div>
                    <div class="stat-num" style="font-size:2rem;">{{ $superAdminUsers }}</div>
                </div>
                <div class="stat" style="box-shadow:none;">
                    <div class="stat-lbl">Admin</div>
                    <div class="stat-num" style="font-size:2rem;">{{ $adminUsers }}</div>
                </div>
                <div class="stat" style="box-shadow:none;">
                    <div class="stat-lbl">Teacher</div>
                    <div class="stat-num" style="font-size:2rem;">{{ $teacherUsers }}</div>
                </div>
                <div class="stat" style="box-shadow:none;">
                    <div class="stat-lbl">Student</div>
                    <div class="stat-num" style="font-size:2rem;">{{ $studentUsers }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:1rem;">
        <div class="card-header">
            <div>
                <div class="card-title">Recent Users</div>
                <div class="card-subtitle">Newest accounts in the system</div>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:var(--bg3); color:var(--text3); font-size:.7rem; text-transform:uppercase; letter-spacing:.08em;">
                            <th style="text-align:left; padding:1rem; border-bottom:1px solid var(--border);">Name</th>
                            <th style="text-align:left; padding:1rem; border-bottom:1px solid var(--border);">Email</th>
                            <th style="text-align:left; padding:1rem; border-bottom:1px solid var(--border);">Role</th>
                            <th style="text-align:left; padding:1rem; border-bottom:1px solid var(--border);">Status</th>
                            <th style="text-align:left; padding:1rem; border-bottom:1px solid var(--border);">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users->take(10) as $user)
                            <tr style="border-bottom:1px solid var(--border);">
                                <td style="padding:1rem;">{{ $user->name }}</td>
                                <td style="padding:1rem; color:var(--text2);">{{ $user->email }}</td>
                                <td style="padding:1rem;">
                                    <span style="background:var(--purple-pale); color:var(--purple); padding:3px 9px; border-radius:99px; font-size:0.65rem;">
                                        {{ $user->getRoleNames()->first() ?? 'Student' }}
                                    </span>
                                </td>
                                <td style="padding:1rem;">
                                    <span style="background:{{ $user->status === 'active' ? 'var(--green-bg)' : 'var(--red-bg)' }}; color:{{ $user->status === 'active' ? 'var(--green)' : 'var(--red)' }}; padding:3px 9px; border-radius:99px; font-size:0.65rem;">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td style="padding:1rem; color:var(--text3);">{{ $user->created_at?->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding:2rem; text-align:center; color:var(--text3);">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
