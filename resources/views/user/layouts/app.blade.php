<!doctype html>
<html lang="id">

@include('user.layouts.partials.header')

<body>

    @include('user.layouts.partials.navbar')

    <main class="site-main">
        @yield('content')
    </main>

    @include('user.layouts.partials.footer')

    <script>
        const siteNav = document.querySelector('.site-nav');

        if (siteNav) {
            const updateSiteNavHeight = () => {
                document.documentElement.style.setProperty('--site-nav-height', `${siteNav.offsetHeight}px`);
            };

            updateSiteNavHeight();
            new ResizeObserver(updateSiteNavHeight).observe(siteNav);
        }
    </script>
    <script>
        document.getElementById('copyright').textContent =
            `© ${new Date().getFullYear()} Next Play. All rights reserved.`;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
    </script>
    <script src='{{ asset('/costum/script.js') }}'></script>
    @yield('scripts')
</body>

</html>
