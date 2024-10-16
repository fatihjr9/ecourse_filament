<!-- resources/views/pages/payment.blade.php -->

@extends('layouts.index')

@section('content')
<div>
    <h2>Payment</h2>
    <p>Total Amount: {{ $totalAmount }}</p>
    <script src="https://sandbox.app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        snap.pay("{{ $snapToken }}", {
            onSuccess: function(result) {
                console.log(result);
                // Handle successful transaction
            },
            onPending: function(result) {
                console.log(result);
                // Handle pending transaction
            },
            onError: function(result) {
                console.log(result);
                // Handle error
            }
        });
    </script>
</div>
@endsection
