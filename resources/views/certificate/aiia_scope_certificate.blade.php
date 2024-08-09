<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link rel="stylesheet" href="{{public_path("/assets/css/certificate.css")}}">

</head>

<body>
    <div class="certificate-box">
        <div class="bg-box2">
            <div class="content-box aiia-scope">
                <div class="header-logo aiia-header">
                    <div class="width-h-20">
                        <img src="{{public_path('/assets/images/certificate/rava-logo.png')}}" alt="rava-logo">
                    </div>
                    <div class="header-content width-h-60">
                        <h1 class="header-title">
                            AYURVEDA TRAINING ACCREDITATION BOARD (ATAB)
                        </h1>
                        <p>
                            <b> RASHTRIYA AYURVEDA VIDYAPEETH <br> (NATIONAL ACADEMY OF AYURVEDA)</b>
                        </p>
                        <p>
                            An autonomous body under Ministry of Ayush, Govt. of India <br>
                            Dhanwantari Bhawan, Road No. 66, Punjabi Bagh (W), New Delhi - 110026, India. <br>
                            <b>Tele</b>: <a href="tel:011- 35579175"> 011- 35579175</a> <b>Email</b>:<a
                                href="mailto:ravaccred@gmail.com"> ravaccred@gmail.com </a> <b>Website</b>: <a
                                href="www.ravdelhi.nic.in "> www.ravdelhi.nic.in </a>
                        </p>
                    </div>
                    <div class="atab-logo width-h-20">
                        <img src="{{public_path('/assets/images/certificate/atab-logo.png')}}" alt="ATAB LOGO">
                    </div>
                </div>
                <div class="mt-80">
                    <h1 class="title"> SCOPE OF ACCREDITED AYURVEDA COURSES</h1>
                </div>

                <div class="certificate-no">
                    <p>CERTIFICATE NO. : {{$app_details->certificate_no}}</p>
                </div>

                <div class="detail ">
                    <p class="w-100"><span class="w-d-30">NAME OF INSTITUTE:</span> <span class="w-d-70"> ALL INDIA INSTITUTE OF AYURVEDA (AIIA)</span></p>
                </div>
                <div class="detail ">

                    <p class="w-100"><span class="w-d-30">ADDRESS:</span> <span class="w-d-70">{{$app_details->address}},{{$app_details->city_name}},{{$app_details->state_name}},{{$app_details->country_name}}-{{$app_details->postal}}</span></p>
                </div>
                <div class="aiia-scope-table">
                    <table>
                        <thead>
                            <tr>
                                <th>S. NO.</th>
                                <th>NAME OF AYURVEDA COURSE</th>
                                <th>DURATION</th>
                                <th>MODE OF DELIVERY</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($courses as $key=>$course)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$course->course_name}}</td>
                                <td>1500 Hours</td>
                                <td>{{$course->mode_of_course}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>




                <div class="approval aiascope-sign-container">
                    <div class="aiascope-sign width-img-30">
                    @php
                        use \Carbon\Carbon;
                        $formattedValidFrom = Carbon::parse($app_details->valid_from)->format('M d, Y');
                        $formattedValidTill = Carbon::parse($app_details->valid_till)->format('M d, Y');
                    @endphp
                        <p><b> Valid from: </b> <span class="value">{{$formattedValidFrom}}</span></p>
                        <p><b>Valid thru: </b> <span class="value">{{$formattedValidTill}}</span></p>
                    </div>

                    <div class="qr width-img-30">
                        <img src="{{public_path('/assets/images/certificate/qr.png')}}" alt="qr code">
                    </div>
                    <div class="sign width-img-30">
                        <div class="sign-img">
                            <img src="{{public_path('/assets/images/certificate/AIIA_SCOPE_CERTIFICATE_sign.png')}}"
                                alt="Dr. Vandana Siroha">
                        </div>
                        <div>
                            <p class="director-name">
                                <span> Dr. Vandana Siroha</span> <br>
                                <span>Director</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</body>

</html>