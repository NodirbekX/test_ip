@extends('layouts.app')

@section('title', 'Vaqt Sozlamalari')

@push('styles')
<style>
    .time-settings-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .settings-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-md);
    }

    .time-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 640px) {
        .time-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-box {
        background: rgba(56, 189, 248, 0.05);
        border: 1px solid rgba(56, 189, 248, 0.2);
        padding: 1.25rem;
        border-radius: var(--radius-md);
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .info-box svg {
        color: var(--primary);
        flex-shrink: 0;
        margin-top: 0.25rem;
    }

    .info-box p {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1rem;
    }
</style>
@endpush

@section('content')
<div class="time-settings-container">
    <div class="page-header" style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.875rem; font-weight: 800; margin-bottom: 0.5rem;">Imtihon Vaqtini Sozlash</h1>
        <p class="text-muted">Imtihonning boshlanish va tugash vaqtlarini belgilang.</p>
    </div>

    <div class="settings-card">
        <form method="POST" action="{{ route('time.store') }}">
            @csrf

            <div class="time-grid">
                <div class="form-group">
                    <label class="form-label">IMTIHON BOSHLANISHI</label>
                    <input type="datetime-local" 
                           name="start_time" 
                           class="form-control"
                           value="{{ $time ? date('Y-m-d\TH:i', strtotime($time->start_time)) : '' }}"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">IMTIHON TUGASHI</label>
                    <input type="datetime-local" 
                           name="end_time" 
                           class="form-control"
                           value="{{ $time ? date('Y-m-d\TH:i', strtotime($time->end_time)) : '' }}"
                           required>
                </div>
            </div>

            <div class="info-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <p>Ushbu vaqt oralig'ida ruxsat etilgan barcha talabalar imtihon topshirishlari mumkin bo'ladi. Vaqt tugashi bilan imtihon avtomatik ravishda yakunlanadi.</p>
            </div>

            <button type="submit" class="btn btn-primary submit-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Vaqtni saqlash
            </button>
        </form>
    </div>
</div>
@endsection

