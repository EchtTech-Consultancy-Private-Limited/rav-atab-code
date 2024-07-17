<style>
    table th {
        text-align: center;
        border: 1px solid #eee;
        color: #000;
    }

    table td {
        text-align: left;
        border: 1px solid #eee;
        color: #000;
    }

    .highlight {
        background-color: #9789894a;
    }

    .highlight_nc {
        background-color: #ff000042;
    }

    .highlight_nc_approved {
        background-color: #00800040;
    }

    td select.form-control.text-center {
        border: 0;
    }

    .loading-img {
        z-index: 99999999;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);;
        overflow: hidden;
        text-align: center;
    }

    .loading-img .box {
        position: absolute;
        top: 50%;
        left: 50%;
        margin: auto;
        transform: translate(-50%, -50%);
        z-index: 2;
    }

    .uploading-text {
        padding-top: 10px;
        color: #fff;
        /* font-size: 18px; */
    }

    td.text-justify {
        text-align: left;
    }

    .btnDiv a {
        margin-right: 10px !important;
    }


    .file-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .file-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #3498db;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 12px;
    }

    .file-label:hover {
        background-color: #2980b9;
    }

    .file-input {
        display: none;
    }

    table {
        /* caption-side: bottom; */
        border-collapse: collapse;
        /* border: 1px solid #ddd !important; */
        background: #fff;
        padding: 33px !important;
    }


    table th,
    table td,
    table tr {
        text-align: center;
        border: 1px solid #aaa !important;
        color: #000;
    }

    table td {
        text-align: left;
        padding: 10px 10px;
       
    }
</style>

</head>

