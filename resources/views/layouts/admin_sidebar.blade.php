<div class="sidebar" data-color="blue">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="/" class="simple-text logo-normal">
                {{Auth::guard("admin")->user()->region->name}}
            </a>
        </div>
        <ul class="nav">
            <li>
                <a href="/admin">
                    <i class="now-ui-icons business_bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
        </ul>
    </div>
</div>