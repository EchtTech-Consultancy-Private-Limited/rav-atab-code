<!DOCTYPE html>
<html>
<head>
    <title>Forget password </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

        body{
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
        }
        .navbar-laravel
        {
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
        .navbar-brand , .nav-link, .my-form, .login-form
        {
            font-family: Raleway, sans-serif;
        }
        .my-form
        {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .my-form .row
        {
            margin-left: 0;
            margin-right: 0;
        }
        /* for password eye */
        .eye {
    position: relative;
    right: 5%;
    margin: auto;
    float: right;
}

.input_password{

}
        .login-form
        {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .login-form .row
        {
            margin-left: 0;
            margin-right: 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Laravel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('/') }}">Landing page</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                @endguest
            </ul>

        </div>
    </div>
</nav>

@yield('content')

</body>





<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>



<script>
    $(document).ready(function() {
        $("#loginForm").validate({
            rules: {
                email_address: {
                    required: true,
                    email: true,
                    maxlength: 50
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {

                email_address: {
                    required: "Email is required",
                    email: "Email must be a valid email address",
                    maxlength: "Email cannot be more than 50 characters",
                },

                password: {
                    required: "Password is required",
                    minlength: "Password must be 8 to 15 characters"
                },
                password_confirmation: {
                    required:  "Confirm password is required",
                    equalTo: "Password and confirm password should same"
                },
            }
        });
    });
</script>

<script>
    let password = document.querySelector('#password');
    let togglePassword = document.querySelector('#togglePassword');

    togglePassword.addEventListener('click', (e)=>{
        const type = password.getAttribute('type') === 'password' ? 'text' :'password';

        password.setAttribute('type', type);

        this.classlist.toggle('fa-eye-slash');
    });


            let cpassword = document.querySelector('#password_confirmation');
            let togglecPassword = document.querySelector('#togglecpassword');

            togglecpassword.addEventListener('click', (e)=>{
                const type = cpassword.getAttribute('type') === 'password' ? 'text' :'password';

                cpassword.setAttribute('type', type);

                this.classlist.toggle('fa-eye-slash');
            })
</script>



</html>
