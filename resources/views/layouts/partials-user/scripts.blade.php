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

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



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

<script>
$(document).ready(function() {
    // Custom order for status column:
    $.fn.dataTable.ext.order['dom-text-status'] = function(settings, col) {
        return this.api().column(col, {order:'index'}).nodes().map(function(td, i) {
            // Map status text to a numeric value for sorting
            var statusText = $(td).text().toLowerCase().trim();
            switch(statusText) {
                case 'pending': return 1;
                case 'approved': return 2;
                case 'rejected': return 3;
                default: return 4;
            }
        });
    };

    $('.table').DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "searching": true,
        // Use custom ordering for the Status column (index 7)
        "columnDefs": [
            {
                "targets": 7,
                "orderDataType": "dom-text-status"
            }
        ],
        "order": [[7, "asc"]] // default sort by status ascending (pending first)
    });
});
</script>



@stack('scripts')