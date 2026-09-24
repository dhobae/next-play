<style>
    .sidebar-wrapper .sidebar-menu>.nav-item>.nav-treeview {
        margin-left: 1rem;
        width: calc(100% - 1rem);
        padding-left: 0.35rem;
    }
</style>

<div class="sidebar-wrapper">
    <nav class="mt-2" aria-label="Main navigation">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">
            <li class="nav-item"><a href="{{ route('home') }}"
                    class="nav-link {{ Request::is('admin/beranda') ? 'active' : '' }}"><i
                        class="nav-icon bi bi-speedometer2"></i>
                    <p>Dashboard Admin</p>
                </a></li>
            <li class="nav-header">Manajemen Tampilan Utama</li>
            <li
                class="nav-item {{ Request::is('admin/carousel*') || Request::is('admin/sponsor*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link"><i class="nav-icon bi bi-house-door"></i>
                    <p>Beranda<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('admin.carousel.index') }}"
                            class="nav-link {{ Request::is('admin/carousel*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-images"></i>
                            <p>Hero Carousel</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('admin.sponsor.index') }}"
                            class="nav-link {{ Request::is('admin/sponsor*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-award"></i>
                            <p>Sponsor</p>
                        </a></li>
                </ul>
            </li>
            <li
                class="nav-item {{ Request::is('admin/herottgkami*') || Request::is('admin/visimisi*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link"><i class="nav-icon bi bi-info-circle"></i>
                    <p>Tentang Kami<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('admin.hero.index') }}"
                            class="nav-link {{ Request::is('admin/herottgkami*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-image"></i>
                            <p>Hero Tentang Kami</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('admin.visimisi.index') }}"
                            class="nav-link {{ Request::is('admin/visimisi*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-bullseye"></i>
                            <p>Visi & Misi</p>
                        </a></li>
                </ul>
            </li>
            <li
                class="nav-item {{ Request::is('admin/heroevent*') || Request::is('admin/eventacara*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link"><i class="nav-icon bi bi-calendar-event"></i>
                    <p>Event<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('admin.heroevent.index') }}"
                            class="nav-link {{ Request::is('admin/heroevent*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-image"></i>
                            <p>Hero Event</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('admin.eventacara.index') }}"
                            class="nav-link {{ Request::is('admin/eventacara*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-calendar2-event"></i>
                            <p>Event Acara</p>
                        </a></li>
                </ul>
            </li>
            <li
                class="nav-item {{ Request::is('admin/heroatlet*') || Request::is('admin/atlet*') || Request::is('admin/atlet-riwayat*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link"><i class="nav-icon bi bi-trophy"></i>
                    <p>Peringkat<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('admin.heroatlet.index') }}"
                            class="nav-link {{ Request::is('admin/heroatlet*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-bar-chart-line"></i>
                            <p>Hero</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('admin.atlet.index') }}"
                            class="nav-link {{ Request::is('admin/atlet') || Request::is('admin/atlet/*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-person-badge"></i>
                            <p>Atlet</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('admin.atlet-riwayat.index') }}"
                            class="nav-link {{ Request::is('admin/atlet-riwayat*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-trophy-fill"></i>
                            <p>Riwayat Turnamen</p>
                        </a></li>

                </ul>
            </li>
            <li class="nav-item {{ Request::is('admin/klub*') || Request::is('admin/season*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link"><i class="nav-icon bi bi-clock-history"></i>
                    <p>History<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('admin.klub.index') }}"
                            class="nav-link {{ Request::is('admin/klub*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-building"></i>
                            <p>Klub</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('admin.season.index') }}"
                            class="nav-link {{ Request::is('admin/season*') ? 'active' : '' }}"><i
                                class="nav-icon bi bi-calendar3"></i>
                            <p>Season</p>
                        </a></li>
                </ul>
            </li>
            <li class="nav-item"><a href="{{ route('admin.hubungikami.index') }}"
                    class="nav-link {{ Request::is('admin/hubungikami*') ? 'active' : '' }}"><i
                        class="nav-icon bi bi-envelope"></i>
                    <p>Hubungi Kami</p>
                </a></li>
            {{-- <li class="nav-item"><a href="{{ route('admin.hubungikami.index') }}"
                    class="nav-link {{ Request::is('admin/header*') ? 'active' : '' }}"><i
                        class="nav-icon bi bi-layout-text-window-reverse"></i>
                    <p>Header</p>
                </a></li>
            <li class="nav-item"><a href="{{ route('admin.hubungikami.index') }}"
                    class="nav-link {{ Request::is('admin/footer*') ? 'active' : '' }}"><i
                        class="nav-icon bi bi-layout-text-window"></i>
                    <p>Footer</p>
                </a></li> --}}
            <li class="nav-header">Manajemen Akun</li>
            <li class="nav-item"><a href="{{ route('admin.profile.index') }}"
                    class="nav-link {{ Request::is('admin/profil*') ? 'active' : '' }}"><i
                        class="nav-icon bi bi-person-circle"></i>
                    <p>Profil</p>
                </a></li>
        </ul>
    </nav>
</div>
