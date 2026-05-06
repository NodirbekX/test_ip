@extends('layouts.app')

@section('title', 'IP Boshqaruvi')

@push('styles')
<style>
    .ips-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .ip-form-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-md);
    }

    .ip-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1rem;
    }

    .ip-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s;
    }

    .ip-card:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
    }

    .ip-address {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 600;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .ip-address svg {
        color: var(--text-muted);
    }

    .delete-btn {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 0.5rem;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .delete-btn:hover {
        background: var(--danger);
        color: white;
    }

    .empty-ips {
        text-align: center;
        padding: 3rem;
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        border: 1px dashed var(--border);
        color: var(--text-muted);
    }
</style>
@endpush

@section('content')
<div class="ips-container">
    <div class="page-header" style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.875rem; font-weight: 800; margin-bottom: 0.5rem;">IP Manzillar Filtratsiyasi</h1>
        <p class="text-muted">Faqatgina ruxsat berilgan IP manzillardan imtihonga kirish mumkin.</p>
    </div>

    <div class="ip-form-card">
        <h2 style="font-size: 1.125rem; margin-bottom: 1.5rem;">Yangi IP qo'shish</h2>
        <form method="POST" action="{{ route('ips.store') }}" style="display: flex; gap: 1rem;">
            @csrf
            <div style="flex: 1;">
                <input type="text" 
                       name="ip" 
                       class="form-control" 
                       placeholder="Masalan: 192.168.1.1" 
                       required
                       pattern="^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$">
            </div>
            <button type="submit" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Qo'shish
            </button>
        </form>
    </div>

    <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">Ruxsat berilgan manzillar</h2>
    
    @if($ips->count() > 0)
        <div class="ip-grid">
            @foreach($ips as $ip)
                <div class="ip-card">
                    <div class="ip-address">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                        {{ $ip->ip }}
                    </div>

                    <form method="POST" action="{{ route('ips.delete', $ip->id) }}" onsubmit="return confirm('Ushbu IP manzilni o\'chirishni xohlaysizmi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" title="O'chirish">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-ips">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p>Hozircha hech qanday IP manzil ruxsat etilmagan.</p>
        </div>
    @endif
</div>
@endsection

