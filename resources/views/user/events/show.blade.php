@extends('user.layouts.app')

@section('content')
    <section class="section-padding">
        <div class="container mb-3">
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb detail-breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events') }}">Event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $event->judul }}</li>
                </ol>
            </nav>
        </div>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="image-placeholder detail-image">
                        @if ($event->gambar)
                            <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->judul }}">
                        @else
                            <img src="{{ asset('assets/nextpremiere/padel-dummy.png') }}" alt="{{ $event->judul }}">
                        @endif
                    </div>
                    <div class="detail-copy mt-5">
                        {{-- <p class="eyebrow">TENTANG EVENT</p> --}}
                        <p class="event-date detail-date">
                            {{ \Carbon\Carbon::parse($event->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                        <h2>{{ $event->judul }}</h2>
                        <p>{!! nl2br(e($event->deskripsi)) !!}</p>
                        @php
                            $shareUrl = url()->current();
                            $shareText = $event->judul;
                        @endphp
                        <div class="detail-share">
                            <p class="eyebrow">BAGIKAN ARTIKEL</p>
                            <div class="share-links" aria-label="Bagikan event">
                                <a class="share-link share-facebook"
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($shareUrl) }}"
                                    target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke Facebook"
                                    title="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                                <a class="share-link share-whatsapp"
                                    href="https://wa.me/?text={{ rawurlencode($shareText . ' ' . $shareUrl) }}"
                                    target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke WhatsApp"
                                    title="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                <a class="share-link share-twitter"
                                    href="https://twitter.com/intent/tweet?url={{ rawurlencode($shareUrl) }}&text={{ rawurlencode($shareText) }}"
                                    target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke Twitter"
                                    title="Bagikan ke Twitter"><i class="bi bi-twitter-x"></i></a>
                                <button class="share-link share-copy" type="button" data-share-url="{{ $shareUrl }}"
                                    aria-label="Salin tautan event" title="Salin tautan event"><i
                                        class="bi bi-link-45deg"></i></button>
                            </div>
                            <span class="share-copy-status" role="status" aria-live="polite"></span>
                        </div>
                    </div>
                </div>
                <aside class="col-lg-4">
                    <div class="event-sidebar">
                        <div class="related-events-sidebar">
                            <p class="eyebrow">JANGAN LEWATKAN</p>
                            <h2>Event <span>lainnya.</span></h2>
                            <div class="related-events-list">
                                @foreach ($relatedEvents as $relatedEvent)
                                    <article class="related-event-card">
                                        <a class="related-event-image" href="{{ route('events.show', $relatedEvent) }}">
                                            @if ($relatedEvent->gambar)
                                                <img src="{{ asset('storage/' . $relatedEvent->gambar) }}"
                                                    alt="{{ $relatedEvent->judul }}">
                                            @else
                                                <img src="{{ asset('assets/nextpremiere/padel-dummy.png') }}"
                                                    alt="{{ $relatedEvent->judul }}">
                                            @endif
                                        </a>
                                        <p class="event-date">
                                            {{ \Carbon\Carbon::parse($relatedEvent->tanggal)->locale('id')->translatedFormat('d F Y') }}
                                        </p>
                                        <h3>{{ $relatedEvent->judul }}</h3>
                                        <a class="link-green" href="{{ route('events.show', $relatedEvent) }}">
                                            Lihat selengkapnya <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </article>
                                @endforeach
                                @for ($placeholderIndex = $relatedEvents->count(); $placeholderIndex < 3; $placeholderIndex++)
                                    <article class="related-event-card related-event-placeholder">
                                        <div class="related-event-image">
                                            <img src="{{ asset('assets/nextpremiere/padel-dummy.png') }}"
                                                alt="Event lainnya akan hadir">
                                        </div>
                                        <p class="event-date">SEGERA HADIR</p>
                                        <h3>Event lainnya akan hadir</h3>
                                        <p class="related-event-placeholder-copy">Informasi event berikutnya akan tampil di
                                            sini.</p>
                                    </article>
                                @endfor
                            </div>
                        </div>
                    </div>
            </div>
            </aside>
        </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.share-copy').forEach(function(button) {
            button.addEventListener('click', async function() {
                const url = this.dataset.shareUrl;
                const status = this.closest('.detail-share').querySelector('.share-copy-status');

                try {
                    await navigator.clipboard.writeText(url);
                } catch (error) {
                    const input = document.createElement('textarea');
                    input.value = url;
                    input.setAttribute('readonly', '');
                    input.style.position = 'absolute';
                    input.style.left = '-9999px';
                    document.body.appendChild(input);
                    input.select();
                    document.execCommand('copy');
                    input.remove();
                }

                status.textContent = 'Tautan berhasil disalin.';
                window.setTimeout(function() {
                    status.textContent = '';
                }, 2500);
            });
        });
    </script>
@endsection
