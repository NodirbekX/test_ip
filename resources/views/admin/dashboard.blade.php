@extends('layouts.app')

@section('title', 'Boshqaruv Paneli')

@push('styles')
<style>
    .dashboard-header {
        margin-bottom: 2.5rem;
    }

    .dashboard-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .dashboard-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-info h3 {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-info .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 992px) {
        .main-grid {
            grid-template-columns: 1fr;
        }
    }

    .content-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        height: 100%;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    .status-active { background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2); }
    .status-pending { background: rgba(250, 204, 21, 0.1); color: #facc15; border: 1px solid rgba(250, 204, 21, 0.2); }
    .status-finished { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-main);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        color: var(--text-main);
        text-decoration: none;
        transition: all 0.2s;
    }

    .quick-action-btn:hover {
        background: var(--bg-hover);
        border-color: var(--primary);
        transform: translateX(4px);
    }

    .quick-action-btn svg {
        color: var(--primary);
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1 class="dashboard-title">Yakuniy Nazorat</h1>
    <p class="dashboard-subtitle">Imtihonlarni boshqarish va monitoring qilish tizimi</p>
</div>

<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(56, 189, 248, 0.1); color: var(--primary);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        </div>
        <div class="stat-info">
            <h3>Savollar</h3>
            <div class="value">{{ $questionsCount }} ta</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1); color: var(--success);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="stat-info">
            <h3>Talabalar</h3>
            <div class="value">Monitoring</div>
        </div>
    </div>
</div>

<div class="main-grid">
    <div class="content-card">
        <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Imtihon Holati</h2>
        
        <div style="text-align: center; padding: 2rem 0;">
            @if($status === 'not_started')
                <div class="status-badge status-pending">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Imtihon boshlanmadi
                </div>
                <h3 style="margin-bottom: 1rem;">Tayyorgarlik ko'rilmoqda</h3>
                <p class="text-muted" style="margin-bottom: 2rem;">Belgilangan vaqt kelishi bilan talabalar imtihonni topshirishni boshlashlari mumkin.</p>
            @endif

            @if($status === 'active')
                <div class="status-badge status-active">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Imtihon faol
                </div>
                <h3 style="margin-bottom: 1rem;">Jarayon davom etmoqda</h3>
                <p class="text-muted" style="margin-bottom: 2rem;">Hozirda talabalar savollarga javob bermoqdalar.</p>
                <a href="{{ route('student.exam') }}" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    Imtihonni ko'rish
                </a>
            @endif

            @if($status === 'finished')
                <div class="status-badge status-finished">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    Imtihon tugagan
                </div>
                <h3 style="margin-bottom: 1rem;">Natijalar tayyor</h3>
                <p class="text-muted" style="margin-bottom: 2rem;">Barcha talabalar imtihonni topshirib bo'lishdi yoki vaqt tugadi.</p>
                <a href="{{ route('student.result') }}" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    Natijalarni ko'rish
                </a>
            @endif

            @if($status === 'not_set')
                <div class="status-badge status-pending">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Vaqt belgilanmagan
                </div>
                <h3 style="margin-bottom: 1.5rem;">Iltimos, vaqtni sozlang</h3>
                <a href="{{ route('time.index') }}" class="btn btn-primary">
                    Vaqtni sozlash
                </a>
            @endif
        </div>
    </div>

    <div class="quick-actions-card">
        <div class="content-card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.125rem;">Tezkor Amallar</h2>
            
            <div class="quick-actions">
                <a href="{{ route('time.index') }}" class="quick-action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Vaqtni belgilash
                </a>
                <a href="{{ route('tests.index') }}" class="quick-action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Savollar boshqaruvi
                </a>
                <a href="{{ route('ips.index') }}" class="quick-action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                    IP manzillar filtri
                </a>
            </div>

            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                <h3 style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem; text-transform: uppercase;">Imtihon Vaqti</h3>
                @if($time)
                    <div style="font-size: 0.875rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Boshlanishi:</span>
                            <span style="color: var(--text-main); font-weight: 500;">{{ \Carbon\Carbon::parse($time->start_time)->format('d.m.Y H:i') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Tugashi:</span>
                            <span style="color: var(--text-main); font-weight: 500;">{{ \Carbon\Carbon::parse($time->end_time)->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-muted" style="font-size: 0.875rem;">Vaqt belgilanmagan</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

