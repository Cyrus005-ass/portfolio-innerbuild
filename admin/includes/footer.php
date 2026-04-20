    </main>

    <script>
    (function () {
        const sidebar = document.getElementById('adminSidebar');
        const toggle = document.getElementById('sidebarToggle');
        const nav = document.getElementById('adminNav');

        if (!sidebar || !toggle || !nav) return;

        toggle.addEventListener('click', function () {
            const isOpen = sidebar.classList.toggle('nav-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            toggle.textContent = isOpen ? '\u00D7' : '\u2630';
        });

        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 980) {
                    sidebar.classList.remove('nav-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.textContent = '\u2630';
                }
            });
        });
    })();
    </script>
</body>
</html>
