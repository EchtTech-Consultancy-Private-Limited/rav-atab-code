<!DOCTYPE html>
<html>
<head>
    <title>RAV ATAB - Application Report Send Successfully</title>
</head>
<body>
    <h1>{{ $assessorToAdminSingle['title'] }}</h1>
 <!--    <p>Assessor Email {{ $assessorToAdminSingle['body'] }}</p> -->
    <p>Application Status {{ $assessorToAdminSingle['status'] }}</p>
    <p>  Application Number : RAVAP-{{(4000+$application_id)}}  </p>
    
</body>
</html>
