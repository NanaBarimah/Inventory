@php
$auth_user = Auth::user();
@endphp
        <div class="sidebar" data-color="blue">
            <div class="logo">
                <a href="/" class="simple-text logo-normal">
                    {{session('hospital')->name}}
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'Limited Technician')
                        <li>
                            <a data-toggle="collapse" href="#maintenanceList">
                                <i class="now-ui-icons ui-2_settings-90"></i>
                                <p>Maintenance
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="maintenanceList">
                                <ul class="nav">
                                    
                                    <li>
                                        <a href="/work-orders">
                                            <span class="sidebar-normal">Work Orders</span>
                                        </a>
                                    </li>
                                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician')
                                    <li>
                                        <a data-toggle="collapse" href="#pms">
                                            <p>Preventive Maintenance
                                                <b class="caret"></b>
                                            </p>
                                        </a>
                                        <div class="collapse" id="pms">
                                            <ul class="nav">
                                                <li>
                                                    <a href="/pm-schedules">
                                                        <span class="sidebar-normal">PM types</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/pm-schedule/record">
                                                        <span class="sidebar-normal">Record PM</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="/schedule">
                                            <p>View Schedule</p></a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li>
                        <a href="/requests">
                            <i class="now-ui-icons travel_info"></i>
                            <p>Requests</p>
                        </a>
                    </li>
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'Hospital Head')
                        <li>
                            <a data-toggle="collapse" href="#inventoryList">
                                <i class="now-ui-icons design_bullet-list-67"></i>
                                <p>Inventory
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="inventoryList">
                                <ul class="nav">
                                    <li>
                                        <a href="/inventory">
                                            <span class="sidebar-normal">Equipment</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/spare-parts">
                                            <span class="sidebar-normal">Spare Parts</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'View Only')
                        <li>
                            <a href="/departments">
                                <i class="now-ui-icons health_ambulance"></i>
                                <p>Departments & Units</p>
                            </a>
                        </li>
                    @endif
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician')
                        <li>
                            <a href="/vendors">
                                <i class="now-ui-icons shopping_delivery-fast"></i>
                                <p>Service Vendors</p>
                            </a>
                        </li>
                    @endif
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician')
                        <li>
                            <a href="/purchase-orders">
                                <i class="now-ui-icons shopping_cart-simple"></i>
                                <p>Purchase Orders</p>
                            </a>
                        </li>
                    @endif
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'Hospital Head')
                        <li>
                            <a href="/reports">
                                <i class="now-ui-icons business_chart-pie-36"></i>
                                <p>Reports</p>
                            </a>
                        </li>
                    @endif
                    @if($auth_user->role == 'Admin')
                        <li>
                            <a href="/users">
                                <i class="now-ui-icons users_single-02"></i>
                                <p>Users
                                </p>
                            </a>
                        </li>
                    @endif
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician')
                        <li>
                            <a href="/categories">
                                <i class="now-ui-icons files_single-copy-04 "></i>
                                <p>Categories</p></a>
                        </li>
                    @endif
                    @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician')
                        <li>
                            <a href="/settings">
                                <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                <p>Settings</p></a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>