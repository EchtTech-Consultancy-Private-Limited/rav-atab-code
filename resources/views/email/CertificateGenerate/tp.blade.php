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
        Dear {$data['applicant_name']},
        </div>
        <div class="content">
            I trust this message finds you well. I am pleased to inform you that your participation/achievement in [event/activity] has been recognized, and your certificate has been successfully generated.
        </div>
        <div class="details">
            <p>Certificate Details:</p>
            <table>
                <tr>
                    <th>Certificate Title:</th>
                    <td>[Certificate Title]</td>
                </tr>
                <tr>
                    <th>Recipient's Name:</th>
                    <td>[Recipient's Full Name]</td>
                </tr>
                <tr>
                    <th>Event/Activity Name:</th>
                    <td>[Event/Activity Name]</td>
                </tr>
                <tr>
                    <th>Date of Participation/Achievement:</th>
                    <td>[Date]</td>
                </tr>
            </table>
        </div>
        <div class="content">
            Attached to this email, you will find a PDF copy of your certificate. Please review the details to ensure accuracy. If there are any corrections needed, kindly notify us as soon as possible.
        </div>
        <div class="content">
            Download your certificate: <b>[Certificate Attachment]</b>
        </div>
        <div class="content">
            We extend our heartfelt congratulations on your accomplishment/participation in <b>[event/activity]</b>. Your dedication and contributions have made a positive impact, and we are honored to recognize your efforts.
        </div>
        <div class="content">
            If you have any questions or require further assistance, please feel free to contact us at <b>[Contact Email/Phone]</b>.
        </div>
        <div class="footer">
            Once again, congratulations on this achievement, and we wish you continued success in your endeavors.
        </div><br>
        <div class="footer">
            Best regards,<br>
            <b>[Your Full Name]</b><br>
            <b>[Your Job Title]</b><br>
            <b>[Organization Name]</b><br>
            <b>[Contact Information]</b>
        </div>
    </div>
</body>
</html>
