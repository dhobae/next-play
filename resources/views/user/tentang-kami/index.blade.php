@extends('user.layouts.app')

@section('content')
    <section class="inner-hero"
        @if ($hero?->gambar) style="--inner-hero-image: url('{{ asset('storage/' . $hero->gambar) }}');" @endif>
        <div class="container">
            <p class="eyebrow">Tentang Kami</p>
            <h1>{{ $hero?->judul ?? 'JUDUL TENTANG KAMI' }}</h1>
            <p>{{ $hero?->subjudul ?? '' }}
            </p>
        </div>
    </section>

    {{-- <section class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <p class="eyebrow">CERITA KAMI</p>
                    <h2>
                        Berawal dari kepedulian,<br /><span>tumbuh menjadi gerakan.</span>
                    </h2>
                    <p class="text-muted mt-4">
                        Karya Bersama hadir dari keyakinan sederhana
                        bahwa setiap orang memiliki daya untuk memberi
                        dampak. Sejak awal, kami membangun ruang
                        kolaborasi yang terbuka untuk siapa saja.
                    </p>
                    <p class="text-muted">
                        Melalui program sosial, pendidikan, dan
                        pemberdayaan, kami berjalan bersama masyarakat
                        untuk menciptakan perubahan yang relevan dan
                        berkelanjutan.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="image-placeholder about-page-image">
                        <i class="bi bi-image"></i><span>Placeholder foto tentang kami</span>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="section-padding section-light">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <p class="eyebrow">ARAH PERJALANAN</p>
                    <h2>Visi & <span>Misi.</span></h2>
                    <div class="vision-item mt-4">
                        <span class="vision-icon"><i class="bi bi-eye"></i></span>
                        <div>
                            <h3>Visi</h3>
                            <div class="vision-rich-text">
                                {!! $visimisi?->visi ??
                                    '<p>Menjadi gerakan kolaboratif yang menghadirkan masyarakat inklusif, berdaya, dan berkelanjutan.</p>' !!}
                            </div>
                        </div>
                    </div>
                    <div class="vision-item">
                        <span class="vision-icon"><i class="bi bi-bullseye"></i></span>
                        <div>
                            <h3>Misi</h3>
                            <div class="vision-rich-text">
                                {!! $visimisi?->misi ??
                                    '<p>Menghubungkan potensi, mengembangkan kapasitas, dan menggerakkan aksi bersama yang berdampak nyata.</p>' !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="about-page-image">
                        @if ($visimisi?->gambar)
                            <img src="{{ asset('storage/' . $visimisi->gambar) }}" alt="Visi dan Misi"
                                class="about-page-image-img">
                        @else
                            <div class="image-placeholder h-100">
                                <i class="bi bi-image"></i><span>Placeholder foto visi dan misi</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <p class="eyebrow">TENTANG PBPI</p>
                    <h2>Mengenal <span>PBPI.</span></h2>
                    <p class="text-muted mt-4" style="text-align: justify">
                        Olahraga padel merupakan cabang olahraga raket yang semakin berkembang pesat di dunia, termasuk di
                        Indonesia. Padel dimainkan secara berpasangan di lapangan berdinding, mengombinasikan unsur
                        permainan tenis dan squash, sehingga menghadirkan dinamika permainan yang cepat, menarik, dan mudah
                        dipelajari oleh berbagai kalangan. Keunikan padel terletak pada penggunaan dinding sebagai bagian
                        dari permainan, yang menuntut strategi, ketepatan, serta kerja sama tim yang baik. Selain itu, padel
                        dikenal sebagai olahraga yang inklusif karena dapat dimainkan oleh berbagai usia, mulai dari pemula
                        hingga atlet profesional.
                    </p>
                    <p class="text-muted" style="text-align: justify">
                        Di Indonesia, khususnya di Kalimantan Selatan, perkembangan olahraga padel menunjukkan tren yang
                        positif dengan semakin bertambahnya venue, komunitas, dan minat masyarakat. Hal ini menjadi peluang
                        besar dalam pembinaan dan pengembangan atlet, terutama pada kelompok usia dini dan remaja. Dengan
                        dukungan organisasi, pelatih, serta kolaborasi antar komunitas, padel tidak hanya menjadi sarana
                        rekreasi, tetapi juga berpotensi melahirkan atlet-atlet berprestasi yang mampu bersaing di tingkat
                        nasional maupun internasional.
                    </p>
                    {{-- <a class="link-green" href="#lokasi">Pelajari lebih lanjut
                        <i class="bi bi-arrow-right"></i></a> --}}
                </div>
                <div class="col-lg-6">
                    <div class="image-placeholder about-page-image">
                        <i class="bi bi-image"></i><span>Placeholder foto PBPI</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding section-dark">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <p class="eyebrow">IDENTITAS KAMI</p>
                    <h2 class="text-white">Siapa <span>Kami?</span></h2>
                    <p class="dark-copy mt-4" style="text-align: justify">
                        Pengurus Provinsi Perkumpulan Besar Padel Indonesia (PBPI) Kalimantan Selatan merupakan struktur
                        organisasi yang dibentuk sebagai wadah pembinaan, pengembangan, dan pengelolaan olahraga padel di
                        tingkat daerah. epengurusan PBPI Kalimantan Selatan dipimpin oleh Ketua: Handi Erfani, didampingi
                        oleh Wakil Ketua: Yogi Nugraha, Sekretaris: Muhammad Habibie dan Bendahara: Ari Tri Fitrianto.
                        Kepengurusan ini didukung bidang pembinaan prestasi, organisasi, kompetisi, serta hubungan
                        masyarakat yang bekerja secara sinergis dalam menjalankan program kerja.
                    </p>
                    <p class="dark-copy mt-4" style="text-align: justify">Dengan komitmen profesionalisme dan kolaborasi, PBPI Kalimantan Selatan
                        berperan aktif dalam membangun sistem pembinaan atlet yang terarah, menyelenggarakan kompetisi yang
                        berkelanjutan, serta memperkuat jaringan dengan berbagai pihak. Melalui kepengurusan yang solid,
                        PBPI Kalimantan Selatan diharapkan mampu mendorong kemajuan olahraga padel dan mencetak atlet
                        berprestasi di tingkat nasional maupun internasional.</p>
                    {{-- <div class="row g-3 mt-3">
                        <div class="col-6">
                            <div class="mini-stat">
                                <strong>25K+</strong><span>Penerima manfaat</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mini-stat">
                                <strong>18</strong><span>Mitra kolaborasi</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="image-placeholder about-page-image image-placeholder-dark">
                        <i class="bi bi-image"></i><span>Placeholder foto siapa kami</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pengurus" class="section-padding">
        <div class="container">
            <div class="section-heading mb-5">
                <p class="eyebrow">Kenali tim pengurus yang mengelola organisasi kami</p>
                <h2>Struktur <span>Pengurus.</span></h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <article class="person-card person-card-light">
                        <div class="image-placeholder person-image">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="person-info">
                            <h3>Ahmad Pratama</h3>
                            <p>Ketua Umum</p>
                            <span>01</span>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-3">
                    <article class="person-card person-card-light">
                        <div class="image-placeholder person-image">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="person-info">
                            <h3>Siti Rahma</h3>
                            <p>Sekretaris</p>
                            <span>02</span>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-3">
                    <article class="person-card person-card-light">
                        <div class="image-placeholder person-image">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="person-info">
                            <h3>Bagas Wicaksono</h3>
                            <p>Bendahara</p>
                            <span>03</span>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-3">
                    <article class="person-card person-card-light">
                        <div class="image-placeholder person-image">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="person-info">
                            <h3>Nadia Lestari</h3>
                            <p>Koordinator Program</p>
                            <span>04</span>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section id="lokasi" class="section-padding section-light">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <p class="eyebrow">KUNJUNGI KAMI</p>
                    <h2>Lokasi & <span>Alamat.</span></h2>
                    <p class="text-muted mt-4">
                        Kami berlokasi di Kalimantan Selatan, pusat kegiatan padel.
                    </p>
                    <div class="address-list mt-4">
                        <p>
                            <i class="bi bi-geo-alt-fill"></i><span>Jalan Sukarelawan, Nomor 62, Kelurahan Komet,<br />Kota Banjarbaru, Kalimantan Selatan</span>
                        </p>
                        <p>
                            <i class="bi bi-envelope-fill"></i><span>halo@karyabersama.id</span>
                        </p>
                        <p>
                            <i class="bi bi-telephone-fill"></i><span>+62 812 3456 7890</span>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="map-wrap">
                        <iframe title="Peta lokasi Karya Bersama"
                            src="https://www.google.com/maps?q=Jakarta%20Selatan&output=embed" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
