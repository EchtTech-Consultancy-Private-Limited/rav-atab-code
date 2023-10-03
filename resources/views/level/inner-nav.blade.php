<div>
    <ul class="nav p-2">
        <li class="custom-nav-item {{ request()->is('new-applications*') ? 'nav-active' : '' }}">
            <a class="custom-nav-link" href="{{ url('/new-applications') }}">New Application</a>
        </li>
        <li class="custom-nav-item {{ request()->is('application-list*') ? 'nav-active' : '' }}">
            <a class="custom-nav-link" href="{{ url('/application-list') }}">Applications</a>
        </li>
        <li class="custom-nav-item {{ request()->is('pending-payment-list*') ? 'nav-active' : '' }}">
            <a class="custom-nav-link" href="{{ url('/pending-payment-list') }}">Pending Payment List</a>
        </li>
        <li class="custom-nav-item {{ request()->is('faq*') ? 'nav-active' : '' }}">
            <a class="custom-nav-link" href="{{ url('faq') }}">FAQs</a>
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

</style>
