<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AYURVEDA TRAINING ACCEREDITATION BOARD</title>

        <link rel="stylesheet" href="<?php echo e(asset('login1/css/style.css')); ?>">

     

         <link rel="stylesheet" href="<?php echo e(asset('custom/costam.js')); ?>" class="js">


        <!-- font awesome -->
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


     

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
     <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
     <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


     <style>
        .form {
           width: 40%;

       }
   </style>



    </head>
    <body>

        <div class="form-container">
            <div class="logo_container">
            <div class="logo">
                <img src="<?php echo e(asset('ragistration/img/ATAB.png')); ?>" alt="ATAB" title="ATAB">
            </div>
            <h1 class="brand_title">AYURVEDA TRAINING ACCEREDITATION BOARD</h1>
        </div>
            <form action="#" method="post" class="form" >

                <?php echo csrf_field(); ?>

                <span class="title">Accreditation User Landing page </span>

                <?php if(Session::has('success')): ?>
                <div class="alert alert-success" id="alert" style="padding: 15px;" role="alert">
                    <?php echo e(session::get('success')); ?>

                </div>
                <?php elseif(Session::has('fail')): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo e(session::get('fail')); ?>

                </div>
                <?php endif; ?>

                <ul >
                    <li class="iconInput">

                        <a href="<?php echo e(url('/login/admin')); ?>">
                        <input type="button"   value="Admin login" class="submit" >
                        </a>

                        <a href="<?php echo e(url('/login/TP')); ?>">
                        <input type="button"   value="Training Provider login" class="submit">
                         </a>

                        <a  href="<?php echo e(url('/login/Accessor')); ?>">
                        <input type="button" value="Accessor login" class="submit">
                        </a>


                         <a href="<?php echo e(url('/login/professional')); ?>">
                        <input type="button"  value="professional login" class="submit">
                        </a>
                    </li>
                </ul>

                <div class="address">
                    <ul>
                        <li><?php echo e(now()); ?></li>
                        <li>2023 &copy; RAV Accreditation
                        </li>
                        <li> Powered by Netprophets Cyberworks Pvt. Ltd.
                        </li>
                    </ul>
                </div>
            </form>

        </div>


<script>
 $("document").ready(function(){
    setTimeout(function(){
       $("#alert").remove();
    }, 5000 ); // 5 secs

});
<script>




<script>
    $(document).ready(function() {
        function disableBack() {
            window.history.forward()
        }
        window.onload = disableBack();
        window.onpageshow = function(e) {
            if (e.persisted)
                disableBack();
        }
    });
</script>


</body>
</html>
<?php /**PATH D:\xampp\htdocs\atab\resources\views/auth/landingpage.blade.php ENDPATH**/ ?>