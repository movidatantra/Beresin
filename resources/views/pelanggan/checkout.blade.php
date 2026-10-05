@extends('layouts.pelanggan')

@section('content')
<!-- CSS Leaflet & Plugin Autocomplete -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.11.0/dist/geosearch.css" />

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- TITLE -->
            <div class="mb-5 text-center text-lg-start">
                <h2 class="fw-bold text-dark mb-1">Checkout Pesanan</h2>
                <p class="text-muted small">Silakan lengkapi detail reservasi dan lokasi pengerjaan</p>
            </div>

            <div class="row g-4">
                <!-- FORM RESERVASI -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4 p-md-5">
                            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                                @csrf

                                <!-- Hidden Inputs -->
                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">
                                <input type="hidden" id="jam" name="jam" required>

                                <!-- TANGGAL -->
                                <div class="mb-4">
                                    <label for="jadwal" class="form-label fw-semibold text-secondary small text-uppercase mb-2">
                                        Tanggal Booking
                                    </label>
                                    <input 
                                        type="date" 
                                        id="jadwal" 
                                        name="jadwal" 
                                        class="form-control rounded-4 border-muted py-2.5 px-3 fs-6" 
                                        min="{{ date('Y-m-d') }}" 
                                        required>
                                </div>

                                <!-- JAM BOOKING -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase mb-2">
                                        Jam Booking
                                    </label>
                                    <div id="time-slots-container" class="row g-2">
                                        @if(count($slots) > 0)
                                            @foreach($slots as $slot)
                                                <div class="col-4 col-sm-3">
                                                    <button type="button" class="btn btn-outline-light w-100 py-2.5 rounded-3 slot-btn text-dark border fw-medium fs-6" data-time="{{ $slot }}">
                                                        {{ $slot }}
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12 text-center text-muted py-3 border border-dashed rounded-4">
                                                Silakan pilih tanggal terlebih dahulu untuk melihat jam tersedia.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- ALAMAT + GPS BUTTON -->
                                <div class="mb-4 position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-semibold text-secondary small text-uppercase mb-0">
                                            Alamat Lengkap
                                        </label>
                                        <button type="button" id="btn-gps" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 text-xs fw-medium d-flex align-items-center gap-1">
                                            <span>📍</span> <span id="gps-text">Gunakan Lokasi Saat Ini</span>
                                        </button>
                                    </div>
                                    
                                    <div id="search-box" class="mb-2">
                                        <input 
                                            type="text"
                                            id="address"
                                            name="address" 
                                            class="form-control rounded-4 border-muted p-3" 
                                            placeholder="Ketik alamat seperti di Gojek..." 
                                            autocomplete="off"
                                            required>
                                        <div id="autocomplete-results" class="list-group shadow-sm d-none position-absolute w-100 mt-1 rounded-3 text-sm"></div>
                                    </div>

                                    <div id="map-container" class="rounded-4 overflow-hidden shadow-sm d-none mb-3" style="height: 220px; width: 100%; z-index: 1;"></div>
                                </div>

                                <!-- CATATAN -->
                                <div class="mb-5">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase mb-2">
                                        Catatan Tambahan (Opsional)
                                    </label>
                                    <textarea 
                                        name="note" 
                                        class="form-control rounded-4 border-muted p-3" 
                                        rows="2" 
                                        placeholder="Contoh: Patokan rumah warna pagar hitam..."></textarea>
                                </div>

                                <!-- BUTTON SUBMIT -->
                                <button type="submit" id="btn-submit-checkout" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm custom-btn-submit">
                                    <span class="spinner-border spinner-border-sm d-none me-2" id="spinner-load" role="status" aria-hidden="true"></span>
                                    <span id="text-submit">Lanjut ke Pembayaran &rarr;</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- RINGKASAN PESANAN -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 bg-white position-sticky" style="top: 2rem;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 d-flex align-items-center">
                                <span>Ringkasan Pesanan</span>
                                <span class="badge bg-light text-primary rounded-pill ms-2 fs-6 fw-normal">{{ count($carts) }} Item</span>
                            </h5>
                            
                            <div class="cart-items-scroll custom-scrollbar mb-3" style="max-height: 280px; overflow-y: auto; padding-right: 5px;">
                                @foreach($carts as $cart)
                                <div class="d-flex align-items-start justify-content-between py-3 border-bottom border-light">
                                    <div class="me-3">
                                        <h6 class="mb-1 text-dark fw-medium" style="font-size: 0.95rem;">{{ $cart->service->name }}</h6>
                                        <small class="text-muted">Jumlah: {{ $cart->qty }}x</small>
                                    </div>
                                    <span class="fw-semibold text-dark text-nowrap" style="font-size: 0.95rem;">
                                        Rp {{ number_format($cart->service->price * $cart->qty, 0, ',', '.') }}
                                    </span>
                                </div>
                                @endforeach
                            </div>

                            @php
                                $biayaLayanan = 10000; 
                                $grandTotal = $total + $biayaLayanan;
                            @endphp

                            <div class="pt-2 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-secondary small">Subtotal Pesanan</span>
                                    <span class="fw-medium text-dark small">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-secondary small">Biaya Layanan</span>
                                    <span class="fw-medium text-dark small">Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-dark fw-bold">Total Pembayaran</span>
                                    <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.08);
    }
    #autocomplete-results {
        z-index: 2000;
        max-height: 200px;
        overflow-y: auto;
    }
    #autocomplete-results .list-group-item {
        cursor: pointer;
        font-size: 0.85rem;
    }
    #autocomplete-results .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .slot-btn {
        transition: all 0.2s ease;
        border-color: #dee2e6 !important;
        background-color: #fff;
    }
    .slot-btn:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd !important;
        color: #0d6efd !important;
    }
    .slot-btn.active {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.15);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map, marker;
