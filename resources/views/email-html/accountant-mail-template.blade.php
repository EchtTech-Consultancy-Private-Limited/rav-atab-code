<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<p>Dear Team,</p>
<p>I trust this message finds you well. I am writing to request the approval of the payment associated with my recent application for RAVAP-"{{$application_id}}" submitted on ".date('d-m-Y').". As part of the application process, a payment of Rs.".$request->amount." was made under the transaction reference ID ".$referenceNumber.". ".PHP_EOL."
                Here are the transaction details: ".PHP_EOL."
                Transaction ID: ".$transactionNumber." ".PHP_EOL."
                Payment Amount: ".$request->amount." ".PHP_EOL."
                Payment Date: ".date("Y-m-d", strtotime($request->payment_date))." ".PHP_EOL."</p>
<p>{{$details['body']}}</p>
  
<strong>Regards & Thanks</strong>
<p>RAV Teams</p>
  
</body>
</html>