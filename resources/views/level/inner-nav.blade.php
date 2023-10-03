    <div class="pt-2">
        <ul class="nav ">

            <li class="nav-item ">
                <a class="nav-link "
                    href="{{ url('/new-applications') }}">New
                    Application</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link"
                    href="{{ url('/appliction-list') }}" >
                    Applications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ url('/pending-payment-list') }}">Pending Payment List</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ url('faq') }}">FAQs</a>
            </li>
        </ul>
    </div>

    <style>
        .nav-link{
            border-radius: 30px !important;
        }
    </style>
