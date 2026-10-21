@extends('user.layouts.app')

@section('content')
    <main>
        <section id="beranda" class="hero-section">
            <div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
                @if ($carousels->isNotEmpty())
                    <div class="carousel-indicators">
                        @foreach ($carousels as $carousel)
                            <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="{{ $loop->index }}"
                                class="{{ $loop->first ? 'active' : '' }}"
                                aria-label="Slide {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                @endif
                <div class="carousel-inner">
                    @forelse ($carousels as $carousel)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="hero-slide"
                                style="--hero-image: url('{{ asset('storage/' . $carousel->gambar) }}');">
                                <div class="container">
                                    <div class="hero-copy">
                                        <p class="eyebrow">Beranda</p>
                                        <h1>{{ $carousel->judul }}</h1>
                                        <p class="lead">{{ $carousel->subjudul }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <div class="hero-slide">
                                <div class="container">
                                    <div class="hero-copy">
                                        <p class="eyebrow">KOMUNITAS UNTUK PERUBAHAN</p>
                                        <h1>Bergerak Bersama,<br /><span>Berdampak Nyata.</span></h1>
                                        <p class="lead">Kami percaya perubahan besar lahir dari langkah kecil yang
                                            dilakukan bersama.</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                    <span class="carousel-control-icon"><i class="bi bi-arrow-left"></i></span><span
                        class="visually-hidden">Sebelumnya</span></button><button class="carousel-control-next"
                    type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                    <span class="carousel-control-icon"><i class="bi bi-arrow-right"></i></span><span
                        class="visually-hidden">Berikutnya</span>
                </button>
            </div>
        </section>

        <section id="tentang" class="section-padding">
            <div class="container">
                <div class="row align-items-center g-5">

                    <div class="col-lg-6">
                        <div class="image-placeholder about-image">
                            <img src="{{ asset('assets/nextpremiere/169-logo.jpg') }}" alt="Foto kegiatan">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h2>
                            Tentang Komunitas<br /><span>Kami.</span>
                        </h2>
                        <p class="text-muted mt-4" style="text-align: justify;">
                            Next Play hadir untuk menyatukan para pecinta padel dalam lingkungan olahraga yang kompetitif,
                            suportif, dan penuh semangat. Kami menjadi wadah bagi pemain dan klub untuk saling terhubung,
                            mengembangkan kemampuan, serta merasakan pengalaman berkompetisi melalui berbagai liga dan
                            turnamen. Lebih dari sekadar pertandingan, Next Play ingin membangun ekosistem padel yang
                            mendorong sportivitas, kebersamaan, dan perkembangan prestasi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="event" class="section-padding">
            <div class="container">
                <div class="section-heading d-flex justify-content-between align-items-end mb-5">
                    <div>
                        <p class="eyebrow">EVENT TERKINI</p>
                        <h2>Event <span>Terbaru.</span></h2>
                    </div>
                    <a href="{{ route('events') }}" class="link-green">Lihat semua event <i
                            class="bi bi-arrow-right"></i></a>
                </div>
                <div class="row g-4">
                    @foreach ($events as $event)
                        <div class="col-lg-4">
                            <article class="news-card">
                                <div class="image-placeholder news-image">
                                    @if ($event->gambar)
                                        <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->judul }}">
                                    @else
                                        <img src="{{ asset('assets/nextpremiere/169-logo.jpg') }}"
                                            alt="{{ $event->judul }}">
                                    @endif
                                </div>
                                <div class="news-body">
                                    <small>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }} ·
                                        EVENT</small>
                                    <h3>{{ $event->judul }}</h3>
                                    <a href="{{ route('events.show', $event) }}" aria-label="Baca event">Baca
                                        selengkapnya
                                        <i class="bi bi-arrow-up-right"></i></a>
                                </div>
                            </article>
                        </div>
                    @endforeach

                    @for ($placeholderIndex = $events->count(); $placeholderIndex < 3; $placeholderIndex++)
                        <div class="col-lg-4">
                            <article class="news-card">
                                <div class="image-placeholder news-image">
                                    <img src="{{ asset('assets/nextpremiere/169-logo.jpg') }}"
                                        alt="Event berikutnya akan hadir">
                                </div>
                                <div class="news-body">
                                    <small>SEGERA HADIR</small>
                                    <h3>Event baru akan ditambahkan</h3>
                                    <p>Informasi kegiatan berikutnya akan tampil di sini.</p>
                                </div>
                            </article>
                        </div>
                    @endfor
                </div>
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
    </main>
@endsection

@section('scripts')
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
