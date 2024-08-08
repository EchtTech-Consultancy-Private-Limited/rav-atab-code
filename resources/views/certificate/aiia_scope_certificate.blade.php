@include('layout.header')

    <div class="certificate-box">
        <div class="bg-box2">    
          <div class="content-box aiia-scope">
            <div class="header-logo">
                <div>
                    <img src="{{asset('/assets/images/certificate/rava-logo.png')}}" alt="rava-logo">
                </div>
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
                <div class="atab-logo">
                    <img src="{{asset('/assets/images/certificate/atab-logo.png')}}" alt="ATAB LOGO">
                </div>
               </div>
            <div>
                <h1 class="title"> SCOPE OF ACCREDITED AYURVEDA COURSES</h1>
            </div>

            <div class="certificate-no">
                <p>CERTIFICATE NO. : ATAB/AAC/00009/23-24</p>
            </div>
             
            <div class="detail ">
                <p><span>NAME OF INSTITUTE:</span>  <span> ALL INDIA INSTITUTE OF AYURVEDA (AIIA)</span></p>
                <p><span>ADDRESS:</span> <span>Gautampuri, Sarita Vihar, Mathura Road, New Delhi-110076</span></p>
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
                        <tr>
                            <td>01</td>
                            <td>Panchakarma Technician</td>
                            <td>1500 Hours</td>
                            <td>Offline</td> 
                        </tr>
                        <tr>  
                            <td>02</td>
                            <td>Ayurveda Dietician</td>
                            <td>540 Hours</td>
                            <td>Offline</td>
                        </tr>
                        <tr>    
                            <td>03</td>
                            <td>Kshara Karma Technician</td>
                            <td>1200 Hours</td>
                            <td>Offline</td>
                        </tr>
                    </tbody>
                </table>
            </div>


          

             <div class="approval aiascope-sign-container">
                <div class="aiascope-sign">
                    <p><b> Valid from: </b> <span class="value">Feb 28, 2024</span></p>
                    <p><b>Valid thru: </b> <span class="value">Feb 27, 2027</span></p>
                </div>
               
                <div class="qr">
                    <img src="{{asset('/assets/images/certificate/qr.png')}}" alt="qr code">
                </div>
                <div class="sign">
                    <div class="sign-img">
                        <img src="{{asset('/assets/images/certificate/AIIA_SCOPE_CERTIFICATE_sign.png')}}" alt="Dr. Vandana Siroha">
                    </div>
                    <div >
                        <p class="director-name">
                            <span > Dr. Vandana Siroha</span>  <br>
                            <span>Director</span>
                        </p>
                    </div>
                </div>
               
             </div>
          </div>

          
        </div>
    </div>
    @include('layout.footer')