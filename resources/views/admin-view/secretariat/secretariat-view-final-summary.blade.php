@include('layout.header')
<title>RAV Accreditation</title>

</head>
<body class="light">
<!-- Progressbar Modal Poup -->
<div class="loading-img d-none" id="loader">
    <div class="box">
        <img src="{{ asset('assets/img/VAyR.gif') }}">
        <h5 class="uploading-text"> Uploading... </h5>
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
@include('layout.topbar')
<div>
@if (Auth::user()->role == '1')
        @include('layout.sidebar')
        @elseif(Auth::user()->role == '2')
        @include('layout.siderTp')
        @elseif(Auth::user()->role == '3')
        @include('layout.sideAss')
        @elseif(Auth::user()->role == '4')
        @include('layout.sideprof')
        @elseif(Auth::user()->role == '5')
        @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
        @include('layout.sidbarAccount')
        @endif
        @include('layout.rightbar')
</div>



<section class="content mb-4">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">View Documents</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{ url('/dashboard') }}">
                                <i class="fas fa-home"></i> Level </a>
                        </li>
                        <li class="breadcrumb-item active">View Documents</li>
                    </ul>
                </div>

            </div>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ session::get('success') }}
            </div>
        @elseif(Session::has('fail'))
            <div class="alert alert-danger" role="alert">
                {{ session::get('fail') }}
            </div>
        @endif


        <div>
              
               
                    <div class="row clearfix">
                        <div class="col-md-12 d-flex p-2 gap-2 flex-row-reverse pe-4">
                            <button class="btn btn-warning" onclick="printDiv('desktop-print')">
                            <i class="fa fa-print"></i>
                            </button>
                        </div>
                        <div class="col-lg-12 col-md-12" id="desktop-print">
                            <form id="submitForm" action="#" method="#">
                                @csrf
                                <input type="hidden" name="application_id" value="{{Request()->segment(3)}}">
                                <input type="hidden" name="application_course_id" value="{{Request()->segment(4)}}">
                                <div class="p-3 bg-white">
                                    <table>
    
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="fw-bold">SECRETARIAT ASSESSMENT FORM</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Application No (provided by ATAB):</br> <span class="fw-normal"> {{$summeryReport->uhid??''}}</span> </td>
                                                <td class="fw-bold">Date of application: </br><span class="fw-normal">{{date('d-m-Y',strtotime($summeryReport->app_created_at))}}</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Name and Location of the Training Provider: <span class="fw-normal"> <input type="text" disabled value="{{$summeryReport->person_name}}"></span> </td>
                                                <td class="fw-bold">Name of the course to be assessed:
                                    
                                                    <span class="fw-normal"> <input type="text" disabled value="{{$summeryReport->course_name}}"></span> </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Way of assessment (Secretariat): </br><span class="fw-normal">
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
                                                <td>{{$summeryReport->firstname??''}}  {{$summeryReport->middlename??''}} {{$summeryReport->lastname??''}} ({{$assessor_assign->assessor_designation??""}})</td>
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
                                                @foreach ($final_data as $key=>$rows)
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
                                                <tr>
                                                <td colspan="6">
                                                <div class="col-sm-12" id="comment-section">
                                                                    <label for="comment_text" class="">Remark<span class="text-danger">*</span></label>
                                                                    <textarea rows="10" cols="60" id="comment_text" name="doc_comment" class="form-control" required="" disabled="true">{{$summary_remark}}</textarea>
                                                                    
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


<script>
    class TabsGroup extends HTMLElement {
    constructor() {
      super();
      this.tabs = this.querySelectorAll('[role="tab"]');
      this.panels = this.querySelectorAll('[role="tabpanel"]');
    }

    get selected() {
      return this.querySelector('[role="tab"][aria-selected="true"]');
    }

    set selected(element) {
      this.selected?.setAttribute('aria-selected', 'false');
      element?.setAttribute('aria-selected', 'true');
      element?.focus();
      this.updateSelected();
    }

    connectedCallback() {
      this.setIds();
      this.updateSelected();
      this.initEvents();
    }

    setIds() {
      this.tabs.forEach((tab, index) => {
        const panel = this.panels[index];

        tab.id ||= `tab-${index}`;
        panel.id ||= `panel-${index}`;

        tab.setAttribute('aria-controls', panel.id);
        panel.setAttribute('aria-labelledby', tab.id);
      });
    }

    updateSelected() {
      this.tabs.forEach((tab, index) => {
        const panel = this.panels[index];
        const isSelected = tab.getAttribute('aria-selected') === 'true';

        tab.setAttribute('aria-selected', isSelected ? 'true' : 'false');
        tab.setAttribute('tabindex', isSelected ? '0' : '-1');
        panel.setAttribute('tabindex', isSelected ? '0' : '-1');
        panel.hidden = !isSelected;
      });
    }

    initEvents() {
      this.tabs.forEach((tab) => {
        tab.addEventListener('click', () => this.selected = tab);

        tab.addEventListener('keydown', (event) => {
          if (event.key === 'ArrowLeft') {
            this.selected = tab.previousElementSibling ?? this.tabs.at(-1);
          } else if (event.key === 'ArrowRight') {
            this.selected = tab.nextElementSibling ?? this.tabs.at(0);
          }
        });
      });
    }
  }

  customElements.define('tabs-group', TabsGroup);
</script>

<script>
    function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
</script>

@include('layout.footer')
