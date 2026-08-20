@if (session('success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: "{{ session('success') }}",
                timer: 1500,
                showConfirmButton: false
            });
        });
    </script>
@endif

{{-- @if (session('success2'))
    <script>
        Toastify({
            text: "{{ session('success2') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: "#4fbe87",
        }).showToast();
    </script>
@endif --}}