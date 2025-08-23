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

        <!-- Left Column: editor Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 position-relative">
                <div class="loader-overlay" id="loader">
                    <div class="loader-bar"></div>
                </div>
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-primary font-weight-bold">Create A New Editor</h5>
                </div>
                <div class="card-body">
                    <form id="editorForm">
                        <div class="form-group" hidden>
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

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"
                            onclick="EditorCreate(event)">Add
                            Editor</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: editor Tables -->
        <div class="col-xl-7 col-md-6 mb-4">

            <!-- Active editors -->
            <div class="card border-left-success shadow mb-4 position-relative">
                <div class="loader-overlay" id="adminEditorTableLoader">
                    <div class="loader-bar"></div>
                </div>
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-success font-weight-bold">Editors List</h5>
                    <p class="m-0 text-success font-weight-bold">Total Editor: <span
                            class="adminAddedTotalEditorCount">0</span></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="admin_added_editor_lists">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="admin_added_editor_lists_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Trash editors -->
            <div class="card border-left-danger shadow position-relative">
                <div class="loader-overlay" id="adminEditorTrashTableLoader">
                    <div class="loader-bar"></div>
                </div>
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-danger font-weight-bold">Trash Editors List</h5>
                    <p class="m-0 text-danger font-weight-bold">Total Editor: <span
                            class="adminAddedTotalTrashEditorCount">0</span></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="admin_added_editor_trash_lists">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="admin_added_editor_trash_lists_body"></tbody>
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

    //editor created by admin
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
            name,
            email,
            institution_id
        };

        // Show loader
        document.getElementById('loader').style.display = 'block';
        const formElements = document.getElementById('editorForm').elements;
        for (let el of formElements) el.disabled = true;

        try {
            let res = await axios.post('/editor/store', data, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                await loadAdminAddedEditorLists();
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
            // Hide loader after request finished
            document.getElementById('loader').style.display = 'none';
            for (let el of formElements) el.disabled = false;
        }
    }


    //admin added by editor lists 
    loadAdminAddedEditorLists();
    async function loadAdminAddedEditorLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }
        try {
            const res = await axios.post('/admin_db/editor/list', {}, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                const editors = res.data.editorLists;
                //console.log(editors);
                document.querySelector('.adminAddedTotalEditorCount').innerText = editors.length;

                if ($.fn.DataTable.isDataTable('#admin_added_editor_lists')) {
                    $('#admin_added_editor_lists').DataTable().destroy();
                }
                $('#admin_added_editor_lists_body').html('');

                editors.forEach((editor, index) => {
                    //console.log(editor);
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${editor.user.name}</td>
                            <td>${editor.user.email || ''}</td>
                           <td><button class="btn btn-sm btn-info EditorViewInfo" data-email="${editor.user.email}">View</button></td>
                            <td>
                                <button class="btn btn-sm btn-primary EditorEditInfo" data-id="${editor.user.id}">Edit</button>
                                <button class="btn btn-sm btn-danger editorTrashInfo" data-id="${editor.id}">Trash</button>
                            </td>
                        </tr>`;
                    $('#admin_added_editor_lists_body').append(row);
                });

                $('#admin_added_editor_lists').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }

            //Edit Editor 
            $(document).on('click', '.EditorEditInfo', function() {
                let id = $(this).data('id');
               // console.log('editor edit id is', id);
                // Call function and show modal
                adminEditorEditFillupForm(id);
                $('#adminEditorEditModal').modal('show');
            });




            // Trash Editor
            $(document).off('click', '.editorTrashInfo').on('click', '.editorTrashInfo', async function() {
                const id = $(this).data('id');
                // console.log('editor trash id is',id);
                const confirm = await Swal.fire({
                    title: 'Are you sure?',
                    text: "This editor will be trashed!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, trash'
                });

                if (!confirm.isConfirmed) return;
                // Show loader on table
                $('#adminEditorTableLoader').show();

                try {
                    const res = await axios.post('/admin/editor/trash-by-id', {
                        id
                    }, {
                        headers: {
                            Authorization: 'Bearer ' + token
                        }
                    });

                    if (res.data.status === 'success') {
                        Swal.fire('Trashed!', res.data.message, 'success');
                        await loadAdminAddedEditorLists();
                        await loadAdminAddedEditorTrashLists();
                        //await getEditorTrashTeacherLists();
                    } else {
                        Swal.fire('Error', res.data.message || 'Trash failed', 'error');
                    }
                } catch {
                    Swal.fire('Error', 'Server or network error', 'error');
                } finally {
                    $('#adminEditorTableLoader').hide();
                }
            });
            
            // Editor View Info
            $(document).off('click', '.EditorViewInfo').on('click', '.EditorViewInfo', async function() {
                const email = $(this).data('email');
                // console.log('editor trash id is',id);
                adminEditorDetailsFormat(email);
                $('#adminDBEditorDetailsModal').show();
            });


        } catch (error) {
            console.error('Error fetching editor:', error);
        }
    }




    //admin added by editor trash lists 
    loadAdminAddedEditorTrashLists();
    async function loadAdminAddedEditorTrashLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }
        try {
            const res = await axios.post('/admin_db/editor/list', {}, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                const trashEditors = res.data.editorTrashLists;
                //console.log(editors);
                document.querySelector('.adminAddedTotalTrashEditorCount').innerText = trashEditors.length;

                if ($.fn.DataTable.isDataTable('#admin_added_editor_trash_lists')) {
                    $('#admin_added_editor_trash_lists').DataTable().destroy();
                }
                $('#admin_added_editor_trash_lists_body').html('');

                trashEditors.forEach((editor, index) => {
                    // console.log(editor);
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${editor.user.name}</td>
                            <td>${editor.user.email || ''}</td>
                            <td>
                                <button class="btn btn-sm btn-primary TrashEditorEditRestore" data-id="${editor.id}">RESTORE</button>
                                <button class="btn btn-sm btn-danger TrashEditorEditDelete" data-id="${editor.id}">DELETE</button>
                            </td>
                        </tr>`;
                    $('#admin_added_editor_trash_lists_body').append(row);
                });

                $('#admin_added_editor_trash_lists').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }

                // Restore Editor
                $(document).off('click', '.TrashEditorEditRestore').on('click', '.TrashEditorEditRestore',async function() {
                    let token = localStorage.getItem('token');
                    if (!token) {
                        alert('Unauthorized Access');
                        return;
                    }
                    const id = $(this).data('id');
                    // console.log('editor trash id is',id);
                    const confirm = await Swal.fire({
                        title: 'Are you sure?',
                        text: "This editor will be restored!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Restore'
                    });

                    if (!confirm.isConfirmed) return;

                    // Show loader
                    $('#adminEditorTrashTableLoader').show();

                    try {
                        const res = await axios.post('/admin/editor/restore-by-id', {
                            id
                        }, {
                            headers: {
                                Authorization: 'Bearer ' + token
                            }
                        });

                        if (res.data.status === 'success') {
                            Swal.fire('Restored!', res.data.message, 'success');
                            await loadAdminAddedEditorLists();
                            await loadAdminAddedEditorTrashLists();
                        } else {
                            Swal.fire('Error', res.data.message || 'Restore failed', 'error');
                        }
                    } catch (error) {
                        console.log(error.response ? error.response.data : error.message);
                        Swal.fire('Error', 'Server or network error', 'error');
                    } finally {
                        $('#adminEditorTrashTableLoader').hide();
                    }
                });



                    // Permanent Delete Editor
                $(document).off('click', '.TrashEditorEditDelete').on('click', '.TrashEditorEditDelete',async function() {
                    let token = localStorage.getItem('token');
                    if (!token) {
                        alert('Unauthorized Access');
                        return;
                    }
                    const id = $(this).data('id');
                    // console.log('editor trash id is',id);
                    const confirm = await Swal.fire({
                        title: '⚠️ Confirm Permanent Deletion',
                        text: "This editor will be permanently deleted. This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete Permanently',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#d33',   // Red for danger
                        cancelButtonColor: '#3085d6', // Blue for safe cancel
                        background: '#f9f9f9',       // Soft professional background
                        color: '#333',               // Text color
                        iconColor: '#d33',           // Warning icon in red
                        focusConfirm: false,         // Avoid accidental enter key triggers
                        focusCancel: true
                    });


                    if (!confirm.isConfirmed) return;

                    // Show loader
                    $('#adminEditorTrashTableLoader').show();

                    try {
                        const res = await axios.post('/admin/editor/delete-by-id', {
                            id
                        }, {
                            headers: {
                                Authorization: 'Bearer ' + token
                            }
                        });

                        if (res.data.status === 'success') {
                            Swal.fire('Restored!', res.data.message, 'success');
                            await loadAdminAddedEditorLists();
                            await loadAdminAddedEditorTrashLists();
                        } else {
                            Swal.fire('Error', res.data.message || 'Restore failed', 'error');
                        }
                    } catch (error) {
                        console.log(error.response ? error.response.data : error.message);
                        Swal.fire('Error', 'Server or network error', 'error');
                    } finally {
                        $('#adminEditorTrashTableLoader').hide();
                    }
                });

        } catch (error) {
            console.error('Error fetching editor:', error);
        }
        // finally {
        //     $('#editorTableLoader').hide();
        // }
    }
</script>
