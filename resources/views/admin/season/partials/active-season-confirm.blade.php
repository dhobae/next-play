<script>
    document.querySelectorAll('[data-season-form]').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const activeSeason = form.dataset.activeSeason;
            const activeInput = form.querySelector('[name="aktif"]');
            const replaceInput = form.querySelector('[name="ganti_season"]');

            if (!activeSeason || !activeInput.checked || replaceInput.value === '1') {
                return;
            }

            event.preventDefault();
            Swal.fire({
                title: 'Season lain sedang aktif',
                text: 'Season ' + activeSeason +
                    ' sedang aktif, tekan Ganti jika ingin mengganti yang sedang aktif.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ganti',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0d6efd'
            }).then(function(result) {
                if (result.isConfirmed) {
                    replaceInput.value = '1';
                    form.submit();
                }
            });
        });
    });
</script>
