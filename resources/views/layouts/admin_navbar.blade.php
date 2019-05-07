
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg fixed-top navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <span class="navbar-brand">{{$page_title}}</span>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>@if(Auth::guard('admin')->user()->notifications->count() > 0)<span class="badge badge-danger notification-badge">{{Auth::guard('admin')->user()->notifications->count()}}</span>@endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                                @if(Auth::guard('admin')->user()->notifications->count() > 0)
                                    @foreach(Auth::guard('admin')->user()->notifications as $notification)
                                    <a class="dropdown-item" href="#">
                                        <div class="notification-item">
                                            <span class="notification-title">{{$notification->data['title']}}</span>
                                            <p class="notification-body">{{$notification->data['message']}}</p>
                                            <p class="notification-time">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</p>
                                        </div>
                                        </a>
                                    @endforeach
                                    <a class="dropdown-item notification-view-all">View All Notifications</a>
                                    @else
                                    <i class="dropdown-item">No new notifications</i>
                                @endif
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="round" width="30" height="30" avatar="{{Auth::guard('admin')->user()->firstname}} {{Auth::guard('admin')->user()->lastname}}" />
                                    <p>
                                        <span class="d-lg-none d-md-block">Profile</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    <a class="dropdown-item" href="/admin/logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->