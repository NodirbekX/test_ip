@extends('layouts.app')

@section('title', 'Savollar')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Savollar boshqaruvi</h1>
        <p class="page-subtitle">Barcha savollar ro'yxati</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('tests.create') }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Yangi savol
        </a>
    </div>
</div>

<div class="questions-list">
    @foreach($tests as $test)
        @php
            $questions = \App\Models\Question::where('test_id', $test->id)->get();
        @endphp

        @foreach($questions as $index => $question)
            @php
                $answers = \App\Models\Answer::where('question_id', $question->id)->get();
            @endphp
            <div class="question-card">
                <div class="card-top">
                    <span class="question-number">SAVOL #{{ $index+1 }} <span class="test-ref">(Test #{{ $test->id }})</span></span>
                    <div class="actions">
                        <span class="points-badge">{{ $question->points }} ball</span>
                        
                        <a href="{{ route('tests.show', $test->id) }}" class="btn-icon" title="Ko'rish">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        
                        <a href="{{ route('tests.edit', $test->id) }}" class="btn-icon" title="Tahrirlash">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>

                        <form action="{{ route('tests.destroy', $test->id) }}" method="POST" class="delete-form" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-icon btn-delete" onclick="confirmDelete(this)" title="O'chirish">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <h2 class="question-text">{{ $question->question }}</h2>

                <div class="answers-grid">
                    @foreach($answers as $answer)
                        <div class="answer-item {{ $answer->is_correct ? 'is-correct' : '' }}">
                            <span class="answer-content">{{ $answer->answer }}</span>
                            @if($answer->is_correct)
                                <div class="correct-indicator">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endforeach

    @if($tests->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
            <p>Hozircha savollar yo'q</p>
        </div>
    @endif
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
        margin-bottom: 0.25rem;
    }
    .page-subtitle {
        color: var(--text-muted);
        font-size: 0.875rem;
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
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .question-card:hover {
        border-color: rgba(56, 189, 248, 0.4);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
    .test-ref {
        font-weight: 400;
        opacity: 0.7;
    }
    .actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .points-badge {
        background: rgba(56, 189, 248, 0.1);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        margin-right: 0.5rem;
    }
    .btn-icon {
        background: transparent;
        border: none;
        padding: 0.5rem;
        border-radius: var(--radius-md);
        cursor: pointer;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-icon:hover {
        background: var(--bg-hover);
        color: var(--text-main);
    }
    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }
    .question-text {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-main);
        line-height: 1.5;
        margin-top: 0;
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
        transition: border-color 0.2s;
    }
    .answer-item.is-correct {
        border-color: var(--success);
        background: var(--success-bg);
    }
    .answer-content {
        font-size: 0.875rem;
        font-weight: 500;
    }
    .correct-indicator {
        color: var(--success);
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        border: 1px dashed var(--border);
    }
    .empty-state svg {
        margin-bottom: 1rem;
        opacity: 0.5;
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
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(button) {
        if(confirm('Ushbu savolni o\'chirishni xohlaysizmi?')) {
            button.closest('form').submit();
        }
    }
</script>
@endpush
@endsection
