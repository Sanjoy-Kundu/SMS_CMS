<!-- Designation Modal -->
<div class="modal fade" id="controlPanelTeacherDesignationsModal" tabindex="-1" role="dialog"
    aria-labelledby="controlPanelTeacherDesignationsModallLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold" id="controlPanelTeacherDesignationsModalLabel">
                    + Add New Designation
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body position-relative">
                <div class="row">
                    <!-- Left Column: Create Designation Form -->
                    <div class="col-md-4">
                        <input type="hidden" name="institution_id" id="institution_id" class="form-control">
                        <form id="designationCreateForm">

                            <div class="form-group">
                                <label for="title">Designation Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="e.g. Headmaster, Assistant Teacher">
                                <span class="title_error text-danger"></span>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm mt-2"
                                onclick="createDesignation(event)">Add Designation</button>
                        </form>

                        <!-- Optional Trash List -->
                        {{-- <div class="mt-4">
                            <h6 class="text-danger font-weight-bold">Deleted Designations</h6>
                            <ul class="list-group" id="deletedDesignationsList">
                                <!-- Deleted items will appear here -->
                            </ul>
                        </div> --}}
                    </div>

                    <!-- Right Column: Designation List Table -->
                    <div class="col-md-8 position-relative">
                        <!-- Loader -->
                        <div class="table-loader-overlay" id="designationTableLoader"
                            style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:5;">
                            <div class="loader-bar"></div>
                        </div>

                        <!-- Total Designations -->
                        <p class="m-0 text-info font-weight-bold mb-2">
                            Total Designations: <span class="totalDesignationsCount">0</span>
                        </p>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm"
                                id="designation_control_panel_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="designation_control_panel_table_body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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
    getInstitution();
    async function getInstitution() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Authorization failed');
            return;
        }
        try {
            let res = await axios.post('/institution/details', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            if (res.data.status === 'success') {
                if (res.data.data.id) {
                    document.querySelector('#institution_id').value = res.data.data.id;
                } else {
                    alert('Institution not found. Unauthorized access');
                    return;
                }
            }
            //console.log(res.data.data.id);
        } catch (error) {
            console.log(error);
        }
    }

    async function getDesignation() {
        try {
            let res = await axios.post('/designation/details', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
        } catch (error) {
            console.log(error);
        }
    }



    //create designation
    async function createDesignation(event) {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized access');
            return;
        }
        event.preventDefault();

        // Clear previous error
        document.querySelector('.title_error').textContent = '';

        let title = document.getElementById('title').value.trim();
        let institution_id = document.getElementById('institution_id').value.trim();
        let isError = false;

        if (!title) {
            document.querySelector('.title_error').textContent = 'Title is required';
            isError = true;
        }

        if (isError) return;
        let data = {
            title: title,
            institution_id: institution_id
        }
        try {
            let res = await axios.post('/admin/designation/store', data, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            if (res.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                document.getElementById('designationCreateForm').reset();
            }
        }catch(error) {
                if (error.response && error.response.status === 422) {
                    // Validation error
                    if (error.response.data.errors.title) {
                        document.querySelector('.title_error').textContent = error.response.data.errors.title[0];
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.response?.data?.error || 'Something went wrong!'
                    });
                }
            }
        
    }
</script>
