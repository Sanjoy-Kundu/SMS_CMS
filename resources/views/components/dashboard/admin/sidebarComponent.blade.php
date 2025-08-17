   <!-- Page Wrapper -->
   <div id="wrapper">

       <!-- Sidebar -->
       <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #007B7F;">

           <!-- Sidebar - Brand -->
           <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
               {{-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> --}}
               <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
           </a>

           <!-- Divider -->
           <hr class="sidebar-divider my-0">

           <!-- Nav Item - Dashboard -->
           <li class="nav-item active">
               <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                   <i class="fas fa-fw fa-tachometer-alt"></i>
                   <span>Dashboard</span></a>
           </li>

           <!-- Divider -->
           <hr class="sidebar-divider">

           <!-- Heading -->
           {{-- <div class="sidebar-heading">
                Interface
            </div> --}}

           <!-- Nav Item - Institutioin Collapse Menu -->
           <li class="nav-item {{ Request::is('institution') ? 'active' : '' }}">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAcademic"
                   aria-expanded="false" aria-controls="collapseAcademic">
                   <i class="fas fa-fw fa-school"></i>
                   <span>Academic Management</span>
               </a>
               <div id="collapseAcademic" class="collapse {{ Request::is('institution') ? 'show' : '' }}"
                   data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header">Manage Academic Data:</h6>
                       <a class="collapse-item {{ Request::is('institution') ? 'active' : '' }}"
                           href="{{ url('/institution') }}">Institutions</a>
                       <a class="collapse-item {{ Request::is('academic') ? 'active' : '' }}"
                           href="{{ url('/academic') }}">Academic Sections</a>
                       <a class="collapse-item {{ Request::is('classes') ? 'active' : '' }}"
                           href="{{ url('/classes') }}">Classes</a>
                       <a class="collapse-item {{ Request::is('class/division') ? 'active' : '' }}"
                           href="{{ url('/class/division') }}">Divisions</a>

                       <a class="collapse-item {{ Request::is('class/subject') ? 'active' : '' }}"
                           href="{{ url('/class/subject') }}">Subjects</a>
                       <a class="collapse-item {{ Request::is('subject/paper') ? 'active' : '' }}"
                           href="{{ url('/subject/paper') }}">Subject Paper</a>
                       <a class="collapse-item {{ Request::is('class/overview') ? 'active' : '' }}"
                           href="{{ url('/class/overview') }}" target="_blank">Over View</a>
                   </div>
               </div>
           </li>

           {{-- Nav Item  - Editor Collapse Menu --}}
           <li class="nav-item {{ Request::is('editor/create') ? 'active' : '' }}">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEditor"
                   aria-expanded="false" aria-controls="collapseEditor">
                   <i class="fas fa-fw fa-user-edit"></i>
                   <span>Editor Management</span>
               </a>
               <div id="collapseEditor" class="collapse {{ Request::is('editor/create') ? 'show' : '' }}"
                   data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header">Manage Editors:</h6>

                       <a class="collapse-item {{ Request::is('editors') ? 'active' : '' }}"
                           href="{{ url('/editors') }}">All Editors</a>
                       <a class="collapse-item {{ Request::is('editor/create') ? 'active' : '' }}"
                           href="{{ url('/editor/create') }}">Create Editor</a>
                       <a class="collapse-item {{ Request::is('editors/control/panel') ? 'active' : '' }}"
                           href="{{ url('/editors/permissions') }}">Control Panel</a>
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
