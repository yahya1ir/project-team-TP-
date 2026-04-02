{{-- resources/views/formations/index.blade.php --}}
@extends('layouts.app')

@section('title', __('messages.formations.title'))

@push('styles')
  <link rel="stylesheet" href="{{ url('CSS/addformation.css') }}">

@endpush

@section('content')



{{-- ── PAGE HEADER ── --}}
<div class="page-header">
    <div>
        <div class="eyebrow">{{ __('messages.nav.training') }}</div>
        <h1>{{ __('messages.formations.title') }}</h1>
        <p class="subtitle">{{ __('messages.formations.manageFormations') }}</p>
    </div>
    <div class="date-info">
        {{ now()->format('l, d M Y') }}
        <strong>{{ $formations->total() }} formation{{ $formations->total() !== 1 ? 's' : '' }}</strong>
    </div>
</div>

{{-- ── STATS ROW ── --}}
<div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));margin-bottom:1.75rem;">

    <div class="stat">
        <div class="stat-top">
            <div class="stat-ico" style="background:var(--green-bg);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20v-1a8 8 0 0 1 16 0v1"/>
                </svg>
            </div>
            <span class="chip-up">{{ __('messages.formations.beginner') }}</span>
        </div>
        <div class="stat-num">{{ $beginnerCount }}</div>
        <div class="stat-lbl">{{ __('messages.formations.beginnerFormations') }}</div>
        <div class="stat-desc">{{ __('messages.formations.entryLevelProgrammes') }}</div>
    </div>

    <div class="stat">
        <div class="stat-top">
            <div class="stat-ico" style="background:var(--amber-bg);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <span style="font-family:'IBM Plex Mono',monospace;font-size:.6rem;padding:2px 8px;border-radius:99px;background:var(--amber-bg);color:var(--amber);">MID</span>
        </div>
        <div class="stat-num">{{ $intermediateCount }}</div>
        <div class="stat-lbl">{{ __('messages.formations.intermediate') }}</div>
        <div class="stat-desc">{{ __('messages.formations.midLevelProgrammes') }}</div>
    </div>

    <div class="stat">
        <div class="stat-top">
            <div class="stat-ico" style="background:var(--red-bg);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="2">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
            </div>
            <span class="chip-down">{{ __('messages.formations.advanced') }}</span>
        </div>
        <div class="stat-num">{{ $advancedCount }}</div>
        <div class="stat-lbl">{{ __('messages.formations.advanced') }}</div>
        <div class="stat-desc">{{ __('messages.formations.expertLevelProgrammes') }}</div>
    </div>

    <div class="stat">
        <div class="stat-top">
            <div class="stat-ico" style="background:var(--purple-pale);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--purple)" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                </svg>
            </div>
            <span class="chip-up">Total</span>
        </div>
        <div class="stat-num">{{ $formations->total() }}</div>
        <div class="stat-lbl">{{ __('messages.formations.allFormations') }}</div>
        <div class="stat-desc">{{ __('messages.formations.acrossAllLevels') }}</div>
    </div>

</div>

