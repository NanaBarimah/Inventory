<div class="sidebar" data-color="blue">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li>
                <a href="/admin">
                    <i class="now-ui-icons business_bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="now-ui-icons business_chart-bar-32"></i>
                    <p>Reports</p>
                </a>
                </li>
                @if(Auth::guard('admin')->user()->role == 'Admin')
                <li>
                    <a href="/admin/districts">
                        <i class="now-ui-icons location_pin"></i>
                            <p>Districts
                        </p>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/admin/hospitals">
                        <i class="now-ui-icons health_ambulance"></i>
                        <p>Hospitals
                        </p>
                    </a>
            </li>
            @if(Auth::guard('admin')->user()->role == 'Admin')
                <li>
                    <a href="/admin/requests">
                        <i class="now-ui-icons ui-2_settings-90"></i>
                            <p>Maintenance Requests
                        </p>
                    </a>
                </li>
                <li>
                    <a href="/admin/equipment-types">
                        <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>Categories
                        </p>
                    </a>
                </li>
                <li>
                    <a href="/admin/engineers">
                        <i class="now-ui-icons users_single-02"></i>
                            <p>Engineers
                        </p>
                    </a>
                </li>
            @endif
            @if(Auth::guard('admin')->user()->role == 'Biomedical Engineer')
                <li>
                    <a href="/admin/assigned">
                        <i class="now-ui-icons users_single-02"></i>
                            <p>Assigned Jobs
                        </p>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>