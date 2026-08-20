 <nav class="navbar navbar-expand-lg fixed-top site-nav" aria-label="Navigasi utama">
     <div class="container">
         <a class="navbar-brand d-flex align-items-center gap-2" href="/">
             <span class="brand-mark">
                 <img class="img-fluid" src="{{ asset('assets/nextpremiere/logo.png') }}" alt="LOGO" />
             </span>
             <span>NEXT<span> PREMIERE</span></span>
         </a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
             aria-label="Buka menu">
             <i class="bi bi-list"></i>
         </button>
         <div class="collapse navbar-collapse" id="navMenu">
             <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}"
                         href="{{ route('beranda') }}"
                         @if (request()->routeIs('beranda')) aria-current="page" @endif>Beranda</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('tentangkami') ? 'active' : '' }}"
                         href="{{ route('tentangkami') }}"
                         @if (request()->routeIs('tentangkami')) aria-current="page" @endif>Tentang Kami</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('events*') ? 'active' : '' }}"
                         href="{{ route('events') }}"
                         @if (request()->routeIs('events*')) aria-current="page" @endif>Event</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('atlets*') ? 'active' : '' }}"
                         href="{{ route('atlets') }}"
                         @if (request()->routeIs('atlets*')) aria-current="page" @endif>Peringkat</a>
                 </li>
                 <li class="nav-item">
                     @php
                         use App\Models\HubungiKami;
                         $data = HubungiKami::first();
                     @endphp
                     <a class="btn btn-green ms-lg-3" href="{{ !empty($data?->link_wa) ? $data->link_wa : '#' }}"
                         target="_blank">
                         Hubungi Kami
                         <i class="bi bi-arrow-up-right ms-1"></i>
                     </a>
                 </li>
             </ul>
         </div>
     </div>

 </nav>
