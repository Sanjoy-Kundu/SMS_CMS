<style>
    /* HTML: <div class="loader"></div> */
    /* Loader bar animation */
    .loader {
        display: none;
        /* hidden initially */
        height: 4px;
        width: 100%;
        --c: no-repeat linear-gradient(#6100ee 0 0);
        background: var(--c), var(--c), #d7b8fc;
        background-size: 60% 100%;
        animation: l16 3s infinite;
        margin-bottom: 10px;
        /* space above the form */
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
            <div class="loader" id="loader"></div>
            <div class="card border-left-primary shadow h-100">
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

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"
                            onclick="teacherCreate(event)">Add
                            teacher</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: teacher Tables -->
        <div class="col-xl-7 col-md-6 mb-4">

            <!-- Active teachers -->
            <div class="card border-left-success shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-success font-weight-bold">teachers List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="active-teachers-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Control Panel</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Trash teachers -->
            <div class="card border-left-danger shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-danger font-weight-bold">Trash teachers List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="trash-teachers-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Control Panel</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>






<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
            name:name,
            email:email,
            institution_id:institution_id,
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
                    document.getElementById('institution_id_error').innerText = errors.institution_id ? errors
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
</script>
