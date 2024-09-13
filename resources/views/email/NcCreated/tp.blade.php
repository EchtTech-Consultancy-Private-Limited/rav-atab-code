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
            I hope this email finds you well. I am writing to inform you that a NC has been generated for <b>[document/project/process]</b> in accordance with our quality management procedures.
        </div>
        <div class="details">
            <p>NC Details:</p>
            <table>
                <tr>
                    <th>NC ID:</th>
                    <td>[NC ID]</td>
                </tr>
                <tr>
                    <th>Document Name:</th>
                    <td>name</td>
                </tr>
                <tr>
                    <th>Document Sr. No.:</th>
                    <td>[Document Sr. No.]</td>
                </tr>
                <tr>
                    <th>Date Created:</th>
                    <td>[Date]</td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td>[Brief description of the non-conformance]</td>
                </tr>
                <tr>
                    <th>NC Created By:</th>
                    <td>Aman</td>
                </tr>
            </table>
        </div><br>
        <div class="footer">
            Best regards,<br>
            RAV Team
        </div>
    </div>
</body>
</html>
