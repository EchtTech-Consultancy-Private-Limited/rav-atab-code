<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Approval Request</title>
    <link rel="stylesheet" href="{{ asset('assets/css/mailer.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            Dear Team,
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
        </div><br>
        <div class="footer">
            <b>Best regards,</b><br>
            RAV Team
        </div>
    </div>
</body>
</html>
