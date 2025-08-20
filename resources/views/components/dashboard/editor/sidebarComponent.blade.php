   <!-- Page Wrapper -->
   <div id="wrapper">

       <!-- Sidebar -->
       <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #007B7F;">

           <!-- Sidebar - Brand -->
           <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
               {{-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> --}}
               <div class="sidebar-brand-text mx-3">EDITOR PANEL</div>
           </a>

           <!-- Divider -->
           <hr class="sidebar-divider my-0">

           <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('editor/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/editor/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>


           <!-- Divider -->
           <hr class="sidebar-divider">

           <!-- Heading -->
           {{-- <div class="sidebar-heading">
                Interface
            </div> --}}


           {{-- Nav Item  - Editor Collapse Menu --}}
           <li class="nav-item {{ Request::is('editor/profile') ? 'active' : '' }}">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEditor"
                   aria-expanded="{{ Request::is('editor/profile') ? 'true' : 'false' }}"
                   aria-controls="collapseEditor">
                   <i class="fas fa-fw fa-user-edit"></i>
                   <span>My Profile</span>
               </a>
               <div id="collapseEditor" class="collapse {{ Request::is('editor/profile') ? 'show' : '' }}"
                   data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header">Manage Profile:</h6>
                       <a class="collapse-item {{ Request::is('editor/profile') ? 'active' : '' }}"
                           href="{{ url('/editor/profile') }}">
                           View Profile
                       </a>
                   </div>
               </div>
           </li>


              <li class="nav-item {{ Request::is('teachers') || Request::is('editor/teacher/create') ? 'active' : '' }}">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeacher"
                   aria-expanded="false" aria-controls="collapseTeacher">
                   <i class="fas fa-fw fa-chalkboard-teacher"></i>
                   <span>Teacher Management</span>
               </a>
               <div id="collapseTeacher"
                   class="collapse {{ Request::is('teachers') || Request::is('editor/teacher/create') ? 'show' : '' }}"
                   data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header">Manage Teachers:</h6>

                       <a class="collapse-item {{ Request::is('teachers') ? 'active' : '' }}"
                           href="{{ url('/teachers') }}">All Teachers</a>

                       <a class="collapse-item {{ Request::is('editor/teacher/create') ? 'active' : '' }}"
                           href="{{ url('/editor/teacher/create') }}">Create Teacher</a>

                       <a class="collapse-item {{ Request::is('teachers/permissions') ? 'active' : '' }}"
                           href="{{ url('/teachers/permissions') }}">Control Panel</a>
                   </div>
               </div>
           </li>





           <!-- Nav Item - Tables -->
           <li class="nav-item">
               <a class="nav-link" href="tables.html">
                   <i class="fas fa-fw fa-table"></i>
                   <span>Tables</span></a>
           </li>

           <!-- Divider -->
           <hr class="sidebar-divider d-none d-md-block">

           <!-- Sidebar Toggler (Sidebar) -->
           <div class="text-center d-none d-md-inline">
               <button class="rounded-circle border-0" id="sidebarToggle"></button>
           </div>
       </ul>
       {{-- 
        first sidebar 
        second navbar
        third mainComponent
        fourth footerComponent
        --}}
