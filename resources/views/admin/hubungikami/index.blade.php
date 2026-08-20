@extends('admin.layouts.app')

@section('content')
    @php
        $hasHubungiKami = isset($hubungiKami);
        $isEditable = !$hasHubungiKami || $errors->any();
    @endphp

    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Hubungi Kami</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ $hasHubungiKami ? route('admin.hubungikami.update', $hubungiKami->id) : route('admin.hubungikami.store') }}"
                    method="POST">
                    @csrf
                    @if ($hasHubungiKami)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="link_wa" class="form-label">Link WhatsApp</label>
                        <input type="url" name="link_wa" id="link_wa" class="form-control"
                            value="{{ old('link_wa', $hubungiKami->link_wa ?? '') }}"
                            placeholder="https://wa.me/628xxxxxxxxxx" {{ $isEditable ? '' : 'disabled' }} required>
                        <small class="text-muted">Masukkan link WhatsApp yang akan digunakan pengunjung.</small>
                        @error('link_wa')
                            <small class="d-block text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @if ($hasHubungiKami)
                        <button type="button" class="btn btn-warning btn-sm" id="editHubungiKami">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm" id="saveHubungiKami" {{ $isEditable ? '' : 'disabled' }}>
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($hasHubungiKami)
        <script>
            document.getElementById('editHubungiKami').addEventListener('click', function() {
                document.getElementById('link_wa').disabled = false;
                document.getElementById('saveHubungiKami').disabled = false;
                document.getElementById('link_wa').focus();
                this.disabled = true;
            });
        </script>
    @endif
@endsection
