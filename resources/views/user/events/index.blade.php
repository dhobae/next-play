@extends('user.layouts.app')

@section('content')
    <section class="event-hero"
        @if ($hero?->gambar) style="--event-hero-image: url('{{ asset('storage/' . $hero->gambar) }}');" @endif>
        <div class="container">
            <p class="eyebrow">Event</p>
            <h1>{{ $hero?->judul ?? 'JUDUL EVENT' }}</h1>
            <p>{{ $hero?->subjudul ?? '' }}</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="section-heading event-heading">
                <div>
                    <p class="eyebrow">JANGAN LEWATKAN</p>
                    <h2>Event <span>terkini.</span></h2>
                </div>
            </div>

            <!-- Featured event (1 besar) -->
            @if ($eventAcara->isNotEmpty())
                @php($featuredEvent = $eventAcara->first())
                <article class="featured-event mb-5">
                    <div class="image-placeholder featured-event-image">
                        @if ($featuredEvent->gambar)
                            <img src="{{ asset('storage/' . $featuredEvent->gambar) }}" alt="{{ $featuredEvent->judul }}">
                        @else
                            <span>Placeholder foto event utama</span><i class="bi bi-image"></i>
                        @endif
                    </div>
                    <div class="featured-event-copy">
                        <div class="event-meta">
                            <span><i class="bi bi-calendar3"></i>
                                {{ \Carbon\Carbon::parse($featuredEvent->tanggal)->translatedFormat('d F Y') }}</span>
                        </div>
                        <h3>{{ $featuredEvent->judul }}</h3>
                        <p>{{ Str::limit($featuredEvent->deskripsi, 100, '...') }}</p>
                        <a class="link-green" href="{{ route('events.show', $featuredEvent) }}">Lihat selengkapnya
                            <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>
            @else
                <article class="featured-event mb-5">
                    <div class="image-placeholder featured-event-image">
                        <span>Belum ada event terbaru</span><i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="featured-event-copy">
                        <h3>Belum ada event terbaru</h3>
                        <p>Event dan kegiatan terbaru akan tampil di halaman ini.</p>
                    </div>
                </article>
            @endif

            <!-- Splide event lainnya -->
            @if ($eventAcara->isNotEmpty())
                <div class="event-splide-wrap">
                    <div class="splide event-splide" aria-label="Event terkini">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($eventAcara->skip(1) as $event)
                                    <li class="splide__slide" id="event-{{ $event->id }}">
                                        <article class="event-grid-card">
                                            <div class="image-placeholder event-grid-image">
                                                @if ($event->gambar)
                                                    <img src="{{ asset('storage/' . $event->gambar) }}"
                                                        alt="{{ $event->judul }}">
                                                @else
                                                    <i class="bi bi-image"></i>
                                                @endif
                                            </div>
                                            <span
                                                class="event-date">{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}</span>
                                            <h3>{{ $event->judul }}</h3>
                                            <p>{{ Str::limit($event->deskripsi, 100, '...') }}</p>
                                            <a href="{{ route('events.show', $event) }}">Lihat selengkapnya
                                                <i class="bi bi-arrow-right"></i></a>
                                        </article>
                                    </li>
                                @endforeach
                                @for ($placeholderIndex = $eventAcara->skip(1)->count(); $placeholderIndex < 3; $placeholderIndex++)
                                    <li class="splide__slide">
                                        <article class="event-grid-card event-placeholder-card">
                                            <div class="image-placeholder event-grid-image">
                                                <i class="bi bi-calendar-plus"></i>
                                                <span>Event berikutnya akan hadir</span>
                                            </div>
                                            <span class="event-date">SEGERA HADIR</span>
                                            <h3>Event baru akan ditambahkan</h3>
                                            <p>Informasi kegiatan berikutnya akan tampil di sini.</p>
                                        </article>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>

                    {{-- <div class="splide-nav-wrap">
                    <button class="splide__arrow splide__arrow--prev event-splide-prev" type="button"
                        aria-label="Sebelumnya"></button>
                    <button class="splide__arrow splide__arrow--next event-splide-next" type="button"
                        aria-label="Berikutnya"></button>
                </div> --}}
                </div>
            @endif
        </div>
    </section>

    <section class="sponsor-section">
        <div class="container text-center">
            <p class="eyebrow">DIDUKUNG OLEH</p>
            <h2 class="mb-5">Sponsor & Kolaborator.</h2>
            <div class="splide sponsor-splide" aria-label="Sponsor dan kolaborator">
                <div class="splide__track">
                    <ul class="splide__list">
                        @forelse ($sponsors as $sponsor)
                            <li class="splide__slide sponsor-slide">
                                @if ($sponsor->gambar)
                                    <img src="{{ asset('storage/' . $sponsor->gambar) }}"
                                        alt="{{ $sponsor->nama_sponsor }}" class="img-fluid">
                                @else
                                    <span>{{ $sponsor->nama_sponsor }}</span>
                                @endif
                            </li>
                        @empty
                            <li class="splide__slide sponsor-slide text-muted">Belum ada sponsor.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const eventSplideElement = document.querySelector(".event-splide");
        if (eventSplideElement) {
            const secondaryEventCount = {{ max($eventAcara->count() - 1, 0) }};
            const eventSlideCount = Math.max(3, secondaryEventCount);

            const eventSplide = new Splide(eventSplideElement, {
                type: secondaryEventCount > 3 ? "loop" : "slide",
                perPage: 3,
                gap: "24px",
                pagination: eventSlideCount > 3,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    991: {
                        perPage: 2,
                        gap: "20px"
                    },
                    575: {
                        perPage: 1,
                        gap: "16px"
                    },
                },
            });
            eventSplide.mount();
        }
    </script>

    <script>
        const sponsorSplide = document.querySelector(".sponsor-splide");
        if (sponsorSplide) {
            const sponsorCount = sponsorSplide.querySelectorAll(".splide__slide").length;

            new Splide(sponsorSplide, {
                perPage: 6,
                gap: "28px",
                type: sponsorCount > 1 ? "loop" : "slide",
                arrows: false,
                pagination: false,
                drag: "free",
                autoScroll: {
                    speed: 0.2,
                    pauseOnHover: true,
                    pauseOnFocus: true,
                },
                breakpoints: {
                    991: {
                        perPage: 3,
                        gap: "20px"
                    },
                    575: {
                        perPage: 2,
                        gap: "14px"
                    },
                },
            }).mount(window.splide.Extensions);
        }
    </script>
@endsection
