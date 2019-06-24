
        <div class="sidebar" data-color="blue">
            <div class="logo">
                <a href="#" class="simple-text logo-normal">
                    {{session('hospital')->name}}
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
                        <a data-toggle="collapse" href="#maintenanceList">
                            <i class="now-ui-icons ui-2_settings-90"></i>
                            <p>Work Orders
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="maintenanceList">
                            <ul class="nav">
                                <li>
                                    <a href="/maintenance">
                                        <span class="sidebar-normal">New Maintenance Report</span>
                                    </a>
                                </li>
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
                                    <a href="/schedule">
                                        <p>Scheduler</p></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="/requests">
                            <i class="now-ui-icons travel_info"></i>
                            <p>Requests</p>
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
                    <li>
                        <a href="/departments">
                            <i class="now-ui-icons health_ambulance"></i>
                            <p>Departments & Units</p>
                        </a>
                    </li>
                    <li>
                        <a href="/vendors">
                            <i class="now-ui-icons shopping_delivery-fast"></i>
                            <p>Service Vendors</p>
                        </a>
                    </li>
                    <li>
                        <a href="/purchase-orders">
                            <i class="now-ui-icons shopping_cart-simple"></i>
                            <p>Purchase Orders</p>
                        </a>
                    </li>
                    <li>
                        <a href="/reports">
                            <i class="now-ui-icons business_chart-pie-36"></i>
                            <p>Reports</p>
                        </a>
                    </li>
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
                        <a href="/categories">
                            <i class="now-ui-icons files_single-copy-04 "></i>
                            <p>Categories</p></a>
                        </li>
                    <li>
                        <a href="/settings">
                            <i class="now-ui-icons ui-1_settings-gear-63"></i>
                            <p>Reminder Settings</p></a>
                    </li>
                </ul>
            </div>
        </div>