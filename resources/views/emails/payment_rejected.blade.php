<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Ditolak</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px;">
    
    <div style="max-w-xl; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border-top: 5px solid #dc3545; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #dc3545; margin-top: 0;">Halo, {{ $order->user->name }}!</h2>
        
        <p>Mohon maaf, konfirmasi pembayaran Anda untuk pre-order <strong>#{{ $order->id }}</strong> telah ditolak oleh Admin kami.</p>

        <div style="background-color: #fff5f5; padding: 15px; border-left: 4px solid #dc3545; margin: 20px 0;">
            <strong style="color: #dc3545;">Alasan Penolakan:</strong><br>
            <span style="font-size: 16px;">{{ $order->rejection_reason }}</span>
        </div>

        <p>Agar pre-order Anda dapat segera diproses, mohon untuk mengunggah ulang bukti transfer yang benar melalui tautan di bawah ini:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('order.detail', $order->id) }}" style="display: inline-block; padding: 12px 25px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">Upload Ulang Bukti Transfer</a>
        </div>

        <p style="margin-bottom: 0;">Terima kasih,<br><strong>Tim {{ config('app.name', 'Toko Kami') }}</strong></p>
    </div>

</body>
</html>
