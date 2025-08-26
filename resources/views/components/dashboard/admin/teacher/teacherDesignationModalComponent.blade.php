<!-- Designation Modal -->
<div class="modal fade" id="controlPanelTeacherDesignationsModal" tabindex="-1" role="dialog"
    aria-labelledby="controlPanelTeacherDesignationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0 rounded-lg">

            <!-- Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold" id="controlPanelTeacherDesignationsModalLabel">
                    Manage Designations
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="row">

                    <!-- Left Column: Create Form -->
                    <div class="col-md-5">
                        <div class="card shadow-sm border-0 rounded-lg">
                            <div class="card-header bg-light">
                                <h6 class="m-0 font-weight-bold text-dark">+ Add New Designation</h6>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="institution_id" id="institution_id" class="form-control">
                                <form id="designationCreateForm">
                                    <div class="form-group">
                                        <label for="title" class="font-weight-semibold">Designation Title</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="e.g. Headmaster, Assistant Teacher">
                                        <small class="text-danger title_error"></small>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block btn-sm mt-2"
                                        onclick="createDesignation(event)">
                                        <i class="fas fa-plus-circle"></i> Add Designation
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Designation List -->
                    <div class="col-md-7">
                        <div class="card shadow-sm border-0 rounded-lg position-relative">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-dark">
                                    All Designations
                                </h6>
                                <span class="badge badge-info">
                                    Total: <span class="totalDesignationsCount">0</span>
                                </span>
                            </div>


                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm mb-0"
                                        id="designation_control_panel_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 60px;">#</th>
                                                <th>Title</th>
                                                <th style="width: 150px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="designation_control_panel_table_body"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 rounded-lg position-relative">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-dark">
                                    All Trash Designations
                                </h6>
                                <span class="badge badge-info">
                                    Total: <span class="totalDesignationsTrashCount">0</span>
                                </span>
                            </div>


                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm mb-0"
                                        id="designation_control_panel_trash_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 60px;">#</th>
                                                <th>Title</th>
                                                <th style="width: 150px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="designation_control_panel_trash_table_body"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>





    <!-- Edit Designation Modal -->
    <div class="modal fade" id="editDesignationModal" tabindex="-1" role="dialog"
        aria-labelledby="editDesignationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content shadow-lg border-0 rounded-lg">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editDesignationModalLabel">Edit Designation</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="designationEditForm">
                        <input type="hidden" id="edit_designation_id">

                        <div class="form-group">
                            <label for="edit_title" class="font-weight-semibold">Designation Title</label>
                            <input type="text" id="edit_title" class="form-control"
                                placeholder="Enter designation title">
                            <small class="text-danger edit_title_error"></small>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm"
                        onclick="updateDesignation(event)">Update</button>
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

    // get designation lists
    getDesignationLists();
    async function getDesignationLists() {
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
                document.querySelector('.totalDesignationsCount').innerText = designations.length;

                // Destroy old DataTable if exists
                if ($.fn.DataTable.isDataTable('#designation_control_panel_table')) {
                    $('#designation_control_panel_table').DataTable().clear().destroy();
                }

                // Clear table body
                $('#designation_control_panel_table_body').html('');

                // Append rows
                designations.forEach((designation, index) => {
                    const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${designation.title ? designation.title : 'N/A'}</td>
                        <td>
                            <button class="btn btn-sm btn-info editDesignation" data-id="${designation.id}">Edit</button>
                            <button class="btn btn-sm btn-danger deleteDesignation" data-id="${designation.id}">Trash</button>
                        </td>
                    </tr>
                `;
                    $('#designation_control_panel_table_body').append(row);
                });

                // Initialize DataTable
                $('#designation_control_panel_table').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                });

                // Event Handlers (Edit/Delete)
                // Edit Click Handler (Already added console.log, now complete)
                $(document).off('click', '.editDesignation').on('click', '.editDesignation', async function() {
                    const id = $(this).data('id');
                    let token = localStorage.getItem('token');
                    if (!token) {
                        Swal.fire("Unauthorized!", "Please login first", "error");
                        return;
                    }

                    try {
                        // get designation details
                        let res = await axios.post('/admin/designation/details', {
                            id
                        }, {
                            headers: {
                                Authorization: `Bearer ${token}`
                            }
                        });

                        if (res.data.status === 'success') {
                            let designation = res.data.data;
                            $('#edit_designation_id').val(designation.id);
                            $('#edit_title').val(designation.title);

                            // clear error
                            $('.edit_title_error').text('');

                            // open modal
                            $('#editDesignationModal').modal('show');
                        }
                    } catch (error) {
                        Swal.fire("Error!", "Failed to fetch designation", "error");
                    }
                });

                //delete designation 
                $(document).off('click', '.deleteDesignation').on('click', '.deleteDesignation', async function() {
                    const id = $(this).data('id');
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This designation will be deleted!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!"
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                let delRes = await axios.post('/admin/designation/delete', {
                                    id
                                }, {
                                    headers: {
                                        'Authorization': `Bearer ${token}`
                                    }
                                });
                                if (delRes.data.status === 'success') {
                                    Swal.fire("Deleted!", delRes.data.message, "success");
                                    await getDesignationLists(); // refresh
                                    await getDesignationTrashLists(); // refresh
                                }
                            } catch (error) {
                                Swal.fire("Error!", "Something went wrong!", "error");
                            }
                        }
                    });
                });
            }
        } catch (error) {
            console.log(error);
            Swal.fire("Error!", "Failed to load designations", "error");
        }
    }

    
                // Update Designation Function
                async function updateDesignation(event) {
                    event.preventDefault();
                    let token = localStorage.getItem('token');
                    if (!token) {
                        Swal.fire("Unauthorized!", "Please login first", "error");
                        return;
                    }

                    let id = $('#edit_designation_id').val();
                    let title = $('#edit_title').val().trim();

                    // validation
                    if (!title) {
                        $('.edit_title_error').text('Title is required');
                        return;
                    } else {
                        $('.edit_title_error').text('');
                    }

                    try {
                        let res = await axios.post('/admin/designation/update', {
                            id,
                            title
                        }, {
                            headers: {
                                Authorization: `Bearer ${token}`
                            }
                        });

                        if (res.data.status === 'success') {
                            Swal.fire("Updated!", res.data.message, "success");

                            $('#editDesignationModal').modal('hide');
                            await getDesignationLists(); // refresh list
                        }
                    } catch (error) {
                        if (error.response && error.response.status === 422) {
                            if (error.response.data.errors.title) {
                                $('.edit_title_error').text(error.response.data.errors.title[0]);
                            }
                        } else {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    }
                }



    // get designation trash lists
    getDesignationTrashLists();
    async function getDesignationTrashLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Authorization failed');
            return;
        }

        try {
            let res = await axios.post('/admin/designation/trash/list', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                const designations = res.data.data;
                document.querySelector('.totalDesignationsTrashCount').innerText = designations.length;

                // Destroy old DataTable if exists
                if ($.fn.DataTable.isDataTable('#designation_control_panel_trash_table')) {
                    $('#designation_control_panel_trash_table').DataTable().clear().destroy();
                }

                // Clear table body
                $('#designation_control_panel_trash_table_body').html('');

                // Append rows
                designations.forEach((designation, index) => {
                    const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${designation.title ? designation.title : 'N/A'}</td>
                    <td>
                        <button class="btn btn-sm btn-info restoreDesignation" data-id="${designation.id}">
                            <i class="fas fa-undo"></i> Restore
                        </button>
                        <button class="btn btn-sm btn-danger permanentDeleteDesignation" data-id="${designation.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `;
                    $('#designation_control_panel_trash_table_body').append(row);
                });

                // Initialize DataTable
                $('#designation_control_panel_trash_table').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                });

                // Restore Event
                $(document).off('click', '.restoreDesignation').on('click', '.restoreDesignation',
                    async function() {
                        const id = $(this).data('id');
                        Swal.fire({
                            title: "Are you sure?",
                            text: "This designation will be restored!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, restore it!"
                        }).then(async (result) => {
                            if (result.isConfirmed) {
                                try {
                                    let restoreRes = await axios.post(
                                        '/admin/designation/restore', {
                                            id
                                        }, {
                                            headers: {
                                                'Authorization': `Bearer ${token}`
                                            }
                                        });
                                    if (restoreRes.data.status === 'success') {
                                        Swal.fire("Restored!", restoreRes.data.message,
                                            "success");
                                        getDesignationLists(); // refresh active list
                                        getDesignationTrashLists(); // refresh trash list
                                    }
                                } catch (error) {
                                    Swal.fire("Error!", "Something went wrong!", "error");
                                }
                            }
                        });
                    });

                // Permanent Delete Event
                $(document).off('click', '.permanentDeleteDesignation').on('click', '.permanentDeleteDesignation',
                    async function() {
                        const id = $(this).data('id');
                        Swal.fire({
                            title: "Are you sure?",
                            text: "This designation will be permanently deleted!",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Yes, delete permanently!"
                        }).then(async (result) => {
                            if (result.isConfirmed) {
                                try {
                                    let delRes = await axios.post(
                                        '/admin/designation/permanent-delete', {
                                            id
                                        }, {
                                            headers: {
                                                'Authorization': `Bearer ${token}`
                                            }
                                        });
                                    if (delRes.data.status === 'success') {
                                        Swal.fire("Deleted!", delRes.data.message, "success");
                                        getDesignationTrashLists(); // refresh trash
                                    }
                                } catch (error) {
                                    Swal.fire("Error!", "Something went wrong!", "error");
                                }
                            }
                        });
                    });
            }
        } catch (error) {
            console.log(error);
            Swal.fire("Error!", "Failed to load trash designations", "error");
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
                await getDesignationLists();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                document.getElementById('designationCreateForm').reset();
            }
        } catch (error) {
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
