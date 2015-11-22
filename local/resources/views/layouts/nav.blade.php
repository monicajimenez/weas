<div class="row">
    <div class="col s12">
      <nav>
        <!-- Top Banner -->
        <div class="row">
          <div class="col s12">
            <div class="navbar-fixed">
              <nav class="top-nav">
                    <div class="container">
                      <div class="nav-wrapper">
                        <div class="row">
                      <div class="col s2">
                            <a href="#" data-activates="slide-out" class="button-collapse top-nav full hide-on-large-only fixed"><i class="material-icons">view_list</i></a>
                          </div>
                          <div class="col s10 right">
                            <a class="page-title truncate">@yield('pagetitle')</a>
                          </div>
                        </div>
                      </div>
                    </div>
                 </nav> 
            </div>
          </div>
        </div>
        <!-- End: Top Banner -->
        <!-- Side Navigation -->
        <div class="row">
          <div class="col s1">
            <ul id="slide-out" class="side-nav fixed">
              <!-- Logo -->
              <li class="logo"><img class="responsive-img" src="{{ asset('images/logo/aboitizland.png') }}"></li>
              <!-- End: Logo -->
              <!-- Profile -->
                <ul class="collapsible collapsible-accordion">
                  <li class="logo">
                    <a class="collapsible-header waves-effect waves-teal">
                      <div class="row valign-wrapper section">
                        <div class="col s3">
                          <img src="{{ asset('images/user/male_chibi_1.png') }}" alt="" class="circle responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="black-text truncate">
                            @if(Auth::check()){{Auth::user()->app_fname}} {{Auth::user()->app_lname}}
                            @else Hello User!
                            @endif</span>
                        </div>
                      </div>
                    </a>
                    <div class="collapsible-body" style="display: block;">
                      <ul>
                        <li class=""><a href="{{ route('user.profile') }}">Profile</a></li>
                        <li><a href="{{ route('user.logout') }}">Log-out</a></li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- End: Profile -->
              <!-- Dashboard -->
              <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                  <li class=""><a href="{{ route('dashboard') }}" class="collapsible-header waves-effect waves-teal"><i class="material-icons">dashboard</i>Dashboard</a></li>
                </ul>
              </li>
              <!-- End: Dashboard -->
              <!-- Requests -->
              <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                  <li class="">
                      <a class="collapsible-header waves-effect waves-teal"><i class="material-icons">work</i>Requests</a>
                      <div class="collapsible-body" style="display: block;">
                        <ul>
                          <ul class="collapsible collapsible-accordion">
                            <li>
                              <a class="collapsible-header waves-effect waves-teal"><i class="material-icons">input</i>File</a>
                              <div class="collapsible-body" style="display: block;">
                                <ul>
                                  <li class=""><a href="{{ route('request.create', ['request_type' => 'RFC']) }}">RFC</a></li>
                                  <li class=""><a href="{{ route('request.create', ['request_type' => 'RFR']) }}">RFR</a></li>
                                  <li class=""><a href="{{ route('request.create', ['request_type' => 'QAC']) }}">QAC</a></li>
                                </ul>
                              </div>
                            </li>
                          </ul>
                          <ul class="collapsible collapsible-accordion">
                            <li>
                              <a class="collapsible-header waves-effect waves-teal"><i class="material-icons">search</i>View</a>
                              <div class="collapsible-body" style="display: block;">
                                <ul>
                                  <li class=""><a href="{{ route('request.index', ['request_status' => 'pending']) }}">Pending</a></li>
                                  <li class=""><a href="{{ route('request.index', ['request_status' => 'on-hold']) }}">On-Hold</a></li>
                                  <li class=""><a href="{{ route('request.index', ['request_status' => 'reset']) }}">Reset</a></li>
                                  <li><a href="{{ route('request.index', ['request_status' => 'approved']) }}">Approved</a></li>
                                  <li><a href="{{ route('request.index', ['request_status' => 'denied']) }}">Denied</a></li>
                                  <li><a href="{{ route('request.index', ['request_status' => 'all']) }}">All</a></li>
                                </ul>
                              </div>
                            </li>
                          </ul>
                        </ul>
                      </div>
                    </li>
                </ul>
              </li>
              <!-- End: Requests -->
            </ul>
          </div>
        </div>
        <!-- End: Side Navigation -->
      </nav>
    </div>
</div>