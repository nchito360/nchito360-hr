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
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('global-loader');

        // ✅ Only show loader on forms that POST or redirect to another page
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                // Prevent loader for forms targeting modals or dropdowns
                const target = e.target.getAttribute('target');
                if (!target || target === '_self') {
                    loader.style.display = 'flex';
                }
            });
        });

        // ✅ Axios request loader (if you use Axios)
        if (window.axios) {
            axios.interceptors.request.use(config => {
                loader.style.display = 'flex';
                return config;
            }, error => {
                loader.style.display = 'none';
                return Promise.reject(error);
            });

            axios.interceptors.response.use(response => {
                loader.style.display = 'none';
                return response;
            }, error => {
                loader.style.display = 'none';
                return Promise.reject(error);
            });
        }

        // ✅ Hide loader when navigating back
        window.addEventListener('pageshow', () => {
            loader.style.display = 'none';
        });
    });
</script>


@stack('scripts')