<!DOCTYPE html>
<html>
<head>
    <title>RAV ATAB - Assigned Application Successfully</title>
</head>
<body>
    <h1>{{ $assessorapplicationMail['title'] }}</h1>
    <p>{{ $assessorapplicationMail['body'] }}</p>
    <p>  Application Number : RAVAP-{{(4000+$application_id)}}  </p>
    
</body>
</html>
