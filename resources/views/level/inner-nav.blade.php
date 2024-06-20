<div class="nav-tab">
    <ul class="nav p-3">
        <li class="custom-nav-item ">
            @if(Request::is('level-first') || Request::is('level-one'))
            <a class="custom-nav-link {{request()->is('*level-one*') || request()->is('*level-second*') ||  request()->is('*level-third*') || request()->is('*level-first*') || request()->is('*level-one*') ? 'nav-active' : '' }}" href="#">New Application</a>
            @elseif(Request::is('level-second'))
            <a class="custom-nav-link {{ request()->is('*create-level-2-new-application*') || request()->is('*level-second*') ? 'nav-active' : '' }}" href="#">New Application</a>
            @elseif(Request::is('level-third'))
            <a class="custom-nav-link {{ request()->is('*create-level-3-new-application*') || request()->is('*level-third*') ? 'nav-active' : '' }}" href="#">New Application</a>
            
            @endif
            
        </li>
        <li class="custom-nav-item">
            @php
              if(request()->is('*create-new-course*') || request()->is('*level-first*')){
                $slug = 'level-one';
              }
              else if(request()->is('*create-level-2-new-course*') || request()->is('*level-second*')){
                $slug = 'level-second';
              }else{
                $slug = 'level-third';
              }
            @endphp
            <a class="custom-nav-link {{ request()->is('*tp/application-list*') ? 'nav-active' : '' }}" href="{{ url('/'.$slug.'/tp/application-list') }}">Applications</a>
        </li>

        <li class="custom-nav-item">
        @php
              if(request()->is('*create-new-course*') || request()->is('*level-first*')){
                $slug = 'level-one';
              }
              else if(request()->is('*create-level-2-new-course*') || request()->is('*level-second*')){
                $slug = 'level-second';
              }else{
                $slug = 'level-third';
              }
            @endphp
                <a class="custom-nav-link {{ request()->is('*tp-pending-payment-list*')  || request()->is('course-payment*') ? 'nav-active' : '' }}" 
        href="{{ url('/' . $slug . '/tp-pending-payment-list') }}">
            Pending Payment List
        </a>

        </li>
        <li class="custom-nav-item">
            <a class="custom-nav-link {{ request()->is('faq*') ? 'nav-active' : '' }}" href="{{ url('faq') }}">FAQs</a>
        </li>
    </ul>
</div>

<style>
    /* Add styles for the active class */
    .nav-active {
        background-color: #e91e63 !important;
        /* Change this to your desired active background color */
        color: #ffffff !important;
        /* Change this to your desired active text color */
        border-radius: 20px;
    }

    /* Add hover effect for all nav links except the active link */
    .custom-nav-item:not(.nav-active):hover .custom-nav-link {
        background-color: #e91e63;
        /* Change this to your desired hover background color */
        color: #ffffff !important;
        /* Change this to your desired hover text color */
        border-radius: 20px;
    }

    /* Add border-radius to all nav links */
    .custom-nav-link {
        border-radius: 20px !important;
        /* Apply border-radius to all nav links */
        margin-left: 3px;
        margin-right: 3px;
    }

    a.custom-nav-link{
        color: #fff;
    }
    .custom-nav-item {
        margin-left: 10px;
    }

</style>
