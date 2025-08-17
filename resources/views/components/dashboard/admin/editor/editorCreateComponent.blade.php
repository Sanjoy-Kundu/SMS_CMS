<div class="container-fluid">
    <div class="row">

        <!-- Left Column: editor Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-primary font-weight-bold">Create A New Editor</h5>
                </div>
                <div class="card-body">
                    <form id="editorForm">
                        <div class="form-group">
                            <label for="name">Institution Id</label>
                            <input type="text" class="form-control" id="institution_id" name="institution_id"
                                placeholder="Enter institution id">
                            <span id="institution_id_error" class="text-danger small"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">Editor Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Editor name">
                            <span id="editor_name_error" class="text-danger small"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">Editor Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter Editor Email">
                            <span id="editor_email_error" class="text-danger small"></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" onclick="EditorCreate(event)">Add
                            Editor</button>
                    </form>
                    <div id="loader"style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.7);z-index:9999;display:flex;align-items:center;justify-content:center;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: editor Tables -->
        <div class="col-xl-7 col-md-6 mb-4">

            <!-- Active editors -->
            <div class="card border-left-success shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-success font-weight-bold">Editors List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="active-editors-table">
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

            <!-- Trash editors -->
            <div class="card border-left-danger shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-danger font-weight-bold">Trash Editors List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="trash-editors-table">
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
    loadInstitutions();
    async function loadInstitutions() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorize Access');
            return;
        }
        try {
            const response = await axios.post('/institution/details', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.data.id) {
                document.getElementById('institution_id').value = response.data.data.id;
            } else {
                alert('No institution found');
            }
        } catch (error) {
            console.error('Error fetching academic sections:', error);
        }
    }



    async function EditorCreate(event) {
        event.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized Access');
            return;
        }

        // Clear previous errors
        document.getElementById('editor_name_error').innerText = '';
        document.getElementById('editor_email_error').innerText = '';
        document.getElementById('institution_id_error').innerText = '';

        let name = document.getElementById('name').value.trim();
        let email = document.getElementById('email').value.trim();
        let institution_id = document.getElementById('institution_id').value.trim();

        let isError = false;
        if (name === '') {
            document.getElementById('editor_name_error').innerText = 'Name is required';
            isError = true;
        }
        if (email === '') {
            document.getElementById('editor_email_error').innerText = 'Email is required';
            isError = true;
        }
        if (institution_id === '') {
            document.getElementById('institution_id_error').innerText = 'Institution is required';
            isError = true;
        }
        if (isError) return;

        let data = {
            name: name,
            email: email,
            institution_id: institution_id
        };

        // Show loader
        document.getElementById('loader').style.display = 'flex';

        try {
            let res = await axios.post('/editor/store', data, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                Swal.fire('Success', res.data.message, 'success');
                // Reset form
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
            }
        } catch (error) {
            if (error.response) {
                // Validation or duplicate error
                if (error.response.status === 422) {
                    let errors = error.response.data.errors || {};
                    document.getElementById('editor_name_error').innerText = errors.name ? errors.name[0] : '';
                    document.getElementById('editor_email_error').innerText = errors.email ? errors.email[0] : '';
                    document.getElementById('institution_id_error').innerText = errors.institution_id ? errors
                        .institution_id[0] : '';

                    // Duplicate editor error
                    if (error.response.data.message && !errors.name && !errors.email) {
                        Swal.fire('Error', error.response.data.message, 'error');
                    }
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            } else {
                Swal.fire('Error', 'Network or server error', 'error');
            }
        } finally {
            // Hide loader
            document.getElementById('loader').style.display = 'none';
        }
    }
</script>
