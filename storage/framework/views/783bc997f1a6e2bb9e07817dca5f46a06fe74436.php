<!DOCTYPE html>
<html>
<head>
    <title>RAV ATAB - payment Success</title>
</head>
<body>
    <h1><?php echo e($paymentMail['title']); ?></h1>
    <p><?php echo e($paymentMail['body']); ?></p>
    <p>  Application Number : RAVAP-<?php echo e((4000+$paymentid)); ?>  </p>
    <p> Training Provider : <?php echo e($userid); ?></p>
</body>
</html>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/email/payment-email.blade.php ENDPATH**/ ?>