<!DOCTYPE html>
<html>
<head>
    <title>RAV ATAB - payment Success</title>
</head>
<body>
    <h1>{{ $paymentMail['title'] }}</h1>
    <p>{{ $paymentMail['body'] }}</p>
    <p>  Application Number : RAVAP-{{(4000+$paymentid)}}  </p>
    <p> Training Provider : {{ $userid }}</p>
    <p>Application Type: {{ $paymentMail['type'] }}</p>
</body>
</html>
