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
            Dear Team,
        </div>
        <div class="content">
            We hope this message finds you well. We are pleased to inform you that your application payment has been successfully processed and approved. Thank you for your prompt and seamless transaction.
        </div>
        <div class="details">
            <p>Here are the transaction details:</p>
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
            Best regards,<br>
            RAV Team
        </div>
    </div>
</body>
</html>
