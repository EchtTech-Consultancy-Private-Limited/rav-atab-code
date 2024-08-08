

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
        <div class="bg-box">    
          <div class="content-box">
            <div class="certificate-atab-logo">
                <img src="{{public_path('/assets/images/certificate/atab-logo.png')}}" alt="ATAB logo">
            </div>
            
             <h1 class="heading-light">CERTIFICATE OF</h1>
             <h2 class="heading-bold">ACCREDITATION</h2>
             <p class="text-sm">
                This certificate is presented to
             </p>

             <div class="center-content">
               <div class="aiia-container">
                <h3 class="aiia">All India Institute of Ayurveda (AIIA)</h3>
                <h4 class="aiia-address">
                    {{$app_details->address}},{{$app_details->city_name}},{{$app_details->state_name}},{{$app_details->country_name}}-{{$app_details->postal}}
                    <!-- Gautampuri, Sarita Vihar, MathuraRoad, New Delhi-110076 -->
                </h4>
               </div>

               <p class="content-para">
                has been assessed and found to comply with <br>
                <b>Ayurveda Training Accreditation Board (ATAB)</b> <br>
                accreditation standards for Ayurveda Courses. <br>
                This certificate is valid for the Scope as specified in the <br>
                annexure subject to continued compliance with the <br>
                accreditation requirements.

               </p>

             </div>
             @php
                use \Carbon\Carbon;
                $formattedValidFrom = Carbon::parse($app_details->valid_from)->format('M d, Y');
                $formattedValidTill = Carbon::parse($app_details->valid_till)->format('M d, Y');
            @endphp
             <div class="validity">
                <div class="width-val-50">
                    <p><b> Valid from: </b> <span class="value">{{$formattedValidFrom}}</span></p>
                    <p><b>Valid thru: </b> <span class="value">{{$formattedValidTill}}</span></p>
                </div>
                <div class="width-val-50">
                    <p>
                        <b>Certificate No. :</b> <br>
                        <span class="vlaue">{{$app_details->certificate_no}}</span>
                    </p>
                </div>
             </div>

             <div class="approval certificate">
                <div class="width-img-30">
                    <img src="{{public_path('/assets/images/certificate/qr.png')}}" alt="qr code">
                </div>
                <div class="width-img-30 logo-r">
                    <img src="{{public_path('/assets/images/certificate/rava-logo.png')}}" alt="RAV logo">
                </div>
                <div class="sign width-img-30">
                    <div class="sign-img">
                        <img src="{{public_path('/assets/images/certificate/AIIA_SCOPE_CERTIFICATE_sign.png')}}" alt="Dr. Vandana Siroha">
                    </div>
                    <div >
                        <p class="director-name">
                            <span > Dr. Vandana Siroha</span>  <br>
                            <span>Director</span>
                        </p>
                    </div>
                </div>
               
             </div>

             <div class="header-logo certificate-footer">
                <div class="header-content">
                     <h1 class="header-title">
                        AYURVEDA TRAINING ACCREDITATION BOARD (ATAB)
                     </h1>
                     <p>
                       <b> RASHTRIYA AYURVEDA VIDYAPEETH <br> (NATIONAL ACADEMY OF AYURVEDA)</b>
                     </p>
                     <p>
                        An autonomous body under Ministry of Ayush, Govt. of India <br>
                        Dhanwantari Bhawan, Road No. 66, Punjabi Bagh (W), New Delhi - 110026, India. <br>
                        <b>Tele</b>: <a href="tel:011- 35579175"> 011- 35579175</a>  <b>Email</b>:<a href="mailto:ravaccred@gmail.com"> ravaccred@gmail.com </a> <b>Website</b>: <a href="www.ravdelhi.nic.in "> www.ravdelhi.nic.in </a> 
                     </p>
                </div>
                
               </div>
          </div>
        </div>
    </div>
    </body>
    </html>
    