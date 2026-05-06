@extends('layouts.app')

@section('title', 'Yangi savol qo\'shish')

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <div>
                <h1 class="form-title">Yangi savol qo'shish</h1>
                <p class="form-subtitle">Savol va variantlarni kiriting</p>
            </div>
            <a href="{{ route('tests.index') }}" class="btn-icon" title="Yopish">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </a>
        </div>

        <form method="POST" action="{{ route('tests.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">SAVOL MATNI</label>
                <textarea name="question" class="form-control" rows="4" required placeholder="Savolingizni kiriting...">{{ old('question') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">BALL</label>
                <input type="number" name="points" class="form-control" value="{{ old('points', 1) }}" min="1">
            </div>

            <div class="form-group">
                <label class="form-label">JAVOB VARIANTLARI</label>
                <div class="answers-stack">
                    @for($i = 0; $i < 4; $i++)
                        <label class="answer-row-input {{ old('correct_answer') == (string)$i ? 'active' : '' }}" id="answer-row-{{ $i }}">
                            <input type="radio" name="correct_answer" value="{{ $i }}" onchange="selectAnswer({{ $i }})" {{ old('correct_answer') == (string)$i ? 'checked' : '' }} class="sr-only" required>
                            <div class="radio-custom"></div>
                            <input type="text" name="answers[]" class="answer-text-input" placeholder="Variant {{ $i+1 }}" value="{{ old('answers.'.$i) }}" required>
                        </label>
                    @endfor
                </div>
                <div class="help-text">To'g'ri javob uchun radio tugmani belgilang</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">SAQLASH</button>
        </form>
    </div>
</div>

@push('styles')
<style>
    .form-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }
    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        width: 100%;
        max-width: 600px;
        padding: 2.5rem;
        box-shadow: var(--shadow-md);
    }
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2.5rem;
    }
    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 0.25rem;
    }
    .form-subtitle {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin: 0;
    }
    .btn-icon {
        color: var(--text-muted);
        text-decoration: none;
        padding: 0.5rem;
        border-radius: var(--radius-md);
        transition: background 0.2s, color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-icon:hover {
        background: var(--bg-hover);
        color: var(--text-main);
    }
    .answers-stack {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .answer-row-input {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
        background: var(--bg-main);
        cursor: pointer;
        transition: all 0.2s;
        margin: 0;
    }
    .answer-row-input:hover {
        border-color: rgba(56, 189, 248, 0.4);
    }
    .answer-row-input.active {
        border-color: var(--success);
        background: var(--success-bg);
    }
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }
    .radio-custom {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: border-color 0.2s;
    }
    .active .radio-custom {
        border-color: var(--success);
    }
    .active .radio-custom::after {
        content: '';
        width: 0.625rem;
        height: 0.625rem;
        background: var(--success);
        border-radius: 50%;
        transition: transform 0.2s;
    }
    .answer-text-input {
        flex: 1;
        border: none;
        background: transparent;
        color: var(--text-main);
        font-size: 0.875rem;
        font-family: inherit;
    }
    .answer-text-input:focus {
        outline: none;
    }
    .w-100 {
        width: 100%;
        padding: 0.875rem;
        font-size: 1rem;
        margin-top: 1rem;
    }
    .help-text {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function selectAnswer(index) {
        document.querySelectorAll('.answer-row-input').forEach((el, i) => {
            if (i === index) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');
            }
        });
    }
</script>
@endpush
@endsection
