<!DOCTYPE htm1>
<html>
<head>
<title>Lamaran Diterima</title>
</head>
<body>
<h2>Halo {{ $user->name }},</h2>
<p>Terima kasih telah melamar pekerjaan <b>{{
$job->title }}</b> di {{ $job->company }}.</p>
<p>Lamaran Anda telah kami terima dan sedang diproses
oleh tim HR kami.</p>
<br>
<p>Salam,</p>
<p><b>Tim {{ config('app.name') }}</b></p>
</body>
</html>