
        <div class="sidebar" data-color="blue">
            <div class="logo">
                <a href="#" class="simple-text logo-normal">
                    {{session('hospital')->name}}
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
                        <a href="/home">
                            <i class="now-ui-icons business_bank"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
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
                                        <span class="sidebar-normal">All Inventory Items</span>
                                    </a>
                                </li>
                                @if(strtolower(Auth::user()->role) != 'hospital admin')
                                <li>
                                    <a href="/inventory/add">
                                        <span class="sidebar-normal">Add New Item</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'storekeeper')
                    <li>
                        <a data-toggle="collapse" href="#categoryList">
                            <i class="now-ui-icons health_ambulance"></i>
                            <p>My Hospital
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="categoryList">
                            <ul class="nav">
                                <li>
                                    <a href="/departments">
                                        <span class="sidebar-normal">Departments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/units">
                                        <span class="sidebar-normal">Units</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/vendors">
                                        <span class="sidebar-normal">Service Vendors</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#hospitalDetailsModal">
                                        <p>Hospital Info</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if(strtolower(Auth::user()->role) != 'storekeeper')
                    <li>
                        <a data-toggle="collapse" href="#maintenanceList">
                            <i class="now-ui-icons ui-2_settings-90"></i>
                            <p>Maintenance
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="maintenanceList">
                            <ul class="nav">
                                @if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer')
                                <li>
                                    <a href="/maintenance">
                                        <span class="sidebar-normal">New Maintenance Report</span>
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="/request-maintenance">
                                        <span class="sidebar-normal">Request Maintenance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/maintenance/history">
                                        <span class="sidebar-normal">Maintenance History</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/approve">
                                        <span class="sidebar-normal">Maintenance Approvals</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if(strtolower(Auth::user()->role) != 'storekeeper')
                    <li>
                        <a href="/reports">
                            <i class="now-ui-icons business_chart-pie-36"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    @endif
                    @if(strtolower(Auth::user()->role) != 'storekeeper' && strtolower(Auth::user()->role) != 'hospital admin')
                    <li>
                        <a href="/schedule">
                            <i class="now-ui-icons ui-1_calendar-60"></i>
                            <p>Scheduler</p></a>
                    </li>
                    @endif
                    @if(strtolower(Auth::user()->role) == 'admin')
                    <li>
                        <a data-toggle="collapse" href="#usersList">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>Users
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="usersList">
                            <ul class="nav">
                                <li>
                                    <a href="/users">
                                        <span class="sidebar-normal">All Users</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/users/add">
                                        <span class="sidebar-normal">Add New User</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="/settings">
                            <i class="now-ui-icons ui-1_settings-gear-63"></i>
                            <p>Reminder Settings</p></a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>