<div class="sidebar" data-color="official" style="background:rgba(0,0,0,0.8) !important; ">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
  <div class="logo">
    <a href="#" class="simple-text logo-normal">
      Admin Panel
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item  {{Request::is('admin/dashboard')? "active":" "}} ">
        <a class="nav-link" href="/admin/dashboard">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item {{Request::is('admin/portfolio')? "active":" "}} ">
        <a class="nav-link" href="/admin/portfolio">
          <i class="material-icons">account_box</i>
          <p>Portfolio</p>
        </a>
      </li>
      {{-- <li class="nav-item {{Request::is('admin/adminlist')? "active": ""}} ">
        <a class="nav-link" href="/admin/adminlist">
          <i class="material-icons">people</i>
          <p>User/Admin List</p>
        </a>
      </li> --}}
      <li class="nav-item text-white {{Request::is('admin/adminlist','admin/permission')? "active": ""}}">
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="material-icons">people</i>
                  <p class="d-inline">Admins</p></a>
                <ul class="collapse list-unstyled" id="pageSubmenu" >
                    <li class="nav-item ml-4 mt-1 {{Request::is('admin/adminlist')? "active": ""}}">
                        <a class="nav-link" href="/admin/adminlist">  <i class="material-icons">recent_actors</i>Admin List</a>
                    </li>
                    <li class="nav-item ml-4 {{Request::is('admin/permission')? "active" : ""}}">
                        <a class="nav-link" href="/admin/permission">  <i class="material-icons">lock_open</i>Roles & Permissions</a>
                    </li>

                </ul>
            </li>

      <li class="nav-item {{Request::is('admin/skill')? "active": ""}} ">
        <a class="nav-link" href="/admin/skill">
          <i class="material-icons">developer_mode</i>
          <p>Skills</p>
        </a>
      </li>

      <li class="nav-item {{Request::segment(2)=='project'? "active" : "" }}">
        <a class="nav-link" href="/admin/project">
          <i class="material-icons">desktop_mac</i>
          <p>Projects</p>
        </a>
      </li>

      <li class="nav-item {{Request::is('admin/testimonial') ? "active" : ""}} ">
        <a class="nav-link" href="/admin/testimonial">
          <i class="material-icons">feedback</i>
          <p>Testimonials</p>
        </a>
      </li>
      <li class="nav-item {{Request::is('admin/message') ? "active" : ""}}">
        <a class="nav-link" href="/admin/message">
          <i class="material-icons">send</i>
          <p>Messages</p>
        </a>
      </li>
      <!-- <li class="nav-item active-pro ">
            <a class="nav-link" href="./upgrade.html">
                <i class="material-icons">unarchive</i>
                <p>Upgrade to PRO</p>
            </a>
        </li> -->
    </ul>
  </div>
</div>
