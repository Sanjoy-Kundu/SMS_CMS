<div class="modal fade" id="adminEditorEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="adminEditorEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Editor Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                    <!-- Loader -->
                <div id="editorLoader" style="display: none; text-align:center; padding:20px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>Loading editor details...</p>
                </div>
                <form id="adminEditorEditForm">
                    <div class="form-group" hidden>
                        <label for="user_editor_id">ID</label>
                        <input type="text" class="form-control" name="id" id="user_editor_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user_editor_name">Name</label>
                        <input type="text" class="form-control" name="name" id="user_editor_name">
                    </div>
                    <div class="form-group">
                        <label for="user_editor_email">Email</label>
                        <input type="email" class="form-control" name="email" id="user_editor_email">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="adminEditorEditForm" class="btn btn-primary" onclick="updateEditorByAdmin(event)">Update Editor</button>
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
async function adminEditorEditFillupForm(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        alert('Unauthorized Access');
        return;
    }

    try {
        // Show loader and hide form initially
        $('#editorLoader').show();
        $('#adminEditorEditForm').hide();

        // Set ID field
        $('#user_editor_id').val(id);

        // Fetch editor details
        let res = await axios.post('/editor/details-by-id', { id: id }, {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (res.data.status === 'success') {
            // Fill name & email
            document.querySelector('#adminEditorEditModal [name="name"]').value = res.data.editorDetails.name;
            document.querySelector('#adminEditorEditModal [name="email"]').value = res.data.editorDetails.email;

            // Hide loader & show form
            $('#editorLoader').hide();
            $('#adminEditorEditForm').show();
        } else {
            Swal.fire('Error', res.data.message || 'Failed to load editor details', 'error');
            $('#adminEditorEditModal').modal('hide');
        }

        // Show modal
        $('#adminEditorEditModal').modal('show');

    } catch (error) {
        console.log(error);
        Swal.fire('Error', 'Server error occurred', 'error');
        $('#adminEditorEditModal').modal('hide');
    }
}





async function updateEditorByAdmin(event) {
    event.preventDefault();

    const token = localStorage.getItem('token');
    if (!token) {
        Swal.fire('Unauthorized', 'You are not authorized to perform this action.', 'error');
        return;
    }

    const id = $('#user_editor_id').val();
    const name = $('#user_editor_name').val().trim();
    const email = $('#user_editor_email').val().trim();

    if (!name || !email) {
        Swal.fire('Validation Error', 'Name and Email are required.', 'warning');
        return;
    }

    // Disable button & inputs
    const btn = $(event.target);
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Updating...');
    $('#adminEditorEditForm input').prop('disabled', true);

    try {
        const res = await axios.post(
            '/editor/update-by-id',
            { id, name, email },
            { headers: { Authorization: `Bearer ${token}` } }
        );

        if (res.data.status === 'success') {
            // Reload editor list
            await loadAdminAddedEditorLists();

            Swal.fire({
                icon: 'success',
                title: 'Update Successful',
                text: res.data.message || 'Editor details updated successfully.',
                timer: 2000,
                showConfirmButton: false
            });

            $('#adminEditorEditModal').modal('hide');
        } else {
            Swal.fire('Update Failed', res.data.message || 'No changes detected.', 'info');
        }
    } catch (error) {
        const msg = error.response?.data?.message || 'An unexpected server error occurred.';
        Swal.fire('Error', msg, 'error');
    } finally {
        // Re-enable button & inputs
        btn.prop('disabled', false).html('Update Editor');
        $('#adminEditorEditForm input').prop('disabled', false);
    }
}




</script>
