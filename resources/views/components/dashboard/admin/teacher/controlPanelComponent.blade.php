<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">
        <!-- Total Teachers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Teachers
                            </div>
                            <div class="h5 mb-2 font-weight-bold text-gray-800">
                                <span class="totalTeachersCountControlPanel"></span>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <span class="btn btn-sm btn-primary controlPanelViewTeacherLists">View Teachers List</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="{{ asset('/uploads/teacher/icon/teachers.png') }}" 
                                alt="Teachers" 
                                style="width:50px; height:50px; object-fit:contain;">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Total Designations -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Designations
                            </div>
                            <div class="h5 mb-2 font-weight-bold text-gray-800"><span class="designation_count_control_panel">0</span></div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-3">
                                <span class="btn btn-sm btn-success create_designation_btn">Create Designation</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="{{ asset('/uploads/teacher/icon/designations.png') }}" alt="Designation"
                                style="width:50px; height:50px; object-fit:contain;">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pending Approvals -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Approvals</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">7</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects Assigned -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Subjects Assigned</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">35</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
{{-- <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> --}}
<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        getAllTeacherLists();
    });
    //all teacher lists admin and editor
    async function getAllTeacherLists() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert('Unauthorized Access');
            return;
        }
        try {
            const res = await axios.post('/all/teacher/lists', {}, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                const teachers = res.data.allTeachers;
                //console.log(res.data.allTeachers);
                document.querySelector('.totalTeachersCountControlPanel').innerText = teachers.length;
            }
        } catch (error) {
            console.error('Error fetching teachers:', error);
        }
    }


    getDesignationControlPanelLists();
    async function getDesignationControlPanelLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Authorization failed');
            return;
        }


        try {
            let res = await axios.post('/admin/designation/list', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                const designations = res.data.data;
                document.querySelector('.designation_count_control_panel').innerText = designations.length;
            }
        } catch (error) {
            console.log(error);
            Swal.fire("Error!", "Failed to load designations", "error");
        }
    }











    //view teachers lists
    $('.controlPanelViewTeacherLists').on('click', async function(event) {
        event.preventDefault();
        await controlPanelAllTeacherLists();
        $('#controlPanelTeachersListModal').modal('show');

    })


    // create desingnation button
    $('.create_designation_btn').on('click', function(){
        event.preventDefault();
        $('#controlPanelTeacherDesignationsModal').modal('show');
        //console.log('create designation button clicked');
    });
</script>
