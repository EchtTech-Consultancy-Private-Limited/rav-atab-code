<!DOCTYPE html>
<html>
<head>
    <title>OTP for the ATAB Registration</title>
</head>
<body>
    <h1>OTP for the ATAB Registration</h1>
    <p>Dear Applicant,<br><br>

Your OTP is @if(isset($data['otp'])) {{ $data['otp'] }} @endif,<br><br>

Use this OTP to complete your registration procedure for Training Provider / Assessor. Validity of this OTP is 10 Minutes. Please do not share your OTP with anyone.
<br><br>
<b>Support Team,</b><br>
ATAB (Ayurveda Training Accreditation Board)</p>
</body>
</html>