{{-- ── MAIN CARD ── --}}
<div class="card" style="margin-bottom:0;">

    <div class="card-header">
        <div>
            <div class="card-title">{{ __('messages.formations.allFormations') }}</div>
            <div class="card-subtitle">{{ now()->format('M Y') }} · {{ __('messages.formations.browseFilterManage') }}</div>
        </div>
        <div style="display:flex;gap:.6rem;">
            @can('manage formations')
            <button class="btn btn-primary btn-sm" onclick="openModal()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                {{ __('messages.formations.newFormation') }}
            </button>
            @endcan
        </div>
    </div>

    {{-- Filters --}}
    <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--border);">
        <div class="filters-bar">
            <a class="filter-pill {{ !request('level') ? 'active' : '' }}"
               href="{{ route('formation', array_merge(request()->except('level','page'), [])) }}">{{ __('messages.formations.all') }}</a>
            <a class="filter-pill {{ request('level') === 'Beginner' ? 'active' : '' }}"
               href="{{ route('formation', array_merge(request()->except('level','page'), ['level' => 'Beginner'])) }}">
                <span style="width:6px;height:6px;border-radius:50%;background:var(--green);display:inline-block;"></span>
                {{ __('messages.formations.beginner') }}
            </a>
            <a class="filter-pill {{ request('level') === 'Intermediate' ? 'active' : '' }}"
               href="{{ route('formation', array_merge(request()->except('level','page'), ['level' => 'Intermediate'])) }}">
                <span style="width:6px;height:6px;border-radius:50%;background:var(--amber);display:inline-block;"></span>
                {{ __('messages.formations.intermediate') }}
            </a>
            <a class="filter-pill {{ request('level') === 'Advanced' ? 'active' : '' }}"
               href="{{ route('formation', array_merge(request()->except('level','page'), ['level' => 'Advanced'])) }}">
                <span style="width:6px;height:6px;border-radius:50%;background:var(--red);display:inline-block;"></span>
                {{ __('messages.formations.advanced') }}
            </a>
            <div class="filter-sep"></div>
            <select class="sort-select" onchange="window.location=this.value">
                <option value="{{ route('formation', array_merge(request()->except('sort','page'), ['sort'=>'newest'])) }}"
                    {{ request('sort','newest') === 'newest' ? 'selected' : '' }}>{{ __('messages.formations.newestFirst') }}</option>
                <option value="{{ route('formation', array_merge(request()->except('sort','page'), ['sort'=>'oldest'])) }}"
                    {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('messages.formations.oldestFirst') }}</option>
                <option value="{{ route('formation', array_merge(request()->except('sort','page'), ['sort'=>'title'])) }}"
                    {{ request('sort') === 'title' ? 'selected' : '' }}>Title A→Z</option>
                <option value="{{ route('formation', array_merge(request()->except('sort','page'), ['sort'=>'duration'])) }}"
                    {{ request('sort') === 'duration' ? 'selected' : '' }}>{{ __('messages.form.duration') }}</option>
            </select>
            <div class="view-toggle">
                <button class="active" id="btn-grid" onclick="switchView('grid')" title="Grid view">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                </button>
                <button id="btn-list" onclick="switchView('list')" title="List view">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                        <line x1="8" y1="18" x2="21" y2="18"/>
                        <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/>
                        <line x1="3" y1="18" x2="3.01" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── GRID VIEW ── --}}
    <div class="card-body" id="view-grid">
        @if($formations->isEmpty())
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
                <h3>{{ __('messages.formations.noFormations') }}</h3>
                <p>{{ __('messages.formations.createFirst') }}</p>
            </div>
        @else
            <div class="formations-grid" id="formationsGrid">
                @foreach($formations as $formation)
                <div class="formation-card" data-level="{{ $formation->level }}">
                    <div class="fc-head">
                        <div class="fc-meta">
                            <span class="level-badge {{ strtolower($formation->level) }}">
                                {{ $formation->level }}
                            </span>
                            @if($formation->duration)
                            <span class="fc-duration">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ $formation->duration }}
                            </span>
                            @endif
                        </div>
                        <div class="fc-title">{{ $formation->title_fr }}</div>
                        <div class="fc-email">{{ $formation->email }}</div>
                    </div>
                    <div class="fc-body">
                        <p class="fc-desc">
                            {{ $formation->short_description_fr ?? __('messages.formations.noDescriptionProvided') }}
                        </p>
                    </div>
                    <div class="fc-foot">
                        @can('manage formations')
                        <form method="POST" action="{{ route('delete.post', $formation->id) }}"
                              onsubmit="return confirm('{{ __('messages.formations.deleteConfirm', ['title' => $formation->title_fr]) }}')" style="margin:0;flex:1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="width:100%;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                                </svg>
                                {{ __('messages.formations.delete') }}
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── LIST VIEW ── --}}
    <div id="view-list" style="display:none;">
        @unless($formations->isEmpty())
        <div class="list-header">
            <div class="lh-cell">{{ __('messages.formations.title') }}</div>
            <div class="lh-cell">{{ __('messages.form.shortDescription') }}</div>
            <div class="lh-cell">{{ __('messages.form.level') }}</div>
            <div class="lh-cell">{{ __('messages.form.duration') }}</div>
            <div class="lh-cell">{{ __('messages.formations.actions') }}</div>
        </div>
        @foreach($formations as $formation)
        <div class="list-row" data-level="{{ $formation->level }}">
            <div>
                <div class="lr-title">{{ $formation->title_fr }}</div>
                <div class="lr-email">{{ $formation->email }}</div>
            </div>
            <div class="lr-desc">{{ $formation->short_description_fr ?? '—' }}</div>
            <div>
                <span class="level-badge {{ strtolower($formation->level) }}">{{ $formation->level }}</span>
            </div>
            <div style="font-family:'IBM Plex Mono',monospace;font-size:.72rem;color:var(--text2);">
                {{ $formation->duration ?? '—' }}
            </div>
            <div style="display:flex;gap:.5rem;">
                @can('manage formations')
                <form method="POST" action="{{ route('delete.post', $formation->id) }}"
                      onsubmit="return confirm('{{ __('messages.formations.deleteConfirm', ['title' => $formation->title_fr]) }}')" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.formations.delete') }}</button>
                </form>
                @endcan
            </div>
        </div>
        @endforeach
        @endunless
    </div>

    {{-- ── PAGINATION ── --}}
    @if($formations->hasPages())
    <div class="pagination-wrap">
        <div class="pag-info">
            {{ __('messages.formations.showing') }} {{ $formations->firstItem() }}–{{ $formations->lastItem() }}
            {{ __('messages.formations.of') }} {{ $formations->total() }} {{ __('messages.formations.formations') }}
        </div>
        <div class="pag-btns">
            @if($formations->onFirstPage())
                <button class="pag-btn" disabled>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </button>
            @else
                <a href="{{ $formations->previousPageUrl() }}" class="pag-btn">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
            @endif

            @foreach($formations->getUrlRange(1, $formations->lastPage()) as $page => $url)
                @if($page == $formations->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @endif
            @endforeach

            @if($formations->hasMorePages())
                <a href="{{ $formations->nextPageUrl() }}" class="pag-btn">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
            @else
                <button class="pag-btn" disabled>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection

{{-- ── FAB ACTIONS ── --}}
@section('fab-actions')
@can('manage formations')
<a class="fab-action" onclick="openModal()">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
    </svg>
    {{ __('messages.formations.newFormation') }}
</a>
@endcan
@can('manage sessions')
<a class="fab-action" href="#">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
    </svg>
    {{ __('messages.dashboard.scheduleSession') }}
</a>
@endcan
@endsection

{{-- ── CREATE MODAL ── --}}
<div class="modal-backdrop" id="modalBackdrop" onclick="closeModal(event)">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">{{ __('messages.formations.newFormation') }}</div>
            <button class="modal-close" onclick="closeModalDirect()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('formations.store') }}">
            @csrf
            <div class="modal-body">

                @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1.25rem;">
                    <ul style="margin:0;padding-left:1.2rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            {{ __('messages.form.title') }} <span style="color:var(--red)">*</span>
                        </label>
                        <input type="text" name="title_fr" class="form-control"
                               placeholder="e.g. Introduction au marketing"
                               value="{{ old('title_fr') }}" required>
                    </div>
                   
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.form.level') }}</label>
                        <select name="level" class="form-control">
                            @foreach(['Beginner','Intermediate','Advanced'] as $lvl)
                                <option value="{{ $lvl }}" {{ old('level') === $lvl ? 'selected' : '' }}>
                                    {{ $lvl }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.form.duration') }}</label>
                        <input type="text" name="duration" class="form-control"
                               placeholder="e.g. 3 jours, 16h"
                               value="{{ old('duration') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('messages.form.shortDescription') }}</label>
                    <textarea name="short_description_fr" class="form-control" rows="2"
                              placeholder="A brief overview of the formation…">{{ old('short_description_fr') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('messages.form.fullDescription') }}</label>
                    <textarea name="full_description_fr" class="form-control" rows="4"
                              placeholder="Complete programme details, objectives, prerequisites…">{{ old('full_description_fr') }}</textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="closeModalDirect()">{{ __('messages.form.cancel') }}</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    {{ __('messages.formations.newFormation') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="{{ url('JS/addformation.js') }}"></script>
@endpush