<!DOCTYPE html>
<html>
<head>
    <title>grievance</title>
</head>
<body>
    <p>Dear Admin, </br></br>
        You got a new grievance  from accredetation portal
    </p>
    <p style="font-weight: bold; text-decoration:underline">Concern Related To:</p>
    <p>{{ $details['title'] }}</p>
    <p></p>
    <p></p>
    <p style="font-weight: bold; text-decoration:underline">Content:</p>
    <p>{!! $details['body'] !!}</p>
</br></br></br>
    <p>Thank you,</p>
    <p>Accredetation Team</p>

</body>
</html>
