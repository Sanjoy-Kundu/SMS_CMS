<style>
    /* HTML: <div class="loader"></div> */
/* Loader bar animation */
.loader {
  display: none; /* hidden initially */
  height: 4px;
  width: 100%;
  --c:no-repeat linear-gradient(#6100ee 0 0);
  background: var(--c),var(--c),#d7b8fc;
  background-size: 60% 100%;
  animation: l16 3s infinite;
  margin-bottom: 10px; /* space above the form */
}
@keyframes l16 {
  0%   {background-position:-150% 0,-150% 0}
  66%  {background-position: 250% 0,-150% 0}
  100% {background-position: 250% 0, 250% 0}
}
</style>

<div class="container-fluid">
    <div class="row">

        <!-- Left Column: editor Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="loader" id="loader"></div>
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

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn" onclick="EditorCreate(event)">Add
                            Editor</button>
                    </form>
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
    if (!token) { alert('Unauthorized Access'); return; }

    // Clear previous errors
    document.getElementById('editor_name_error').innerText = '';
    document.getElementById('editor_email_error').innerText = '';
    document.getElementById('institution_id_error').innerText = '';

    let name = document.getElementById('name').value.trim();
    let email = document.getElementById('email').value.trim();
    let institution_id = document.getElementById('institution_id').value.trim();

    let isError = false;
    if (name === '') { document.getElementById('editor_name_error').innerText = 'Name is required'; isError = true; }
    if (email === '') { document.getElementById('editor_email_error').innerText = 'Email is required'; isError = true; }
    if (institution_id === '') { document.getElementById('institution_id_error').innerText = 'Institution is required'; isError = true; }
    if (isError) return;

    let data = { name, email, institution_id };

    // Show loader
    document.getElementById('loader').style.display = 'block';
    const formElements = document.getElementById('editorForm').elements;
    for (let el of formElements) el.disabled = true;

    try {
        let res = await axios.post('/editor/store', data, {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (res.data.status === 'success') {
            Swal.fire('Success', res.data.message, 'success');
            // Reset form
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
        }
    } catch (error) {
        if (error.response) {
            if (error.response.status === 422) {
                let errors = error.response.data.errors || {};
                document.getElementById('editor_name_error').innerText = errors.name ? errors.name[0] : '';
                document.getElementById('editor_email_error').innerText = errors.email ? errors.email[0] : '';
                document.getElementById('institution_id_error').innerText = errors.institution_id ? errors.institution_id[0] : '';

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
        // Hide loader after request finished
        document.getElementById('loader').style.display = 'none';
        for (let el of formElements) el.disabled = false;
    }
}
</script>
