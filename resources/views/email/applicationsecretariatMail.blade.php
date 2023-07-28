<!DOCTYPE html>
<html>
<head>
    <title>RAV ATAB - Application Received Successfully</title>
</head>
<body>
    <h1>{{ $applicationsecretariatMail['title'] }}</h1>
    <p>{{ $applicationsecretariatMail['body'] }}</p>
    <p>  Application Number : RAVAP-{{(4000+$application_id)}}  </p>
    
</body>
</html>
