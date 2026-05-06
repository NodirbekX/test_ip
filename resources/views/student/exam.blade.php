@extends('layouts.app')

@section('title', 'Imtihon')

@push('styles')
<style>
    .exam-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: var(--bg-card);
        padding: 1.5rem;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 1rem;
        z-index: 10;
    }

    .exam-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .timer-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(56, 189, 248, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        border: 1px solid rgba(56, 189, 248, 0.2);
        color: var(--primary);
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }

    .status-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 50vh;
        text-align: center;
        gap: 1.5rem;
    }

    .status-card {
        background: var(--bg-card);
        padding: 3rem;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        max-width: 500px;
        width: 100%;
    }

    .status-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        display: block;
    }

    .question-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .question-number {
        display: inline-block;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .question-text {
        font-size: 1.25rem;
        font-weight: 500;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .answers-grid {
        display: grid;
        gap: 1rem;
    }

    .answer-option {
        position: relative;
        display: flex;
        align-items: center;
        padding: 1.25rem;
        background: var(--bg-main);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .answer-option:hover {
        border-color: var(--primary);
        background: var(--bg-hover);
    }

    .answer-option input[type="radio"] {
        appearance: none;
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--text-muted);
        border-radius: 50%;
        margin-right: 1rem;
        position: relative;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .answer-option input[type="radio"]:checked {
        border-color: var(--primary);
        background: var(--primary);
        box-shadow: inset 0 0 0 3px var(--bg-main);
    }

    .answer-option:has(input:checked) {
        border-color: var(--primary);
        background: rgba(56, 189, 248, 0.05);
    }

    .answer-text {
        font-size: 1rem;
        color: var(--text-main);
    }

    .pagination-nav {
        margin-bottom: 2rem;
    }

    .pagination-nav .pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-nav .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 0.75rem;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        color: var(--text-main);
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 600;
        font-size: 0.875rem;
        box-sizing: border-box;
    }

    .pagination-nav .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .pagination-nav .page-item.disabled .page-link,
    .pagination-nav .page-item .page-link[aria-disabled="true"] {
        opacity: 0.5;
        cursor: not-allowed;
        background: var(--bg-main);
    }

    .pagination-nav .page-item .page-link:hover:not(.active):not([aria-disabled="true"]) {
        background: var(--bg-hover);
        border-color: var(--primary);
    }

    /* Tailwind-specific targeting for the actual buttons */
    .pagination-nav nav span[aria-current="page"] > span,
    .pagination-nav nav span[aria-disabled="true"] > span,
    .pagination-nav nav a {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem !important;
        height: 2.5rem !important;
        padding: 0 0.75rem !important;
        background: var(--bg-card) !important;
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        color: var(--text-main) !important;
        text-decoration: none !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s !important;
        margin: 0 0.25rem !important;
    }

    .pagination-nav nav span[aria-current="page"] > span {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }

    .pagination-nav nav span[aria-disabled="true"] > span {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
    }

    .pagination-nav nav a:hover {
        background: var(--bg-hover) !important;
        border-color: var(--primary) !important;
    }

    /* Target ANY svg in pagination to prevent massive icons */
    .pagination-nav svg {
        width: 1.25rem !important;
        height: 1.25rem !important;
        display: inline-block !important;
    }

    /* Target the "Showing X to Y of Z results" text and hide it */
    .pagination-nav nav p {
        display: none !important;
    }

    /* Hide the mobile view which often contains large arrows */
    .pagination-nav nav > div:first-child:not(:last-child) {
        display: none !important;
    }

    /* Center the main pagination container */
    .pagination-nav nav > div:last-child {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
    }

    .pagination-nav nav {
        display: flex !important;
        justify-content: center !important;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1.125rem;
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container">

    {{-- NOT STARTED --}}
    @if($status === 'not_started')
        <div class="status-container">
            <div class="status-card">
                <span class="status-icon">⏳</span>
                <h2>Imtihon hali boshlanmadi</h2>
                <p class="text-muted">Iltimos, belgilangan vaqtni kuting.</p>
                <a href="{{ url('/') }}" class="btn btn-ghost">Bosh sahifaga qaytish</a>
            </div>
        </div>
    @endif

    {{-- FINISHED --}}
    @if($status === 'finished')
        <div class="status-container">
            <div class="status-card">
                <span class="status-icon">❌</span>
                <h2>Imtihon tugagan</h2>
                <p class="text-muted">Siz ushbu imtihonni topshirib bo'lgansiz yoki vaqt tugagan.</p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="{{ route('student.result') }}" class="btn btn-primary">Natijani ko‘rish</a>
                    <a href="{{ url('/') }}" class="btn btn-ghost">Bosh sahifaga qaytish</a>
                </div>
            </div>
        </div>
    @endif

    {{-- ACTIVE --}}
    @if($status === 'active')
        <form id="examForm" method="POST" action="{{ route('student.submit') }}">
            @csrf

            <div class="exam-header">
                <h2 class="exam-title">Online Imtihon</h2>
                
                @if($time)
                    <div class="timer-container">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span id="timer">Yuklanmoqda...</span>
                    </div>
                @endif
            </div>

            {{-- PAGINATION --}}
            <nav class="pagination-nav">
                {{ $questions->links() }}
            </nav>

            {{-- QUESTION --}}
            @foreach($questions as $q)
                <div class="question-card">
                    <span class="question-number">Savol {{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}</span>
                    <div class="question-text">{{ $q->question }}</div>

                    <div class="answers-grid">
                        @foreach($q->answers as $a)
                            <label class="answer-option">
                                <input type="radio"
                                       name="answers[{{ $q->id }}]"
                                       value="{{ $a->id }}"
                                       onchange="saveAnswer({{ $q->id }}, {{ $a->id }})">
                                <span class="answer-text">{{ $a->answer }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary submit-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Imtihonni yakunlash
            </button>

        </form>
    @endif

</div>
@endsection

@push('scripts')
<script>
    @if($status === 'active' && $time)
    let end = new Date("{{ \Carbon\Carbon::parse($time->end_time)->toIso8601String() }}").getTime();

    let x = setInterval(function() {
        let now = new Date().getTime();
        let distance = end - now;

        if (distance <= 0) {
            clearInterval(x);
            document.getElementById("examForm").submit(); // auto submit
        }

        let hours = Math.floor(distance / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("timer").innerHTML =
            (hours > 0 ? hours + "s " : "") + minutes + "m " + seconds + "s";
    }, 1000);
    @endif

    // SAVE ANSWERS
    function saveAnswer(questionId, answerId) {
        let answers = JSON.parse(localStorage.getItem('answers') || '{}');
        answers[questionId] = answerId;
        localStorage.setItem('answers', JSON.stringify(answers));
    }

    // LOAD ANSWERS
    function loadAnswers() {
        let answers = JSON.parse(localStorage.getItem('answers') || '{}');

        for (let q in answers) {
            let input = document.querySelector(
                'input[name="answers[' + q + ']"][value="' + answers[q] + '"]'
            );
            if (input) {
                input.checked = true;
            }
        }
    }

    // SUBMIT ALL ANSWERS
    document.addEventListener("DOMContentLoaded", function () {
        loadAnswers();

        document.getElementById("examForm")?.addEventListener("submit", function () {
            let answers = JSON.parse(localStorage.getItem('answers') || '{}');

            for (let q in answers) {
                // Avoid duplicating if already present in form (unlikely but safe)
                if (!this.querySelector(`input[type="hidden"][name="answers[${q}]"]`)) {
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "answers[" + q + "]";
                    input.value = answers[q];
                    this.appendChild(input);
                }
            }

            localStorage.removeItem('answers'); // cleanup after submit
        });
    });
</script>
@endpush

