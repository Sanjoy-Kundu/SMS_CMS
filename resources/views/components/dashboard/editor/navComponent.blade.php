<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">


        <nav class="navbar navbar-expand topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>


                {{-- <div class="topbar-divider d-none d-sm-block"></div> --}}

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-white-800 dashboard_name"  style="font-size:20px;"></span>
                        <img class="img-profile rounded-circle nav_profile_image" src="">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{url('/editor/profile')}}" target="_blank">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i>
                            <span class="dashboard_email"></span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick="logout(event)" style="cursor: pointer">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>


        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            getUserInfor();
            async function getUserInfor() {
                let token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/editor/login';
                    return;
                }
                try {
                    let res = await axios.post('/auth/editor/details', {}, {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });


                    if (res.data.status === 'success') {
                        //console.log('==',)
                        let editorImage = res.data.data.editors[0].image;
                        //console.log(editorImage);
                        document.querySelector('.dashboard_name').innerHTML = res.data.data.name ? res.data.data.name :'Not Found';
                        document.querySelector('.dashboard_email').innerHTML = res.data.data.email ? res.data.data.email :'Not Found';
                       document.querySelector('.nav_profile_image').src = editorImage
                        ? `/uploads/editor/profile/${editorImage}`
                        : '/uploads/editor/profile/default.png';
                    }

                    if (res.data.status === 'error') {
                        localStorage.removeItem('token');
                        alet('Error', res.data.message);
                        window.location.href = '/editor/login';
                        return;
                    }
                } catch (error) {
                    console.error('error', error);
                    Swal.fire('Error', 'Authentication failed. Please login again.', 'error').then(() => {
                        localStorage.removeItem('token');
                        window.location.href = '/editor/login';
                    });
                }
            }




            async function logout(event) {
                event.preventDefault();

                let token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/editor/login';
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out from this session!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        try {
                            let res = await axios.post('/editor/logout',{},{
                                headers: {
                                    'Authorization': `Bearer ${token}`
                                }
                            });

                            if (res.data.status === 'success') {
                                localStorage.removeItem('token');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Logged out!',
                                    text: 'You have been logged out successfully.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '/editor/login';
                                });
                            } else {
                                Swal.fire('Error', 'Logout failed. Please try again.', 'error');
                            }

                        } catch (error) {
                            console.error('Logout error:', error);
                            Swal.fire('Error', 'Logout failed. Please try again.', 'error');
                        }
                    }
                });
            }
        </script>
