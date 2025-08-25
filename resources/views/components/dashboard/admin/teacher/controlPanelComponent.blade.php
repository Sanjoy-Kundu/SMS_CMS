<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">

        <!-- Total Teachers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <h5>Total Teachers</h5>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span class="totalTeachersCountControlPanel"></span></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <span class="text-primary controlPanelViewTeacherLists" style="cursor: pointer">View Teacher Lists</span>
                </div>
            </div>

        </div>

        <!-- Total Designations -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Designations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
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

                // Destroy old DataTable if exists
                // if ($.fn.DataTable.isDataTable('#admin_teachers_table')) {
                //     $('#admin_teachers_table').DataTable().destroy();
                // }

                // Clear table body
                // $('#admin_teachers_table_body').html('');

                // Append rows
                // teachers.forEach((teacher, index) => {
                //     //console.log(teacher);
                //     const addedBy = teacher.added_by.role === 'editor' ? 'Editor' : 'Admin';
                //     const addedName = teacher.added_by.name;
                //     const row = `
                //         <tr>
                //             <td>${index + 1}</td>
                //             <td>${teacher.user.name}</td>
                //             <td>${teacher.user.email || ''}</td>
                //             <td>${addedName} (${addedBy})</td>
                //             <td>
                //                 <button class="btn btn-sm btn-primary editTeacher" data-id="${teacher.id}">Edit</button>
                //                 <button class="btn btn-sm btn-danger trashTeacher" data-id="${teacher.id}">TRASH</button>
                //             </td>
                //         </tr>
                //     `;
                //     $('#admin_teachers_table_body').append(row);
                // });

            }
        } catch (error) {
            console.error('Error fetching teachers:', error);
        }
    }

    //view teachers lists
    $('.controlPanelViewTeacherLists').on('click', async function (event) {
            event.preventDefault();
            await controlPanelAllTeacherLists();
            $('#controlPanelTeachersListModal').modal('show');

    })
</script>
