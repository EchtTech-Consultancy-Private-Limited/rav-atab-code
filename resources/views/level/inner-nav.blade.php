<div class="nav-tab">
    <ul class="nav p-3">
        <li class="custom-nav-item ">
            <a class="custom-nav-link {{ request()->is('create-new-application*') || request()->is('create-course*') ? 'nav-active' : '' }}" href="{{ url('/create-new-applications') }}">New Application</a>
        </li>
        <li class="custom-nav-item">
            <a class="custom-nav-link {{ request()->is('/tp/application-list*') ? 'nav-active' : '' }}" href="{{ url('/tp/application-list') }}">Applications</a>
        </li>
        <li class="custom-nav-item">
            <a class="custom-nav-link {{ request()->is('pending-payment-list*') || request()->is('edit-application*') || request()->is('course-payment*') ? 'nav-active' : '' }}" href="{{ url('/pending-payment-list') }}">Pending Payment List</a>

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
