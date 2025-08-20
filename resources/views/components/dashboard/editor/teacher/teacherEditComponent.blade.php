<style>
    /* Loader Overlay for form card */
    .loader-overlay {
        display: none; /* hidden initially */
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7); /* transparent white */
        z-index: 1050; /* modal এর উপরে দেখানোর জন্য */
        border-radius: 0.35rem;
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

<!-- Modal -->
<div class="modal fade" id="editorTeacherEditModal" tabindex="-1" role="dialog"
    aria-labelledby="editorTeacherEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content position-relative">
            
            <!-- Loader Overlay -->
            <div class="loader-overlay" id="updateTeacherloader">
                <div class="loader-bar"></div>
            </div>

            <div class="modal-header">
                <h5 class="modal-title" id="editorTeacherEditModalLabel">Update Your Teacher</h5>
            </div>
            <div class="modal-body">
                <form id="teacherForm">
                    <div class="form-group" hidden>
                        <label for="name">Teacher Id</label>
                        <input type="text" class="form-control" id="update_editor_teacher_id" name="id" readonly>
                        <span id="update_teacher_id_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Teacher Name</label>
                        <input type="text" class="form-control" id="update_editor_teacher_name" name="name"
                            placeholder="Enter teacher name">
                        <span id="update_editor_teacher_name_error" class="text-danger small"></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Teacher Email</label>
                        <input type="email" class="form-control" id="update_editor_teacher_email" name="email"
                            placeholder="Enter teacher Email">
                        <span id="update_editor_teacher_email_error" class="text-danger small"></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" id="submitBtn"
                        onclick="updateEitorteacher(event)">Update
                        teacher</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showLoader() {
        document.getElementById('updateTeacherloader').style.display = 'block';
    }
    function hideLoader() {
        document.getElementById('updateTeacherloader').style.display = 'none';
    }

    async function fillEditorTeacherForm(id) {
        let token = localStorage.getItem('token')
        if (!token) {
            Swal.fire('Unauthorized', 'You are not logged in', 'error');
            return;
        }

        document.querySelector('#update_editor_teacher_id').value = id;
        
        showLoader(); // Loader ON

        try {
            let res = await axios.post('/admin-teacher/details-by-id', { id: id }, {
                headers: { 'Authorization': `Bearer ${token}` }
            });

            if (res.data.status === 'success') {
                let teacher = res.data.teacherDetails.user;
                document.querySelector('#update_editor_teacher_name').value = teacher.name;
                document.querySelector('#update_editor_teacher_email').value = teacher.email;
            }
        } catch (err) {
            Swal.fire('Error', 'Failed to load teacher details', 'error');
        } finally {
            hideLoader(); // Loader OFF
        }
    }

    async function updateEitorteacher(event){
        event.preventDefault();

        let token = localStorage.getItem('token');
        if(!token){
            Swal.fire('Unauthorized', 'You are not logged in', 'error');
            return;
        }

        let id = document.querySelector('#update_editor_teacher_id').value.trim();
        let name = document.querySelector('#update_editor_teacher_name').value.trim();
        let email = document.querySelector('#update_editor_teacher_email').value.trim();

        if(!id){ Swal.fire('Error','Invalid Teacher ID','error'); return; }
        if(!name){ Swal.fire('Error','Teacher name is required','error'); return; }
        if(!email){ Swal.fire('Error','Teacher email is required','error'); return; }

        let data = {id:id, name:name, email:email};

        showLoader(); // Loader ON

        try {
            let res = await axios.post('/update-teacher-by-admin', data, {
                headers:{ 'Authorization':`Bearer ${token}` }
            });

            if(res.data.status === 'success'){
                await getEditorSelfTeacherLists();
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: res.data.message,
                    confirmButtonColor: '#3085d6'
                });

                $('#editorTeacherEditModal').modal('hide');
            } else {
                Swal.fire('Error', res.data.message, 'error');
            }
        } catch (err) {
            console.log(err);
            Swal.fire('Error', 'Something went wrong: ' + err.message, 'error');
        } finally {
            hideLoader(); // Loader OFF
        }
    }
</script>
