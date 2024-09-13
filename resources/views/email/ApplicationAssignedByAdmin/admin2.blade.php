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
            I trust this message finds you well. I am delighted to inform you that your application for the <b>[Job Title]</b> position has been successfully reviewed, and I am pleased to confirm your assignment to this role at <b>[Company Name]</b>.
        </div>
        <div class="details">
            <p>Assignment Details:</p>
            <table>
                <tr>
                    <th>Position:</th>
                    <td>[Job Title]</td>
                </tr>
                <tr>
                    <th>Reporting to:</th>
                    <td>[Supervisor/Manager/Assessor]</td>
                </tr>
                <tr>
                    <th>Start Date:</th>
                    <td>[Start Date]</td>
                </tr>
                <tr>
                    <th>Location:</th>
                    <td>[Office Location/Remote]</td>
                </tr>
            </table>
        </div><br>
        <div class="footer">
            <b>Best regards,</b><br>
            RAV Team
        </div>
    </div>
</body>
</html>
