@extends('layouts.app')

@section('title', 'Test Tafsilotlari #' . $test->id)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Test Tafsilotlari #{{ $test->id }}</h1>
        <p class="page-subtitle">Test savollari va to'g'ri javoblar ko'rinishi</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('tests.index') }}" class="btn btn-ghost">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Ortga qaytish
        </a>
        <a href="{{ route('tests.edit', $test->id) }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Tahrirlash
        </a>
    </div>
</div>

<div class="questions-list">
    @foreach($questions as $index => $question)
        <div class="question-card">
            <div class="card-top">
                <span class="question-number">SAVOL #{{ $index + 1 }}</span>
                <span class="points-badge">{{ $question->points }} ball</span>
            </div>

            <h2 class="question-text">{{ $question->question }}</h2>

            <div class="answers-grid">
                @foreach($question->answers as $answer)
                    <div class="answer-item {{ $answer->is_correct ? 'is-correct' : '' }}">
                        <span class="answer-content">{{ $answer->answer }}</span>
                        @if($answer->is_correct)
                            <div class="correct-indicator">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        letter-spacing: -0.025em;
        margin-bottom: 0.25rem;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .questions-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .question-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .question-number {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .points-badge {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .question-text {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-main);
    }

    .answers-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .answer-item {
        background: var(--bg-main);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .answer-item.is-correct {
        border-color: var(--success);
        background: rgba(16, 185, 129, 0.05);
    }

    .answer-content {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .correct-indicator {
        color: var(--success);
    }

    @media (max-width: 768px) {
        .answers-grid {
            grid-template-columns: 1fr;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .header-actions {
            width: 100%;
        }
        .header-actions .btn {
            flex: 1;
        }
    }
</style>
@endpush
@endsection
