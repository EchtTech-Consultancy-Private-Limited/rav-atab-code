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
            I trust this message finds you well. I am writing to request the approval of the payment associated with my recent application for <b>purpose of the application</b> submitted on <b>date</b>. As part of the application process, a payment of <b>amount</b> was made under the transaction reference ID <b>Transaction ID</b>.
        </div>
        <div class="details">
            <p>Here are the transaction details:</p>
            <table>
                <tr>
                    <th>Transaction ID:</th>
                    <td>Transaction ID</td>
                </tr>
                <tr>
                    <th>Payment Amount:</th>
                    <td>Amount</td>
                </tr>
                <tr>
                    <th>Payment Date:</th>
                    <td>Date</td>
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