let timeout = null;

$(document).ready(function() {

    $('#checkout-form').on('submit', function(e) {
        if(!$('#jam').val()) {
            alert('Silakan pilih jam booking terlebih dahulu.');
            e.preventDefault();
            return false;
        }
        $('#btn-submit-checkout').prop('disabled', true);
        $('#spinner-load').removeClass('d-none');
        $('#text-submit').text('Menyiapkan Pembayaran...');
    });

    $(document).on('click', '.slot-btn', function() {
        $('.slot-btn').removeClass('active');
        $(this).addClass('active');
        let selectedTime = $(this).data('time');
        $('#jam').val(selectedTime);
    });

    $('#jadwal').change(function(){
        let tanggal = $(this).val();
        $('#jam').val('');
        $('#time-slots-container').html('<div class="col-12 text-center text-muted py-3">Memuat jam tersedia...</div>');
        
        $.get('/available-slots', { tanggal: tanggal }, function(data){
            $('#time-slots-container').html('');

            if(data.status === 'offline'){
                $('#time-slots-container').append('<div class="col-12 text-center text-danger py-3 border border-dashed rounded-4">Mitra sedang offline</div>');
                return;
            }

            if(data.status === 'holiday'){
                $('#time-slots-container').append('<div class="col-12 text-center text-warning py-3 border border-dashed rounded-4">Hari tersebut adalah hari libur mitra</div>');
                return;
            }

            let slots = data.slots ? data.slots : (Array.isArray(data) ? data : []);

            if(slots.length === 0){
                $('#time-slots-container').append('<div class="col-12 text-center text-muted py-3 border border-dashed rounded-4">Tidak ada slot tersedia</div>');
                return;
            }

            slots.forEach(function(slot){
                let slotHtml = `
                    <div class="col-4 col-sm-3">
                        <button type="button" class="btn btn-outline-light w-100 py-2.5 rounded-3 slot-btn text-dark border fw-medium fs-6" data-time="${slot}">
                            ${slot}
                        </button>
                    </div>
                `;
                $('#time-slots-container').append(slotHtml);
            });
        }).fail(function() {
            $('#time-slots-container').html('<div class="col-12 text-center text-danger py-3 border border-dashed rounded-4">Gagal mengambil jadwal slot jam.</div>');
        });
    });

    $('#address').on('input', function() {
        clearTimeout(timeout);
        let query = $(this).val();
        
        if (query.length < 4) {
            $('#autocomplete-results').addClass('d-none');
            return;
        }

        timeout = setTimeout(function() {
            $.get(`https://nominatim.openstreetmap.org/search?format=json&countrycodes=id&limit=5&q=${encodeURIComponent(query)}`, function(data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(function(item) {
                        html += `<button type="button" class="list-group-item list-group-item-action item-alamat" 
                                    data-lat="${item.lat}" 
                                    data-lon="${item.lon}" 
                                    data-name="${item.display_name}">
                                    🏢 ${item.display_name}
                                 </button>`;
                    });
                    $('#autocomplete-results').html(html).removeClass('d-none');
                } else {
                    $('#autocomplete-results').addClass('d-none');
                }
            });
        }, 500);
    });

    $(document).on('click', '.item-alamat', function() {
        let namaAlamat = $(this).data('name');
        let lat = $(this).data('lat');
        let lon = $(this).data('lon');

        $('#address').val(namaAlamat);
        $('#latitude').val(lat);
        $('#longitude').val(lon);
        $('#autocomplete-results').addClass('d-none');

        updateLeafletMap(lat, lon);
    });

    function updateLeafletMap(lat, lon, popupText = null) {
        $('#map-container').removeClass('d-none');

        if (!map) {
            map = L.map('map-container').setView([lat, lon], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([lat, lon], { draggable: true }).addTo(map);

            marker.on('dragend', function() {
                let position = marker.getLatLng();
                $('#latitude').val(position.lat);
                $('#longitude').val(position.lng);
                $('#address').val(position.lat + ', ' + position.lng);
            });
        } else {
            map.setView([lat, lon], 16);
            marker.setLatLng([lat, lon]);
        }

        if (popupText) {
            marker.bindPopup(popupText).openPopup();
        } else {
            marker.unbindPopup();
        }
        
        setTimeout(() => { map.invalidateSize(); }, 200);
    }

    $('#btn-gps').click(function() {
        if (navigator.geolocation) {
            $('#gps-text').text('Mencari lokasi...');
            $('#btn-gps').prop('disabled', true);

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let lat = position.coords.latitude;
                    let lon = position.coords.longitude;

                    $('#latitude').val(lat);
                    $('#longitude').val(lon);

                    updateLeafletMap(lat, lon, "<b>📍 Lokasi Anda Sekarang</b>");

                    $('#gps-text').text('Lokasi Ditemukan!');
                    setTimeout(resetGpsButton, 2000);
                },
                function() {
                    alert('Gagal mendapatkan GPS. Pastikan izin lokasi aktif.');
                    resetGpsButton();
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    });

    function resetGpsButton() {
        $('#gps-text').text('Gunakan Lokasi Saat Ini');
        $('#btn-gps').prop('disabled', false);
    }

    $(document).click(function(e) {
        if (!$(e.target).closest('#search-box').length) {
            $('#autocomplete-results').addClass('d-none');
        }
    });
});
</script>
@endsection