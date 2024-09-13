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
        Dear {$data['applicant_name']},
        </div>
        <div class="content">
            I hope this message finds you well. We are thrilled to inform you that your application for the position of <b>[Job Title]</b> has been successfully reviewed and approved. It is with great pleasure that we officially welcome you to the <b>[Department/Team]</b> at <b>[Company Name]</b>.
        </div>
        <div class="details">
            <p>Here are some important details regarding your assignment:</p>
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
            </table>
        </div><br>
        <div class="footer">
            <b>Best regards,</b><br>
            RAV Team
        </div>
    </div>
</body>
</html>
