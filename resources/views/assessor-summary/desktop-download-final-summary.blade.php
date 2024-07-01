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
<section class="content mb-4">
        <div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12" id="desktop-print">
                            <form id="submitForm" action="#" method="#">
                                <div class="p-3 bg-white">
                                    <table>
    
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="fw-bold">DESKTOP ASSESSMENT FORM</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Application No (provided by ATAB):</br> <span class="fw-normal"> {{$summeryReport->uhid}}</span> </td>
                                                <td class="fw-bold">Date of application: </br><span class="fw-normal">{{date('d-m-Y',strtotime($summeryReport->app_created_at))}}</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Name and Location of the Training Provider: <span class="fw-normal"> <input type="text" disabled value="{{$summeryReport->person_name}}"></span> </td>
                                                <td class="fw-bold">Name of the course to be assessed:
                                    
                                                    <span class="fw-normal"> <input type="text" disabled value="{{$summeryReport->course_name}}"></span> </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Way of assessment (Desktop): </br><span class="fw-normal">
                                                   DDA
                                                </span> 
                                                    </td>
                                                <td class="fw-bold">No of Mandays:  <span class="fw-normal"> <input type="text" disabled value="{{$no_of_mandays}}"></span> </td>
                                            </tr>
                                    
                                            <tr>
                                                <td class="fw-bold"> Signature</td>
                                                <td>........</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold"> Assessor</td>
                                                <td>{{$summeryReport->firstname??''}}  {{$summeryReport->middlename??''}} {{$summeryReport->lastname??''}} ({{$assessor_assign->assessor_designation}})</td>
                                            </tr>
                                        </tbody>
                                    
                                    </table>
                                    <div class="table-responsive">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl. No </th>
                                                    <th>Objective Element</th>
                                                    <th> NC raised</th>
                                                    <th> CAPA by Training Provider</th>
                                                    <th> Document submitted against the NC</th>
                                                    <th> Remarks (Accepted/ Not accepted)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            @foreach($original_data as $key=>$data)
                                            <tr>
                                                <td colspan="6">Course Name: <b>{{ $key ?? '' }}</b></td>
                                            </tr>
                                                @foreach ($data as $key=>$rows)
                                                <tr>
                                                    <td class="fw-bold">{{$rows->code}}</td>
                                                    <td>{{$rows->title}}</td>
                                                    <td class="remove_extra_comma">
                                                    @foreach($rows->nc as $row)
                                                      <span>{{$row->nc_type}}</span><span>,</span>
                                                    @endforeach
                                                    </td>
                                                    <td>
    
                                                    @foreach($rows->nc as $key=>$row)
                                                    @if($row->tp_remark!=null)
                                                        {{$key+1}} : {{ucfirst($row->tp_remark)}},
                                                    @endif
                                                    @endforeach
                                                    </td>
                                                    <td>
                                                    @foreach($rows->nc as $key=>$row)
                                                        <?php 
                                                                $color_code = ["NC1"=>"danger", "NC2"=>"danger", "Accept"=>"success","not_recommended"=>"danger"];
                                                                if (array_key_exists($row->nc_type, $color_code)) {
                                                                    $final_color_value = $color_code[$row->nc_type];
                                                                } else {
                                                                    $final_color_value = "danger";
                                                                }
                                                        ?>
                                                        <a target="_blank" href="{{ asset('level/'.$row->doc_file_name) }}" class="btn btn-{{$final_color_value}} m-1" href="">
                                                            @if($row->nc_type=="not_recommended")
                                                            {{ucfirst($row->nc_type)}}
                                                            @else
                                                            @if($row->assessor_type=='admin')
                                                            {{$row->nc_type}} by Admin
                                                            @else
                                                            {{$row->nc_type}}
                                                            @endif
                                                            
                                                            @endif
                                                        
                                                    </a>  
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
                                            
                                                <tr>
                                                <td colspan="6">
                                                <div class="col-sm-12" id="comment-section">
                                                                    <label for="comment_text" class="">Remark<span class="text-danger">*</span></label>
                                                                    <textarea disabled="true" rows="10" cols="60" id="comment_text" name="doc_comment" class="form-control" required="">{{$summary_remark}}</textarea>
                                                                    
                                                                </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        
                                        </table>
                                    
                                </button>
                                    </div>
                                   
                                </div>
                               
                            </form>
                        </div>
                    </div>
        </div>

            <div>
               
            </div>
    </div>
    </div>
    </div>
    </div>
</section>

