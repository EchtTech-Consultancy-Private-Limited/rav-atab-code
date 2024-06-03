@extends('front.Layouts.master')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <!-- Magnific Popup css -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />


<section class="withsidebar-wrap ptb-60 pb-0">

    <div class="container">

        <div class="row">



@isset($item)



<div class="col master-class">
    <div class="innerpagecontent">

        <!-- Heading section Start -->
            <h3>
                @if (GetLang() == 'en')
                {{ $item[0]->name ?? '' }}
            @else
                {{ $item[0]->name_h ?? '' }}
            @endif
            </h3>
        <!-- Heading section End -->

        <!-- Content section  start-->

        <p>   @if (GetLang() == 'en')
                {!! $item[0]->content ?? '' !!}
            @else
                {!! $item[0]->content_h ?? '' !!}
            @endif

        </p>



         <!-- Content Section End -->
    </div>



@endisset

@isset($value)

     <!-- Photo Gallery Section Start -->

     <div class="excellence-wrap back-img Activities img-gallery mt-3 mb-3">
        <div class="container">
            <div class="row">
                <h5 class="internal-h">Image Gallery</h5>
                <div class="col-md-12 p-0">
                    <div class="excellence-gallery partnership-img">
                        <div class="row masonry-grid">




                            @foreach ($value as $values )

                            <div class="col-md-4 col-lg-4">
                                <div class="d-flex flex-column h-100">
                                    <a href="{{ asset('gallery/multipimage/' . $values->large_image) }}"
                                        class="image-link">
                                        <div class="thumbnail p-relative">
                                            <img  src="{{ asset('gallery/multipimage/' . $values->large_image) }}"                                  }}"
                                                alt="gallery-img" class="img-fluid"
                                                loading="lazy">
                                            <div class="top-text"> {{ $values->image_title }} </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Gallery section End -->

