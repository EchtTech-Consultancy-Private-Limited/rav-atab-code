<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome Email</title>
    <link rel="stylesheet" href="{{ asset('assets/css/mailer.css') }}">

</head>
<body>
    <div class="container">
        <div class="header">
            Dear [Applicant's Name],
        </div>
        <div class="content">
            I hope this message finds you well. It is with great pleasure that I inform you that your application for <b>[purpose of the application]</b> has been thoroughly reviewed and approved.
        </div>
        <div class="details">
            <p>Application Details:</p>
            <table>
                <tr>
                    <th>Application ID:</th>
                    <td>[Application ID]</td>
                </tr>
                <tr>
                    <th>Application Date:</th>
                    <td>[Application Date]</td>
                </tr>
            </table>
        </div>
        <div class="content">
            Your qualifications, experience, and enthusiasm have made a significant impression on our selection committee, and we are delighted to welcome you to <b>[Company Name/Organization]</b>. Congratulations on this achievement!
        </div>
        <div class="footer">
            Best regards,<br>
            RAV Team
        </div>
    </div>
</body>
</html>
