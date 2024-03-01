<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>RASHTRIYA AYURVEDA VIDYAPEETH - ATAB</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ asset('assets-welcome/vendor/bootstrap/css/bootstrap.min.css')}} " rel="stylesheet">
    <link href="{{ asset('assets-welcome/css/main.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets-welcome/vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <script src="{{ asset('assets-welcome/js/code.jquery.com_jquery-3.7.0.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('assets-welcome/css/style.css')}}">
</head>
<body onload="curtain()">
    <div class="curtain">
        <!-- The container that wraps the curtain -->
        <div class="curtain__wrapper">
            <!-- The left curtain panel -->
            <div class="curtain__panel curtain__panel--left">
            </div> <!-- curtain__panel -->
            <div class="container-fluid px-0">
                <div class="backgorund-img1"></div>
                <div class="backgorund-img2"></div>
                <div class="backgorund-img3"></div>
            </div>
            <div class="curtain__prize">
                <div class="main-container">
                    <div class="container">
                        <div class="launching-page">
                            <div class="header">
                                <div class="row align-items-center">
                                    <div class="col-md-2 width-15">
                                        <div class="logo">
                                            <a href="#">
                                                <img src="{{ asset('assets-welcome/img/government-of-india.jpg')}}" alt="" title=""/>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-center justify-content-center width-70">
                                      <div class="header_content">
                                          <div class="logo">
                                           <img src="{{ asset('assets-welcome/img/ATAB.png')}}" alt="atab" title="atab">   
                                          </div> 
                                        <h3>RASHTRIYA AYURVEDA VIDYAPEETH</h3>
                                        <!-- <h5> National Center for Disease Control</h5>-->
                                        <h5> AYRVEDA TRAINING ACCREDITATION BOARD</h5>
                                      </div>
                                    </div>
                                    <div class="col-md-2 justify-content-end d-flex width-15">
                                        <div class="logo">
                                            <a href="#">
                                                <img src="{{ asset('assets-welcome/img/rav_logo.png')}}" alt="atab" title="atab">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="about-content">
                                            <h1 class="title"> About Ayurveda Training Accreditation Board </h1>
                                            <div class="about-item">
                                                <P>
                                                    Ayurveda Training Accreditation Board (ATAB), operating under Rashtriya Ayurveda Vidyapeeth (RAV), is a board established by the Ministry of Ayush, Govt. of India. Its primary objective is to accredit Ayurveda training courses being conducted both within India and abroad, which does not fall under the purview of National Commission for Indian System of Medicine (NCISM) Act 2020, formerly known as the Indian Medicine Central Council (IMCC) Act 1970, or any other regulatory bodies.
                                                </P>
                                                <p>
                                                    ATAB serves as a mechanism to ensure the uniformity, quality and standardization of Ayurveda training programs, thereby enhancing the credibility and effectiveness of Ayurvedic education. By accrediting these courses, ATAB aims to uphold the integrity of Ayurvedic teachings, promote excellence in training methodologies, and safeguard the interests of students and practitioners alike.
                                                </p>
                                                <p>
                                                    Overall, the establishment of ATAB represents a significant step towards ensuring the quality and integrity of Ayurveda training programs, both within India and internationally, contributing to the promotion and preservation of Ayurvedic knowledge and practices.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="proceed">
                                            <!-- <div class="proceed-gif">
                                                <img src="{{ asset('assets-welcome/img/giphy.webp')}}" alt="dog" title="dog">
                                            </div> -->
                                            <div class="text-center">
                                                <a href="{{ route('login-page') }}" class="pulse">Proceed Now <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- curtain__prize -->
            <!-- The right curtain panel -->
            <div class="curtain__panel curtain__panel--right">
            </div> <!-- curtain__panel -->
        </div> <!-- curtain__container -->
    </div>
    <script src="{{ asset('assets-welcome/js/main.js')}}"></script>
</body>
</html>