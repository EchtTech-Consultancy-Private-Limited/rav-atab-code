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
            Dear Applicant's Name,
        </div>
        <div class="content">
            I hope this email finds you well. I am writing to inform you that the payment associated with your application for <b>purpose of the application</b> has been successfully approved by our accounting department.
        </div>
        <div class="details">
            <p>Here are the details of your payment:</p>
            <table>
                <tr>
                    <th>Transaction ID:</th>
                    <td>[Transaction ID]</td>
                </tr>
                <tr>
                    <th>Payment Amount:</th>
                    <td>[Payment Amount]</td>
                </tr>
                <tr>
                    <th>Payment Date:</th>
                    <td>[Payment Date]</td>
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
