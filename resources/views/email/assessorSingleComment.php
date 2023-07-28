<!DOCTYPE html>
<html>
<head>
    <title>RAV ATAB -  Application Report Send Successfully to Admin</title>
</head>
<body>
    <h1>{{ $assessorToSingleApplication['title'] }}</h1>
 <!--    <p>Assessor Email {{ $assessorToSingleApplication['body'] }}</p> -->
   <p>Application Status {{ $assessorToSingleApplication['status'] }}</p>
    <p>  Application Number : RAVAP-{{(4000+$application_id)}}  </p>
    
</body>
</html>
