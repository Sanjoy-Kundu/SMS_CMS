<style>
    /* Loader overlay just for the form card */
    .loader-overlay {
        display: none; /* hidden initially */
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7); /* semi-transparent white */
        z-index: 10; /* above card content */
        border-radius: 0.35rem; /* match card border radius */
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

<div class="container-fluid mt-4">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Editor Profile</h1>

    <div class="row">

        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 position-relative">
                <!-- Loader overlay -->
                <div class="loader-overlay" id="editorLoader">
                    <div class="loader-bar"></div>
                </div>
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-primary font-weight-bold">Create A New Teacher</h5>
                </div>
                <div class="card-body">
                    <form id="EditorTeacherForm">
                        <div class="form-group" hidden>
                            <label for="name">Institution Id</label>
                             <input type="hidden" id="editor_teacher_institution_id" name="institution_id">
                                <span id="editor_teacher_institution_id_error" class="text-danger small"></span>
                        </div>
                        <div class="form-group">
                            <label for="editor_teacher_name">Teacher Name</label>
                            <input type="text" class="form-control" id="editor_teacher_name" name="name"
                                placeholder="Enter teacher name">
                            <span id="editor_teacher_name_error" class="text-danger small"></span>
                        </div>

                        <div class="form-group">
                            <label for="editor_teacher_email">Teacher Email</label>
                            <input type="email" class="form-control" id="editor_teacher_email" name="email"
                                placeholder="Enter teacher Email">
                            <span id="editor_teacher_email_error" class="text-danger small"></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"
                            onclick="teacherCreateByEditor(event)">Add
                            teacher</button>
                    </form>
                </div>
            </div>
        </div>






        <!-- Profile Edit Form -->
        <!-- Right Column: teacher Tables -->
        <div class="col-xl-7 col-md-6 mb-4">

            <!-- Active teachers -->
            <div class="card border-left-success shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-success font-weight-bold">Teachers List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="editor_teachers_table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="editor_teachers_table_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    document.getElementById('editor_teacher_institution_id').value = institutions[0].id;
                    //console.log(institutions[0].id);
                } else {
                    alert('No institution found');
                }
            }


        } catch (error) {
            console.error('Error fetching institutions:', error);
        }
    }




    async function teacherCreateByEditor(event) {
        event.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized Access');
            return;
        }

        //     // Clear previous errors
        document.getElementById('editor_teacher_name_error').innerText = '';
        document.getElementById('editor_teacher_email_error').innerText = '';
        document.getElementById('editor_teacher_institution_id_error').innerText = '';

        // Get form data
        let name = document.getElementById('editor_teacher_name').value.trim();
        let email = document.getElementById('editor_teacher_email').value.trim();
        let institution_id = document.getElementById('editor_teacher_institution_id').value.trim();

        // Validation
        let isError = false;
        if (!name) {
            document.getElementById('editor_teacher_name_error').innerText = 'Name is required';
            isError = true;
        }
        if (!email) {
            document.getElementById('editor_teacher_email_error').innerText = 'Email is required';
            isError = true;
        }
        if (!institution_id) {
            document.getElementById('editor_teacher_institution_id_error').innerText = 'Institution is required';
            isError = true;
        }
        if (isError) return;

        let data = {
            name:name,
            email:email,
            institution_id:institution_id,
        };

        // Show editorLoader & disable form
        document.getElementById('editorLoader').style.display = 'block';
        const formElements = document.getElementById('EditorTeacherForm').elements;
        for (let el of formElements) el.disabled = true;

        try {
            const res = await axios.post('/teacher/store', data, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                await getEditorSelfTeacherLists();
                Swal.fire('Success', res.data.message, 'success');
                // Reset form
                document.getElementById('editor_teacher_name').value = '';
                document.getElementById('editor_teacher_email').value = '';
                // Optionally reload teacher list here
            }
        } catch (error) {
            if (error.response) {
                if (error.response.status === 422) {
                    const errors = error.response.data.errors || {};
                    document.getElementById('editor_teacher_name_error').innerText = errors.name ? errors.name[0] : '';
                    document.getElementById('editor_teacher_email_error').innerText = errors.email ? errors.email[0] : '';
                    document.getElementById('editor_teacher_institution_id_error').innerText = errors.institution_id ? errors
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
            document.getElementById('editorLoader').style.display = 'none';
            for (let el of formElements) el.disabled = false;
        }
    }


    //teacher list by editor id 
    getEditorSelfTeacherLists()
    async function getEditorSelfTeacherLists() {
        try {
            const res = await axios.post('/all/teacher/lists', {}, {
                headers: { Authorization: 'Bearer ' + token }
            });

            if (res.data.status === 'success') {
                const teachers = res.data.editorTeachers;

                // Destroy old DataTable if exists
                if ($.fn.DataTable.isDataTable('#editor_teachers_table')) {
                    $('#editor_teachers_table').DataTable().destroy();
                }

                // Clear table body
                $('#editor_teachers_table_body').html('');

                // Append rows
                teachers.forEach((teacher, index) => {
                    //console.log(teacher.added_by.role);
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${teacher.user.name}</td>
                            <td>${teacher.user.email || ''}</td>
                            <td>
                                <button class="btn btn-sm btn-primary editTeacher" data-id="${teacher.id}">Edit</button>
                                <button class="btn btn-sm btn-danger deleteTeacher" data-id="${teacher.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                    $('#editor_teachers_table_body').append(row);
                });

                // Initialize DataTable
                $('#editor_teachers_table').DataTable({
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
</script>
