@extends('layouts.app')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
<section id="stats" class="stats section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-8">
                <section>
                    <div class="container">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Slide 1">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Slide 2">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Slide 3">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-4">
                <section>
                    <div class="container">
                        <div class="card">
                            <div class="card-header text-center fs-5 text-uppercase">
                                <b>JADWAL LAPANGAN BUMI SARIWANGI</b>
                            </div>
                            <div class="card-body">
                                <form id="booking-form" action="{{ route('admin.bookings.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="booking-date" class="form-label">Tanggal Booking</label>
                                        <input type="date" class="form-control" id="booking-date" name="tanggal_pemesanan" required>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="field-id" class="form-label">Lapang</label>
                                        <select id="field-id" class="form-control" name="field_id" required>">
                                            <option value="">Pilih Lapang</option>
                                            @foreach ($fields as $data)
                                                <option value="{{ $data->id }}" data-price="{{ $data->harga_perjam }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="schedule-id" class="form-label">Jam</label>
                                        <select id="schedule-id" class="form-control" name="schedule_id" required>
                                            <option value="">Pilih Jam</option>
                                            @foreach ($schedules as $data)
                                                <option value="{{ $data->id }}">{{ $data->start_time }} - {{ $data->end_time }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="total-harga" class="form-label">Harga</label>
                                        <input type="text" id="total-harga" class="form-control" name="total_harga" readonly required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">BOOK NOW</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
    document.getElementById('pay-button').addEventListener('click', function (e) {
        e.preventDefault();

        const tanggal = document.getElementById('booking-date').value;
        const waktu = document.getElementById('booking-time').value;

        if (!tanggal || !waktu) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Silakan isi tanggal dan waktu terlebih dahulu.'
            });
            return;
        }

        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

        if (!isLoggedIn) {
            Swal.fire({
                icon: 'warning',
                title: 'Harus Login!',
                text: 'Silakan login terlebih dahulu untuk melakukan booking.',
                confirmButtonText: 'Login Sekarang'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
            return;
        }

        fetch("{{ url('/get-snap-token') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                tanggal: tanggal,
                waktu: waktu
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.snapToken) {
                throw new Error("Snap token tidak ditemukan");
            }

            window.snap.pay(data.snapToken, {
                onSuccess: function(result){
                    Swal.fire('Pembayaran Berhasil!', 'Terima kasih, booking Anda berhasil.', 'success');
                    console.log(result);
                },
                onPending: function(result){
                    Swal.fire('Menunggu Pembayaran', 'Silakan selesaikan pembayaran Anda.', 'info');
                    console.log(result);
                },
                onError: function(result){
                    Swal.fire('Pembayaran Gagal', 'Silakan coba lagi atau hubungi admin.', 'error');
                    console.log(result);
                },
                onClose: function(){
                    Swal.fire('Pembayaran Belum Selesai', 'Kamu menutup pembayaran sebelum selesai.', 'question');
                }
            });
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal memproses permintaan.'
            });
        });
    });
    // Update harga otomatis saat lapang dipilih
    document.getElementById('field-id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        document.getElementById('total-harga').value = price ? 'Rp ' + parseInt(price).toLocaleString() : '';
    });
</script>
@endpush
