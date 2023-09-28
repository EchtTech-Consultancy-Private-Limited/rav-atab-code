<div class="profile-tab-box">
    <div class="">
        <ul class="nav ">

            <li class="nav-item tab-all ">
                <a class="nav-link"
                    href="{{ url('/new-applications') }}">New
                    Application</a>
            </li>
            <li class="nav-item tab-all ">
                <a class="nav-link"
                    href="{{ url('/appliction-table') }}" >
                    Applications</a>
            </li>
            <li class="nav-item tab-all">
                <a class="nav-link {{ isset($form_step_type) ? ($form_step_type == 'add-course' ? 'active' : '') : '' }}"
                    href="#pending_payment_list" data-bs-toggle="tab">Pending Payment List</a>
            </li>
            <li class="nav-item tab-all ">
                <a class="nav-link" href="#faqs" data-bs-toggle="tab">FAQs</a>
            </li>
        </ul>
    </div>
</div>
