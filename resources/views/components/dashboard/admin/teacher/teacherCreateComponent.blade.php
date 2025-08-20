<style>
    /* Loader Overlay for form card */
    .loader-overlay {
        display: none;
        /* hidden initially */
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        /* transparent white */
        z-index: 10;
        border-radius: 0.35rem;
        /* same as card border */
    }

    /* Loader bar animation */
    .loader-bar {
        height: 4px;
        width: 100%;
        --c: no-repeat linear-gradient(#6100ee 0 0);
        background: var(--c), var(--c), #d7b8fc;
        background-size: 60% 100%;
        animation: l16 3s infinite;
        position: absolute;
        top: 0;
        left: 0;
    }


    .table-loader-overlay .loader-bar {
        height: 4px;
        width: 100%;
        --c: no-repeat linear-gradient(#6100ee 0 0);
        background: var(--c), var(--c), #d7b8fc;
        background-size: 60% 100%;
        animation: l16 3s infinite;
        position: absolute;
        top: 0;
        left: 0;
    }


    @keyframes l16 {
        0% {
            background-position: -150% 0, -150% 0
        }

        66% {
            background-position: 250% 0, -150% 0
        }

        100% {
            background-position: 250% 0, 250% 0
        }
    }
</style>

<div class="container-fluid">
    <div class="row">

        <!-- Left Column: techer Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 position-relative">
                <!-- Loader Overlay -->
                <div class="loader-overlay" id="loader">
                    <div class="loader-bar"></div>
                </div>
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-primary font-weight-bold">Create A New Teacher</h5>
                </div>
                <div class="card-body">
                    <form id="teacherForm">
                        <div class="form-group" hidden>
                            <label for="name">Institution Id</label>
                            <<input type="hidden" id="teacher_institution_id" name="institution_id">
                                <span id="teacher_institution_id_error" class="text-danger small"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">Teacher Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter teacher name">
                            <span id="teacher_name_error" class="text-danger small"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">Teacher Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter teacher Email">
                            <span id="teacher_email_error" class="text-danger small"></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn">Add teacher</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: teacher Tables -->
        <div class="col-xl-7 col-md-6 mb-4">

            <!-- Active teachers -->
            <div class="card border-left-success shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-success font-weight-bold">Teachers Lists</h5>
                    <p class="m-0 text-info font-weight-bold">Total Teachers: <span class="totalTeachersCount">0</span>
                    </p>
                </div>
                <div class="card-body">
                    <!-- Loader overlay for teacher table -->
                    <div class="table-loader-overlay" id="tableLoader"
                        style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:5;">
                        <div class="loader-bar"></div>
                    </div>
                    <div class="table-responsive position-relative">
                        <table class="table table-bordered table-hover table-sm" id="admin_teachers_table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="admin_teachers_table_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Trash teachers -->
            <div class="card border-left-danger shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-danger font-weight-bold">Trash teachers List</h5>
                    <p class="m-0 text-info font-weight-bold">Total Teachers: <span class="totalTrashTeachersCount">0</span>
                </div>
                <div class="card-body">
                         <div class="table-loader-overlay" id="trashTableLoader"
                        style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:5;">
                        <div class="loader-bar"></div>
                    </div>
                    <div class="table-responsive position-relative">
                        <table class="table table-bordered table-hover table-sm" id="admin_trash_teachers_table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="admin_trash_teachers_table_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>






{{-- <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    let token = localStorage.getItem('token');

    if (!token) {
        alert('Unauthorized Access');
    } else {
            loadInstitutions();
    }
    loadInstitutions();
    async function loadInstitutions() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized Access');
            return;
        }
        try {
            const response = await axios.post('/institution/details/for/admin/editor', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });


            if (response.data.status === 'success') {
                const institutions = response.data.data;
                if (institutions.length > 0) {
                    // যদি single input field ব্যবহার করছেন:
                    document.getElementById('teacher_institution_id').value = institutions[0].id;
                    //console.log(institutions[0].id);
                } else {
                    alert('No institution found');
                }
            }


        } catch (error) {
            console.error('Error fetching institutions:', error);
        }
    }


    $(document).ready(function() {
        getAllTeacherLists();
    });

    async function getAllTeacherLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized Access');
            return;
        }

        try {
            let res = await axios.post('/all/teacher/lists', {}, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                const teachers = res.data.allTeachers;

                // Destroy old DataTable if exists
                if ($.fn.DataTable.isDataTable('#admin_teachers_table')) {
                    $('#admin_teachers_table').DataTable().destroy();
                }

                // Clear table body
                $('#admin_teachers_table_body').html('');

                // Append new rows
                teachers.forEach((teacher, index) => {
                    const addedBy = teacher.role === 'editor' ? 'Editor' : 'Owner';
                    const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${teacher.name || ''}</td>
                        <td>${teacher.email || ''}</td>
                        <td>${addedBy}</td>
                        <td>
                            <button class="btn btn-sm btn-primary editTeacher" data-id="${teacher.id}">Edit</button>
                            <button class="btn btn-sm btn-danger deleteTeacher" data-id="${teacher.id}">Delete</button>
                        </td>
                    </tr>
                `;
                    $('#admin_teachers_table_body').append(row);
                });

                // Initialize DataTable
                $('#admin_teachers_table').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }

        } catch (error) {
            console.error('Error fetching teachers:', error);
        }
    }






    async function teacherCreate(event) {
        event.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized Access');
            return;
        }

        //     // Clear previous errors
        document.getElementById('teacher_name_error').innerText = '';
        document.getElementById('teacher_email_error').innerText = '';
        document.getElementById('teacher_institution_id_error').innerText = '';

        // Get form data
        let name = document.getElementById('name').value.trim();
        let email = document.getElementById('email').value.trim();
        let institution_id = document.getElementById('teacher_institution_id').value.trim();

        // Validation
        let isError = false;
        if (!name) {
            document.getElementById('teacher_name_error').innerText = 'Name is required';
            isError = true;
        }
        if (!email) {
            document.getElementById('teacher_email_error').innerText = 'Email is required';
            isError = true;
        }
        if (!institution_id) {
            document.getElementById('teacher_institution_id_error').innerText = 'Institution is required';
            isError = true;
        }
        if (isError) return;

        let data = {
            name: name,
            email: email,
            institution_id: institution_id,
        };

        // Show loader & disable form
        document.getElementById('loader').style.display = 'block';
        const formElements = document.getElementById('teacherForm').elements;
        for (let el of formElements) el.disabled = true;

        try {
            const res = await axios.post('/teacher/store', data, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                Swal.fire('Success', res.data.message, 'success');
                // Reset form
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
                // Optionally reload teacher list here
            }
        } catch (error) {
            if (error.response) {
                if (error.response.status === 422) {
                    const errors = error.response.data.errors || {};
                    document.getElementById('teacher_name_error').innerText = errors.name ? errors.name[0] : '';
                    document.getElementById('teacher_email_error').innerText = errors.email ? errors.email[0] : '';
                    document.getElementById('teacher_institution_id_error').innerText = errors.institution_id ?
                        errors
                        .institution_id[0] : '';

                    if (error.response.data.message && !errors.name && !errors.email && !errors.institution_id) {
                        Swal.fire('Error', error.response.data.message, 'error');
                    }
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            } else {
                Swal.fire('Error', 'Network or server error', 'error');
            }
        } finally {
            document.getElementById('loader').style.display = 'none';
            for (let el of formElements) el.disabled = false;
        }
    }
</script> --}}
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Load institution id
    loadInstitutions();
    async function loadInstitutions() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized Access');
            return;
        }
        try {
            const response = await axios.post('/institution/details/for/admin/editor', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                const institutions = response.data.data;
                if (institutions.length > 0) {
                    $('#teacher_institution_id').val(institutions[0].id);
                } else {
                    alert('No institution found');
                }
            }
        } catch (error) {
            console.error('Error fetching institutions:', error);
        }
    }

    // Fetch & show teacher list
    $(document).ready(function() {
        getAllTeacherLists();
        getAllTeacherTrashLists();
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
                document.querySelector('.totalTeachersCount').innerText = teachers.length;

                // Destroy old DataTable if exists
                if ($.fn.DataTable.isDataTable('#admin_teachers_table')) {
                    $('#admin_teachers_table').DataTable().destroy();
                }

                // Clear table body
                $('#admin_teachers_table_body').html('');

                // Append rows
                teachers.forEach((teacher, index) => {
                    //console.log(teacher.added_by.role);
                    const addedBy = teacher.added_by.role === 'editor' ? 'Editor' : 'Admin';
                    const addedName = teacher.added_by.name;
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${teacher.user.name}</td>
                            <td>${teacher.user.email || ''}</td>
                            <td>${addedName} (${addedBy})</td>
                            <td>
                                <button class="btn btn-sm btn-primary editTeacher" data-id="${teacher.id}">Edit</button>
                                <button class="btn btn-sm btn-danger trashTeacher" data-id="${teacher.id}">TRASH</button>
                            </td>
                        </tr>
                    `;
                    $('#admin_teachers_table_body').append(row);
                });

                // Edit / Delete handlers
                $(document).on('click', '.editTeacher', async function() {
                    const teacherId = $(this).data('id');
                    console.log('Edit teacher:', teacherId);
                    await fillAdminTeacherForm(teacherId);
                    $('#adminTeacherEditModal').modal('show');
                });

                $(document).on('click', '.trashTeacher', async function() {
                    const id = $(this).data('id');

                    const confirm = await Swal.fire({
                        title: 'Are you sure?',
                        text: "This teacher will be trashed!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, trash'
                    });

                    if (!confirm.isConfirmed) return;

                    // Show loader on table
                    $('#tableLoader').show();

                    try {
                        const res = await axios.post('/admin/teacher/trash-by-id', {
                            id: id
                        }, {
                            headers: {
                                Authorization: 'Bearer ' + token
                            }
                        });

                        if (res.data.status === 'success') {
                            Swal.fire('Trashed!', res.data.message, 'success');

                            await getAllTeacherLists(); // reload table
                            await getAllTeacherTrashLists(); // reload trash table
                        } else {
                            Swal.fire('Error', res.data.message || 'Trash failed', 'error');
                        }
                    } catch (err) {
                        Swal.fire('Error', 'Server or network error', 'error');
                    } finally {
                        $('#tableLoader').hide();
                    }
                });







                // Initialize DataTable
                $('#admin_teachers_table').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }
        } catch (error) {
            console.error('Error fetching teachers:', error);
        }
    }

    //get all trash teacher lists admin or editor
    async function getAllTeacherTrashLists() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert('Unauthorized Access');
            return;
        }
        try {
            const res = await axios.post('/all/teacher/trash/lists', {}, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                const teachers = res.data.trashTeachers;
                document.querySelector('.totalTrashTeachersCount').innerText = teachers.length;

                // Destroy old DataTable if exists
                if ($.fn.DataTable.isDataTable('#admin_trash_teachers_table')) {
                    $('#admin_trash_teachers_table').DataTable().destroy();
                }

                // Clear table body
                $('#admin_trash_teachers_table_body').html('');

                // Append rows
                teachers.forEach((teacher, index) => {
                    //console.log(teacher.added_by.role);
                    const addedBy = teacher.added_by.role === 'editor' ? 'Editor' : 'Admin';
                    const addedName = teacher.added_by.name;
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${teacher.user.name}</td>
                            <td>${teacher.user.email || ''}</td>
                            <td>${addedName} (${addedBy})</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-sm btn-info restoreTeacher" data-id="${teacher.id}">RESTORE</button>
                                <button class="btn btn-sm btn-danger permanentDeleteTeacher" data-id="${teacher.id}">DELTE</button>
                                </div>
                            </td>
                        </tr>
                    `;
                    $('#admin_trash_teachers_table_body').append(row);
                });

                // Edit / Delete handlers
                // $(document).on('click', '.editTeacher', async function() {
                //     const teacherId = $(this).data('id');
                //     console.log('Edit teacher:', teacherId);
                //     await fillAdminTeacherForm(teacherId);
                //     $('#adminTeacherEditModal').modal('show');
                // });

                $(document).on('click', '.permanentDeleteTeacher', async function() {
                    const id = $(this).data('id');
                    console.log('Permanent delete teacher:', id);

                    const confirm = await Swal.fire({
                        title: '⚠️ Are you sure?',
                        text: "This teacher will be permanently deleted!",
                        icon: 'warning', // icon can be 'warning', 'error', 'success', 'info', 'question'
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete Permanently',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        focusCancel: true,
                        buttonsStyling: true,
                        customClass: {
                            confirmButton: 'btn btn-danger',   // red button
                            cancelButton: 'btn btn-secondary'  // gray button
                        }
                    });


                    if (!confirm.isConfirmed) return;

                    // Show loader on table
                    $('#trashTableLoader').show();

                    try {
                        const res = await axios.post('/admin/teacher/delete-by-id', {
                            id: id
                        }, {
                            headers: {
                                Authorization: 'Bearer ' + token
                            }
                        });

                        if (res.data.status === 'success') {
                            Swal.fire('Trashed!', res.data.message, 'success');
                            getAllTeacherTrashLists(); // reload table
                        } else {
                            Swal.fire('Error', res.data.message || 'Trash failed', 'error');
                        }
                    } catch (err) {
                        Swal.fire('Error', 'Server or network error', 'error');
                    } finally {
                        $('#trashTableLoader').hide();
                    }
                });







                // Initialize DataTable
                $('#admin_trash_teachers_table').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }
        } catch (error) {
            console.error('Error fetching teachers:', error);
        }
    }






    // Teacher Create
    $('#teacherForm').on('submit', async function(e) {
        e.preventDefault();
        let token = localStorage.getItem('token');

        if (!token) {
            alert('Unauthorized Access');
            return;
        }



        // Clear previous errors
        $('#teacher_name_error').text('');
        $('#teacher_email_error').text('');
        $('#teacher_institution_id_error').text('');

        let name = $('#name').val().trim();
        let email = $('#email').val().trim();
        let institution_id = $('#teacher_institution_id').val().trim();

        let isError = false;
        if (!name) {
            $('#teacher_name_error').text('Name is required');
            isError = true;
        }
        if (!email) {
            $('#teacher_email_error').text('Email is required');
            isError = true;
        }
        if (!institution_id) {
            $('#teacher_institution_id_error').text('Institution is required');
            isError = true;
        }
        if (isError) return;

        let data = {
            name,
            email,
            institution_id
        };

        // Show loader & disable form
        $('#loader').show();
        $('#teacherForm :input').prop('disabled', true);

        try {
            const res = await axios.post('/teacher/store', data, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                Swal.fire('Success', res.data.message, 'success');
                $('#name').val('');
                $('#email').val('');
                getAllTeacherLists(); // Reload table
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors || {};
                $('#teacher_name_error').text(errors.name ? errors.name[0] : '');
                $('#teacher_email_error').text(errors.email ? errors.email[0] : '');
                $('#teacher_institution_id_error').text(errors.institution_id ? errors
                    .institution_id[0] : '');
            } else {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        } finally {
            $('#loader').hide();
            $('#teacherForm :input').prop('disabled', false);
        }
    });
</script>
