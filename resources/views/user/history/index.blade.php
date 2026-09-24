@extends('user.layouts.app')

@section('content')
    <section class="section-padding ranking-section history-ranking-section">
        <div class="container">
            <div id="history-season-list">
                @include('user.history.partials.season-card', ['seasons' => $seasons])
            </div>
            @if ($seasons->isEmpty())
                <div class="ranking-panel">
                    <p class="empty-history mb-0">Belum ada history season.</p>
                </div>
            @endif
            @if ($hasMoreSeasons)
                <div class="text-center mt-2" id="history-load-more-wrap">
                    <button type="button" class="history-load-more" id="history-load-more" data-next-page="2">
                        <i class="fa-solid fa-plus me-1"></i> Load More
                    </button>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/dataTables.bootstrap5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('history-season-list');
            const loadMoreWrap = document.getElementById('history-load-more-wrap');
            const loadMoreButton = document.getElementById('history-load-more');

            function initializeTables() {
                $('.history-table').each(function() {
                    const table = $(this);
                    if ($.fn.DataTable.isDataTable(this) || !table.find('tr[data-detail-url]').length) {
                        return;
                    }

                    table.DataTable({
                        searching: true,
                        lengthMenu: [10, 25, 50],
                        pageLength: 10,
                        order: [],
                        language: {
                            search: 'Cari klub:',
                            lengthMenu: 'Tampilkan _MENU_ data',
                            info: 'Menampilkan _START_-_END_ dari _TOTAL_ klub',
                            infoEmpty: 'Belum ada club',
                            zeroRecords: 'Club tidak ditemukan',
                            paginate: {
                                previous: '‹',
                                next: '›'
                            }
                        },
                        columnDefs: [{
                            targets: 0,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        }]
                    });
                });
            }

            initializeTables();

            list.addEventListener('click', function(event) {
                const row = event.target.closest('tr[data-detail-url]');
                if (!row) return;

                const url = row.dataset.detailUrl;
                if (url) window.location.href = url;
            });

            loadMoreButton?.addEventListener('click', async function() {
                const nextPage = Number(loadMoreButton.dataset.nextPage);
                loadMoreButton.disabled = true;
                loadMoreButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Memuat...';

                try {
                    const response = await fetch(`{{ route('history.load-more') }}?page=${nextPage}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!response.ok) throw new Error('Gagal memuat history.');

                    const result = await response.json();
                    list.insertAdjacentHTML('beforeend', result.html);
                    initializeTables();

                    if (result.has_more) {
                        loadMoreButton.dataset.nextPage = nextPage + 1;
                        loadMoreButton.disabled = false;
                        loadMoreButton.innerHTML = '<i class="fa-solid fa-plus me-1"></i> Load More';
                    } else {
                        loadMoreWrap.remove();
                    }
                } catch (error) {
                    loadMoreButton.disabled = false;
                    loadMoreButton.innerHTML = '<i class="fa-solid fa-plus me-1"></i> Coba Lagi';
                }
            });
        });
    </script>
@endsection
