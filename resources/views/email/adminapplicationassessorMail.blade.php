<!DOCTYPE html>
<html>
<head>
    <title>RAV ATAB - Application Send Successfully</title>
</head>
<body>
    <h1>{{ $adminapplicationsecretariatMail['title'] }}</h1>
    <p>Assessor Email {!! $adminapplicationsecretariatMail['body'] !!}</p>
    <p>  Application Number : RAVAP-{{(4000+$application_id)}}  </p>
    <p>Application Status: {{ $adminapplicationsecretariatMail['type'] }}</p>
    
</body>
</html>
