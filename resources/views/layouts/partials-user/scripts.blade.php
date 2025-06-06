<!-- Core JS -->
<!-- build:js hr-app/assets/vendor/js/core.js -->
<script src="{{ asset('hr-app/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('hr-app/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('hr-app/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('hr-app/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('hr-app/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('hr-app/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('hr-app/assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('hr-app/assets/js/dashboards-analytics.js') }}"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Not Subscribed',
                    text: 'Subscription not available yet. Please contact admin.',
                    confirmButtonColor: '#3085d6'
                });
            });
        });
    });
</script>

<script>
    // Show loader on all form submits
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('global-loader');

        // Show on any form submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                loader.style.display = 'flex';
            });
        });

        // Show on any link with .nav-link or .ajax-load
        document.querySelectorAll('a.nav-link, a.ajax-load').forEach(link => {
            link.addEventListener('click', (e) => {
                // Optional: skip if link has target _blank
                if (link.target !== '_blank') {
                    loader.style.display = 'flex';
                }
            });
        });

        // Hide loader on page load
        window.addEventListener('load', () => {
            loader.style.display = 'none';
        });
    });
</script>

@stack('scripts')