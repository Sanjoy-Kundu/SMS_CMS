<div class="container-fluid">
    <div class="row">

        <!-- Left Column: Institution Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-primary font-weight-bold">Add Your New Institution</h5>
                </div>
                <div class="card-body">
                    <form id="institutionForm">
                        <div class="form-group">
                            <label for="name">Institution Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter institution name">
                            <span id="institution_name_error" class="text-danger small">--</span>
                        </div>

                        <div class="form-group">
                            <label for="type">Institution Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="" disabled selected>-- CHOOSE ONE --</option>
                                <option value="school">School</option>
                                <option value="college">College</option>
                                <option value="combined">Combined</option>
                            </select>
                            <span id="institution_type_error" class="text-danger small">--</span>
                        </div>

                        <div class="form-group">
                            <label for="eiin">EIIN</label>
                            <input type="text" class="form-control" id="eiin" name="eiin" placeholder="Enter EIIN (optional)">
                            <span id="institution_eiin_error" class="text-danger small">--</span>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter address (optional)"></textarea>
                            <span id="institution_address_error" class="text-danger small">--</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Add Institution</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Institution Tables -->
        <div class="col-xl-7 col-md-6 mb-4">

            <!-- Active Institutions -->
            <div class="card border-left-success shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-success font-weight-bold">Institutions List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="active-institutions-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>EIIN</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Trash Institutions -->
            <div class="card border-left-danger shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-danger font-weight-bold">Trash Institutions List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="trash-institutions-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>EIIN</th>
                                    <th>Address</th>
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
    $(document).ready(function() {
        getInstitutions();
    });

    async function getInstitutions() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/institution/details', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                // Populate active institutions table
                populateTable('#active-institutions-table', response.data.data, 'active');

                // Populate trash institutions table
                populateTable('#trash-institutions-table', response.data.trashData, 'trash');

                if (response.data.data && response.data.data.length > 0) {
                    // Form disable
                    $("#institutionForm :input").prop("disabled", true);

                    Swal.fire({
                        icon: 'info',
                        title: 'Institution Already Exists',
                        text: 'আপনার একটি Institution ইতিমধ্যেই যুক্ত আছে। আগে Delete না করলে নতুন যোগ করা যাবে না।'
                    });
                } else {
                    // Form enable
                    $("#institutionForm :input").prop("disabled", false);
                }
            }

        
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong fetching institutions.'
        });
    }
    }

    function populateTable(tableSelector, institutions, type) {
        let tbody = '';

        if (!institutions || (Array.isArray(institutions) && institutions.length === 0)) {
            tbody = `<tr><td colspan="6" class="text-center">No institutions found.</td></tr>`;
        } else {
            // Handle single institution object
            if (!Array.isArray(institutions)) {
                institutions = [institutions];
            }

            $.each(institutions, function(index, inst) {
                let actionButtons = '';

                if (type === 'active') {
                    actionButtons = `
                        <div class="btn-group" role="group" aria-label="Actions">
                            <button type="button" class="btn btn-primary edit-btn" data-id="${inst.id}">EDIT</button>
                            <button type="button" class="btn btn-info view-btn" data-id="${inst.id}">VIEW</button>
                            <button type="button" class="btn btn-danger trash-btn" data-id="${inst.id}">TRASH</button>
                        </div>`;
                } else {
                    actionButtons = `
                        <div class="btn-group" role="group" aria-label="Actions">
                            <button type="button" class="btn btn-success restore-btn" data-id="${inst.id}">RESTORE</button>
                            <button type="button" class="btn btn-danger delete-btn" data-id="${inst.id}">DELETE</button>
                        </div>`;
                }

                tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${inst.name || 'N/A'}</td>
                        <td>${inst.type ? inst.type.charAt(0).toUpperCase() + inst.type.slice(1) : 'N/A'}</td>
                        <td>${inst.eiin || 'N/A'}</td>
                        <td>${inst.address || 'N/A'}</td>
                        <td>${actionButtons}</td>
                    </tr>`;
            });
        }

        $(tableSelector + ' tbody').html(tbody);
    }

    // Event delegation for active table buttons
    $('#active-institutions-table').on('click', '.edit-btn', async function() {
        let id = $(this).data('id');
        if (id) {
            console.log('Edit institution:', id);
            await fillUpInstitutionForm(id);
            $('#editInstitutionModal').modal('show');
        } else {
            alert('Edit Id Is Missing')
        }

    });

    $('#active-institutions-table').on('click', '.view-btn', function() {
        let id = $(this).data('id');
        console.log('View institution:', id);
        // Implement view functionality
    });

    $('#active-institutions-table').on('click', '.trash-btn', async function() {
        let id = $(this).data('id');

        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, move to trash!'
        });

        if (result.isConfirmed) {
            try {
                let token = localStorage.getItem('token');
                let res = await axios.post('/institution/trash', {
                    id: id
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                if (res.data.status === 'success') {
                    await getInstitutions();
                    Swal.fire('Moved to Trash!', 'Institution has been moved to trash.',
                        'success');
                } else {
                    Swal.fire('Failed!', res.data.message ||
                        'Failed to move institution to trash.', 'error');
                }
            } catch (error) {
                Swal.fire('Error!', error.response?.data?.message || 'Something went wrong.',
                    'error');
            }
        }
    });

    // Event delegation for trash table buttons
    $('#trash-institutions-table').on('click', '.restore-btn', async function() {
        let id = $(this).data('id');

        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to restore this institution?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore it!'
        });

        if (result.isConfirmed) {
            try {
                let token = localStorage.getItem('token');
                let res = await axios.post('/institution/restore', {
                    id: id
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                if (res.data.status === 'success') {
                    await getInstitutions();
                    Swal.fire('Restored!', 'Institution has been restored.', 'success');
                } else {
                    Swal.fire('Failed!', res.data.message || 'Failed to restore institution.',
                        'error');
                }
            } catch (error) {
                Swal.fire('Error!', error.response?.data?.message || 'Something went wrong.',
                    'error');
            }
        }
    });

    $('#trash-institutions-table').on('click', '.delete-btn', async function() {
        let id = $(this).data('id');

        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the institution!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        });

        if (result.isConfirmed) {
            try {
                let token = localStorage.getItem('token');
                let res = await axios.post('/institution/delete', {
                    id: id
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                if (res.data.status === 'success') {
                    await getInstitutions();
                    Swal.fire('Deleted!', 'Institution has been permanently deleted.',
                        'success');
                } else {
                    Swal.fire('Failed!', res.data.message || 'Failed to delete institution.',
                        'error');
                }
            } catch (error) {
                Swal.fire('Error!', error.response?.data?.message || 'Something went wrong.',
                    'error');
            }
        }
    });

    // Institution Creation Form
    $('#institutionForm').on('submit', async function(e) {
        e.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        let name = $.trim($('#name').val());
        let type = $('#type').val();
        let eiin = $.trim($('#eiin').val());
        let address = $.trim($('#address').val());

        // Reset errors
        $('#institution_name_error').text('');
        $('#institution_type_error').text('');
        $('#institution_eiin_error').text('');
        $('#institution_address_error').text('');

        if (!name) {
            $('#institution_name_error').text('Please enter institution name');
            return;
        }
        if (!type) {
            $('#institution_type_error').text('Please select institution type');
            return;
        }

        let data = {
            name,
            type,
            eiin,
            address
        };

        try {
            let res = await axios.post('/institution/create', data, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                await getInstitutions();
                Swal.fire({
                    icon: 'success',
                    title: 'Institution Added!',
                    text: res.data.message
                });

                // Reset form and errors after success
                $("#institutionForm")[0].reset();
                $('#institution_name_error').text('');
                $('#institution_type_error').text('');
                $('#institution_eiin_error').text('');
                $('#institution_address_error').text('');

                $("#institutionForm :input").prop("disabled", false);
                $("button[type='submit']")
                    .text("Add Institution")
                    .removeClass("btn-success")
                    .addClass("btn-primary");
            } else if (res.data.status === 'fail') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: res.data.message
                });
            } else {
                console.log(res.data);
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                if (errors.name) $('#institution_name_error').text(errors.name[0]);
                if (errors.type) $('#institution_type_error').text(errors.type[0]);
                if (errors.eiin) $('#institution_eiin_error').text(errors.eiin[0]);
                if (errors.address) $('#institution_address_error').text(errors.address[0]);

                let allErrors = Object.values(errors).flat().join("\n");
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: allErrors
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!'
                });
                console.error(error);
            }
        }
    });
</script>
