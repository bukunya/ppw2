<!DOCTYPE html>
<html>
<head>
    <title>Status Lamaran</title>
</head>
<body>
    <h2>Halo {{ $application->user->name }},</h2>
    <p>Status lamaran Anda untuk pekerjaan <b>{{ $application->job->title }}</b> di {{ $application->job->company }} telah diperbarui.</p>
    <p><strong>Status Baru: {{ $status }}</strong></p>
    @if($status === 'Accepted')
        <p>Selamat! Lamaran Anda telah diterima. Tim kami akan segera menghubungi Anda untuk langkah selanjutnya.</p>
    @elseif($status === 'Rejected')
        <p>Mohon maaf, lamaran Anda belum dapat diterima pada saat ini. Terima kasih atas minat Anda.</p>
    @else
        <p>Lamaran Anda masih dalam proses review.</p>
    @endif
    <br>
    <p>Salam,</p>
    <p><b>Tim {{ config('app.name') }}</b></p>
</body>
</html>