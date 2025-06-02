@extends('layouts.app') {{-- Atau layout Anda --}}

@section('title', 'Proses Pembayaran')

@section('content')
<div class="container text-center py-5">
    <h4>Mohon Tunggu, Memproses Pembayaran Anda...</h4>
    <p>Order ID: {{ $transaksi->id }}</p>
    <p>Total: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>

    <button id="pay-button" class="btn btn-primary">Bayar Sekarang!</button>

    {{-- Jangan lupa tambahkan CSRF token jika perlu --}}
    <form id="payment-form" action="" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="json" id="json_callback">
    </form>
</div>

{{-- Script Midtrans Snap.js --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
  // Ambil tombol bayar
  var payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', function () {
    // Panggil snap.pay() dengan Snap Token
    window.snap.pay('{{ $snapToken }}', {
      onSuccess: function(result){
        /* Anda bisa menangani sukses di sini atau menunggu notifikasi webhook */
        console.log(result);
        alert("Pembayaran berhasil!");
        // Redirect ke halaman status atau dashboard
        window.location.href = '/'; // Ganti dengan halaman sukses
      },
      onPending: function(result){
        /* Tangani jika pembayaran pending */
        console.log(result);
        alert("Pembayaran Anda sedang diproses.");
        window.location.href = '/'; // Ganti dengan halaman status
      },
      onError: function(result){
        /* Tangani jika ada error */
        console.log(result);
        alert("Pembayaran gagal!");
      },
      onClose: function(){
        /* Tangani jika popup ditutup sebelum bayar */
        alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
      }
    });
  });

  // Panggil klik otomatis saat halaman dimuat (opsional)
  document.addEventListener("DOMContentLoaded", function() {
     payButton.click();
  });
</script>
@endsection