<body class="light">
<!-- Progressbar Modal Poup -->
<section class="content">
    <div class="container-fluid">
            <div>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <form id="submitForm" action="{{url('onsite/final-summary')}}" method="post">
                            @csrf
                            <div class="p-3  bg-white position-relative">
                                <section id="on-site-print">
                                <table >

                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="fw-bold">ONSITE ASSESSMENT FORM.</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fw-bold">Application No (provided by ATAB):</br> <span class="fw-normal">{{$summertReport->uhid}}</span>
                                            </td>
                                            <td colspan="3" class="fw-bold">Date of Application: </br><span class="fw-normal"> {{date('d-m-Y',strtotime($summertReport->app_created_at))}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="fw-bold">Name and Location of the Training Provider: </br><span class="fw-normal"> {{$summertReport->person_name}}</span>
                                            </td>
                                            <td colspan="4" class="fw-bold">Name of the course  to be assessed:
                                            </br>
                                                <span class="fw-normal">
                                                        @foreach($get_all_courses as $course)
                                                            <b>{{$course->course_name}}</b>,
                                                        @endforeach
                                                    </span> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fw-bold">Way of assessment (onsite/ hybrid/ virtual):</br> <span class="fw-normal"> {{$assessement_way??'N/A'}}</span>
                                            </td>
                                            <td colspan="3" class="fw-bold">No of Mandays: </br><span class="fw-normal"> {{$no_of_mandays}}</span>
                                            </td>
                                        </tr>
                                
                                        @foreach($all_assessor_assign as $assessor)
                                        <tr>
                                            <td class="fw-bold" colspan="2">Signature:</td>                                           
                                            <td colspan="4">..............</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold" colspan="2">Assessor Name</td>
                                            <td colspan="4"> {{$assessor->firstname??''}} {{$assessor->middlename??''}} {{$assessor->lastname??''}}({{$assessor->assessor_designation}}) </td>
                                            
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="fw-bold"> Team Leader: </td>
                                            <td> {{$assessor_name??''}} ({{$assessor_assign->assessor_designation}})</td>
                                            <td colspan="2" class="fw-bold"> Rep. Assessee Orgn:</td>
                                            <td colspan="2">{{$summertReport->assessee_org}} </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="fw-bold">Brief about the Opening Meeting: <span class="fw-normal">{{$summertReport->brief_open_meeting}}</span></td>
                                        </tr>

                                       
                                
                                        <tr>
                                            <td class="fw-bold"> Sl. No</td>
                                            <td class="fw-bold">Objective Element </td>
                                            <td class="fw-bold"> NC raised</td>
                                            <td class="fw-bold"> CAPA by Training Provider</td>
                                            <td class="fw-bold"> Document submitted against the NC</td>
                                            <td class="fw-bold"> Remarks (Accepted/ Not accepted)</td>
                                        </tr>
                                        <tbody>
                                       
                                    @foreach($original_data as $key=>$data)
                                    
                                        <tr>
                                        <td colspan="6">Course Name: <b>{{ $key ?? '' }}</b></td>
                                        </tr>
                                        @foreach ($data as $key=>$rows)
                                            <tr>
                                                <td class="fw-bold">{{$rows->code}}</td>
                                                <td>{{$rows->title}}</td>
                                                <td class="fw-bold remove_extra_comma">
                                                @foreach($rows->nc as $row)
                                                      <span>{{$row->nc_type}}</span><span></span>
                                                @endforeach
                                                </td>
                                                <td>

                                                @foreach($rows->nc as $key=>$row)
                                                    @if($row->tp_remark!=null)
                                                        {{$key+1}} : {{ucfirst($row->tp_remark)}},
                                                    @else
                                                    <!-- N/A -->
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @foreach($rows->nc as $key=>$row)
                                                        
                                                            @if($row->nc_type=="not_recommended")
                                                            {{ucfirst($row->nc_type)}}
                                                            @else
                                                                @if($row->assessor_type=='admin')
                                                                {{$row->nc_type}} by Admin
                                                                @else
                                                                {{$row->nc_type}}
                                                                @endif
                                                            @endif
                                                @endforeach

                                                         <!-- Admin -->
                                                         @foreach($rows->nc_admin as $key=>$row)
                                                        <?php 
                                                                $color_code = ["Accept"=>"success","Reject"=>"danger"];
                                                                if (array_key_exists($row->nc_type, $color_code)) {
                                                                    $final_color_value = $color_code[$row->nc_type];
                                                                } else {
                                                                    $final_color_value = "danger";
                                                                }
                                                        ?>
                                                        @if($row->nc_type!=="Request_For_Final_Approval")
                                                        <a target="_blank" href="{{ asset('level/'.$row->doc_file_name) }}" class="btn btn-{{$final_color_value}} m-1" href="">
                                                                {{ucfirst($row->nc_type)}} By Admin
                                                    </a>  
                                                    @endif
                                                        @endforeach
                                            
                                            </td>
                                            <td>
                                                
                                            @php
                                                    $count = count($rows->nc);
                                                    $admin_count = count($rows->nc_admin);
                                                    @endphp

                                                
                                                        @if(@$rows->nc_admin && (@$rows->nc_admin[0]->nc_type=="Accept" || @$rows->nc_admin[0]->nc_type=="Reject"))
                                                        {{$rows->nc_admin[0]->comments??''}}
                                                    @else
                                                            @if($count==1)
                                                            {{$rows->nc[0]->comments??''}}
                                                            @elseif($count==2)
                                                            {{$rows->nc[1]->comments??''}}
                                                            @elseif($count==3)
                                                            {{$rows->nc[2]->comments??''}}
                                                            @elseif($count==4)
                                                            {{$rows->nc[3]->comments??''}}
                                                            @elseif($count==5)
                                                            {{$rows->nc[4]->comments??''}}
                                                            @elseif($count==6)
                                                            {{$rows->nc[5]->comments??''}}
                                                            @else
                                                            {{$rows->nc[6]->comments??''}}
                                                            @endif
                                                    @endif

                                           
                                            </td>
                                            </tr>
                                            @endforeach

                                        @endforeach





                                        <!-- </tbody> -->
                                        <tr>
                                            <td colspan="6" class=""><span class="fw-bold">Brief Summary:</span> <span class="">{{$summertReport->brief_summary}}</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class=""><span class="fw-bold">Brief about the closing meeting:</span> <span class="">{{$summertReport->brief_closing_meeting}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold" colspan="2">
                                                Date : <span class="fw-normal">{{date('d-m-Y',strtotime($summertReport->summary_date))}}</span>
                                            </td>
                                            <td class="fw-bold" colspan="4">
                                                Signature : ..........
                                            </td>
                                        </tr>
                                    </tbody>
                                
                                </table>
                                <div class="table-responsive">
                                    <table>

                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="fw-bold">
                                                    OPPORTUNITY FOR IMPROVEMENT FORM
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="fw-bold">Name and Location of the Training Provider: <span class="fw-normal">{{$summertReport->person_name}}</span></td>
                                                <td colspan="4" class="fw-bold">Name of the course  to be assessed: <span class="fw-normal">{{$summertReport->course_name}}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="fw-bold"> Way of assessment (onsite/ hybrid/ virtual):</br> <span class="fw-normal">{{$assessement_way??'N/A'}}</span></td>
                                                <td colspan="4" class="fw-bold"> No of Mandays: <span class="fw-normal">{{$no_of_mandays}}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">S.No.</td>
                                                <td class="fw-bold"> Opportunity for improvement Form</td>
                                                <td class="fw-bold" colspan="4"> Standard reference</td>
                                            </tr>
                                            <tr>
                                                <td>{{$summertReport->sr_no}}</td>
                                                <td>{{$summertReport->improvement_form}}</td>
                                                <td colspan="4">{{$summertReport->standard_reference}}</td>
                                            </tr>
                                    
                                            <tr>
                                                <td class="fw-bold"> Signatures</td>
                                                <td class="fw-bold" colspan="5">.......... </td>
                                                
                                            </tr>
                                    
                                            <tr>
                                                <td class="fw-bold">Assessor Name </td>
                                                
                                                <td colspan="5">{{$assessor_name??''}} ({{$assessor_assign->assessor_designation}})</td>
                                               
                                                
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Team Leader </td>
                                                <td>{{$assessor_name??''}} ({{$assessor_assign->assessor_designation}})</td>

                                                 <td class="fw-bold" colspan="4"> Rep. Assessee Orgn : <span class="fw-normal">{{$summertReport->onsite_assessee_org}}</span></td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="fw-bold"> Date: {{date('d-m-Y',strtotime($summertReport->app_created_at))}}</td>
                                                <td colspan="2" class="fw-bold"> Signature of the Team Leader</td>
                                                <td colspan="3" class="fw-bold"> ....</td>
                                    
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                <div class="col-sm-12" id="comment-section">
                                                                    <label for="comment_text" class="">Remark</label>
                                                                    
                                                                    @foreach($get_all_courses as $key=>$course)
                                                                        {{$key+1}} : [{{$course->course_name}}] : <b>{{$course->remark}}</b>
                                                                    @endforeach
                                                                    
                                                                    
                                                     </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </br>
                                </div>
                            </section>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>
    </div>
</section>