@endisset


   @isset($value)


       <!-- Video Gallery Section Start -->

       <div class="excellence-wrap back-img Activities video-gallery mt-3 mb-3">
        <div class="container">
            <div class="row">
                <h5 class="internal-h">Video Gallery</h5>

                <div class="col-md-6">
                    <div class="vid-container">
                        <iframe id="vid_frame" src="https://www.youtube.com/embed/q1onzvBSdJM" frameborder="0" width="100%" height="300"></iframe>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="row vid-list-container">


                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame').src='http://localhost/kashipur-design1/public/IIM Kashipur'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993025.png" title="Building Video" alt="Building Video" loading="lazy"></span>
                                <span class="top-text">  Building Video </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>


                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame').src='http://localhost/kashipur-design1/public/BG-VIDEO'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993076.jpg" title="Video text" alt="Video text" loading="lazy"></span>
                                <span class="top-text">  Video text </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>

                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame').src='http://localhost/kashipur-design1/public/IIM Kashipur'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993025.png" title="Building Video" alt="Building Video" loading="lazy"></span>
                                <span class="top-text">  Building Video </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>


                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame').src='http://localhost/kashipur-design1/public/BG-VIDEO'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993076.jpg" title="Video text" alt="Video text" loading="lazy"></span>
                                <span class="top-text">  Video text </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>


                    </div>
                </div>

            </div>
        </div>
       </div>

    <!-- Video Gallery section End -->

    @endisset

  <!-- Tab Section -->

    <div class="wrapper">
        <nav class="tabs">
            <div class="selector"></div>
            <a href="javascript:void();" class="active tablinks" onclick="openCity(event, 'Events')">
                Events
            </a>
            <a href="javascript:void();" class="tablinks" onclick="openCity(event, 'Activities')">
                Activities
            </a>
            <a href="javascript:void();" class="tablinks" onclick="openCity(event, 'Portal')">
                Alumni Portal
            </a>
            <a href="javascript:void();" class="tablinks" onclick="openCity(event, 'Association')">
                Alumni Association
            </a>
            <a href="javascript:void();" class="tablinks">
                Team ARC
            </a>
            <a href="javascript:void();" class="tablinks">
                Contact Us
            </a>
        </nav>

        <div id="Events" class="tabcontent">
            <div class="excellence-wrap back-img">
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="tab-content" id="excellenceTabContent">
                                <div class="tab-pane fade show active" id="innovation" role="tabpanel"
                                    aria-labelledby="innovation-tab">
                                    <div class="excellence-gallery partnership-img">
                                        <div class="row masonry-grid">

                                            <div class="col-md-6 col-lg-6">
                                                <div class="d-flex flex-column h-100">
                                                    <a href="Events.html">
                                                        <div class="thumbnail p-relative">
                                                            <img src="http://localhost/kashipur-design1/public/gallery/image/1677405700.png"
                                                                alt="gallery-img" class="img-fluid"
                                                                loading="lazy">
                                                            <div class="top-text"> HOMECOMING </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6">
                                                <div class="d-flex flex-column h-100">
                                                    <a href="Events.html">
                                                        <div class="thumbnail p-relative">
                                                            <img src="http://localhost/kashipur-design1/public/gallery/image/1677405680.png"
                                                                alt="gallery-img" class="img-fluid"
                                                                loading="lazy">
                                                            <div class="top-text">CITY MEETS
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-lg-6">
                                                <div class="d-flex flex-column h-100">
                                                    <a href="Events.html">
                                                        <div class="thumbnail p-relative">
                                                            <img src="http://localhost/kashipur-design1/public/gallery/image/1677559777.png"
                                                                alt="gallery-img" class="img-fluid"
                                                                loading="lazy">
                                                            <div class="top-text">Linnaeus University,
                                                                Sweden </div>

                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Activities" class="tabcontent" style="display: none;">

            <div class="commontxt">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <h5 class="internal-h">I-MENTORSHIP PROGRAM</h5>
                        <p>
                            I-Mentorship program is designed to integrate our alumni into the personal
                            mentoring of our present students. Students are mapped to our distinguished
                            alumni based on mutual domain interests. The personal mentoring helps our
                            students in cracking corporate competitions, academic support and career
                            guidance.
                        </p>


                    </div>

                </div>
            </div>

             <!-- Photo Gallery Section Start -->

     <div class="excellence-wrap back-img Activities img-gallery mt-3 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="excellence-gallery partnership-img">
                        <div class="row masonry-grid">

                            <div class="col-md-4 col-lg-4">
                                <div class="d-flex flex-column h-100">
                                    <a href="http://localhost/kashipur-design1/public/gallery/image/1677405700.png"
                                        class="image-link">
                                        <div class="thumbnail p-relative">
                                            <img src="http://localhost/kashipur-design1/public/gallery/image/1677405700.png"
                                                alt="gallery-img" class="img-fluid"
                                                loading="lazy">
                                            <div class="top-text"> Event 1 </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4">
                                <div class="d-flex flex-column h-100">
                                    <a href="http://localhost/kashipur-design1/public/gallery/image/1677405680.png"
                                        class="image-link">
                                        <div class="thumbnail p-relative">
                                            <img src="http://localhost/kashipur-design1/public/gallery/image/1677405680.png"
                                                alt="gallery-img" class="img-fluid"
                                                loading="lazy">
                                            <div class="top-text">Event 2
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-4 col-lg-4">
                                <div class="d-flex flex-column h-100">
                                    <a href="http://localhost/kashipur-design1/public/gallery/image/1677559777.png"
                                        class="image-link">
                                        <div class="thumbnail p-relative">
                                            <img src="http://localhost/kashipur-design1/public/gallery/image/1677559777.png"
                                                alt="gallery-img" class="img-fluid"
                                                loading="lazy">
                                            <div class="top-text">Event 3</div>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Gallery section End -->

    <h5 class="internal-h">SARATHI NEWSLETTER</h5>
    <p>
        SARATHI is the quarterly newsletter published by Team ARC, aimed to keep our
        alumni updated with happenings at their alma-mater while concurrently
        apprising our current students of the developments in our alumni community.
    </p>

       <!-- Video Gallery Section Start -->

       <div class="excellence-wrap back-img Activities video-gallery mt-3 mb-3">
        <div class="container">
            <div class="row mt-3">


                <div class="col-md-6">
                    <div class="vid-container">
                        <iframe id="vid_frame1" src="https://www.youtube.com/embed/q1onzvBSdJM" frameborder="0" width="100%" height="300"></iframe>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="row vid-list-container">


                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame1').src='http://localhost/kashipur-design1/public/IIM Kashipur'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993025.png" title="Building Video" alt="Building Video" loading="lazy"></span>
                                <span class="top-text">  Building Video </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>


                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame1').src='http://localhost/kashipur-design1/public/BG-VIDEO'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993076.jpg" title="Video text" alt="Video text" loading="lazy"></span>
                                <span class="top-text">  Video text </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>

                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame1').src='http://localhost/kashipur-design1/public/IIM Kashipur'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993025.png" title="Building Video" alt="Building Video" loading="lazy"></span>
                                <span class="top-text">  Building Video </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>


                        <div class="col-md-6 p-relative">
                            <a href="javascript:void();" onclick="document.getElementById('vid_frame1').src='http://localhost/kashipur-design1/public/BG-VIDEO'">
                                <span class="vid-thumb"><img src="http://localhost/kashipur-design1/public/video/multiple-image/1684993076.jpg" title="Video text" alt="Video text" loading="lazy"></span>
                                <span class="top-text">  Video text </span>
                                <span class="btn-p"><i class="fa fa-play-circle" aria-hidden="true" title="Play"></i>
                                </span>
                            </a>
                        </div>


                    </div>
                </div>

            </div>
        </div>
       </div>

    <!-- Video Gallery section End -->

    <!-- OL List start -->

    <h3>General</h3>

    <ol>
        <li>All Users of the library are requested to carry their Identity Cards, issued to them by the Institute, while visiting the library. </li>
        <li>The owner of the Identity card is responsible for the documents issued on his/her card. </li>
        <li>The Library will usually send reminders to the faculty and to research scholars for the book due, but non-receipt of reminders is no reason for returning books late.</li>
        <li>Books can be recalled in case of an urgent demand for the same. </li>
        <li>The borrower is fully responsible for the books borrowed on his ID card. </li>
        <li>All personal belongings, except money bag, mobile, notebooks, will be kept at the property counter of the library.</li>
        <li>Users must take care of their pen drives, CD/DVD ROMs, mobiles, laptop and wallets etc. Library/Identify card is Non-transferable.</li>
     </ol>

     <h3>Discipline</h3>

    <!-- OL List start End -->

    <!-- UL List start -->

    <ul>
         <li>The library should be used for academic and research purposes only.</li>
         <li> All users are requested to maintain silence in the library and adhere strictly to its rules and regulations.</li>
         <li> Chatting, smoking, eating, sleeping, making visual aids and using mobile phones etc. is strictly prohibited in the library premises.</li>
         <li> All users are requested to keep their mobiles switched off or in silent mode in the library</li>
         <li> Any irregularities found may kindly be brought to the notice of the Librarian for necessary action.</li>
         <li> The Librarian is authorized to terminate the membership of any borrower if he/she is found guilty of such misconduct.</li>
         <li> Seats in the reading area will be available on first come first-served basis. </li>
         <li>Users must take care of their pen drives, CD/DVD ROMs, mobiles, laptop and wallets etc. Library/Identify card is Non-transferable.</li>

    </ul>
    <!-- UL List End -->


        <!-- table section Start -->
            <table class="table-responsive">
                <tr>
                    <td>Sl. No </td>
                    <td>User </td>
                    <td>No.of Book </td>
                    <td>Loan Period   </td>
                    <td>No. of Bound Journals </td>
                    <td>Loan Period</td>
                    <td>No. of CD </td>
                    <td>Loan Period </td>
                </tr>

                <tr>
                    <td>1</td>
                    <td>Faculty </td>
                    <td>14 </td>
                    <td>120 days  </td>
                    <td>1 </td>
                    <td>Overnight</td>
                    <td>2 </td>
                    <td>Overnight </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Faculty </td>
                    <td>14 </td>
                    <td>120 days  </td>
                    <td>1 </td>
                    <td>Overnight</td>
                    <td>2 </td>
                    <td>Overnight </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Faculty </td>
                    <td>14 </td>
                    <td>120 days  </td>
                    <td>1 </td>
                    <td>Overnight</td>
                    <td>2 </td>
                    <td>Overnight </td>
                </tr>


            </table>
        <!-- table section Start -->

     <!-- Accordion Section start -->

      <div class="accordion accordion-flush" id="accordionFlushExample" style="border:var(--bs-accordion-border-width) solid var(--bs-accordion-border-color)">
            <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
            Accordion 1
            </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
            </div>
            </div>
            <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
            Accordion 2
            </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
            </div>
            </div>
            <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
            Accordion 3
            </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
            </div>
            </div>
     </div>

   <!-- Accordion Section end -->
 </div>

</div>
</div>
</section>


    <!-- Tab Js -->
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

    <script>
        var tabs = $('.tabs');
        var selector = $('.tabs').find('a').length;
        //var selector = $(".tabs").find(".selector");
        var activeItem = tabs.find('.active');
        var activeWidth = activeItem.innerWidth();
        $(".selector").css({
            "left": activeItem.position.left + "px",
            "width": activeWidth + "px"
        });

        $(".tabs").on("click", "a", function (e) {
            e.preventDefault();
            $('.tabs a').removeClass("active");
            $(this).addClass('active');
            var activeWidth = $(this).innerWidth();
            var itemPos = $(this).position();
            $(".selector").css({
                "left": itemPos.left + "px",
                "width": activeWidth + "px"
            });
        });
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

@endsection
