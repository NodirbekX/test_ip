@extends('layouts.app')

@section('title', 'Imtihon Natijasi')

@push('styles')
<style>
    .result-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
        animation: fadeIn 0.8s ease-out;
    }

    .result-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 3rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        max-width: 600px;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .result-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--success));
    }

    .score-circle {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .score-circle svg {
        position: absolute;
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .score-circle circle {
        fill: none;
        stroke-width: 10;
        stroke-linecap: round;
    }

    .score-circle .bg {
        stroke: var(--bg-hover);
    }

    .score-circle .progress {
        stroke: var(--primary);
        stroke-dasharray: 534; /* 2 * PI * 85 */
        stroke-dashoffset: calc(534 - (534 * {{ ($total > 0) ? ($correct / $total) : 0 }}));
        transition: stroke-dashoffset 1s ease-out;
    }

    .score-text {
        text-align: center;
        z-index: 1;
    }

    .score-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1;
    }

    .score-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 0.25rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-item {
        background: var(--bg-main);
        padding: 1.25rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
        display: block;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-item.correct {
        border-color: rgba(34, 197, 94, 0.3);
    }

    .stat-item.correct .stat-value {
        color: var(--success);
    }

    .stat-item.wrong {
        border-color: rgba(239, 68, 68, 0.3);
    }

    .stat-item.wrong .stat-value {
        color: var(--danger);
    }

    .result-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="result-container">
    <div class="result-card">
        <h1 style="margin-bottom: 2rem; font-size: 1.75rem;">Imtihon Natijasi</h1>

        @php
            $percentage = ($total > 0) ? round(($correct / $total) * 100, 1) : 0;
            $mistakes = $total - $correct;
        @endphp

        <div class="score-circle">
            <svg viewBox="0 0 180 180">
                <circle class="bg" cx="90" cy="90" r="85"></circle>
                <circle class="progress" cx="90" cy="90" r="85"></circle>
            </svg>
            <div class="score-text">
                <div class="score-value">{{ $percentage }}%</div>
                <div class="score-label">Muvaffaqiyat</div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-item correct">
                <span class="stat-value">{{ $correct }}</span>
                <span class="stat-label">To'g'ri javoblar</span>
            </div>
            <div class="stat-item wrong">
                <span class="stat-value">{{ $mistakes }}</span>
                <span class="stat-label">Xato javoblar</span>
            </div>
            <div class="stat-item" style="grid-column: span 2;">
                <span class="stat-value">{{ $total }}</span>
                <span class="stat-label">Jami savollar</span>
            </div>
        </div>

        <div class="result-actions">
            <a href="{{ url('/') }}" class="btn btn-ghost">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Bosh sahifaga
            </a>
           
        </div>
    </div>
</div>
@endsection

