<!-- Modal -->
<div class="modal fade" id="changePasswordModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Admin Password Change</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" id="password_profile_email" name="email" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label>Current Password</label>
                    <input type="password" id="password_current_password" name="current_password" class="form-control"
                        required>
                </div>
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" id="password_new_password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm New Password</label>
                    <input type="password" id="confirm_password" name="new_password_confirmation" class="form-control"
                        required>
                </div>
                <!-- Checkbox to toggle passwords -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="showPasswords">
                    <label class="form-check-label" for="showPasswords">Show Passwords</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updatePassword(event)">Update Password</button>
            </div>
        </div>
    </div>
</div>









<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    async function fillUpdatePasswordForm(email) {

        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/admin/login';
            return;
        }
        document.querySelector('#password_profile_email').value = email;
    }



    async function updatePassword() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/admin/login';
            return;
        }

        let email = document.querySelector('#password_profile_email').value.trim();
        let current_password = document.querySelector('#password_current_password').value.trim();
        let new_password = document.querySelector('#password_new_password').value.trim();
        let confirm_password = document.querySelector('#confirm_password').value.trim();

        // Validation
        if (!current_password || !new_password || !confirm_password) {
            return Swal.fire('Warning', 'All fields are required!', 'warning');
        }

        if (new_password !== confirm_password) {
            return Swal.fire('Error', 'New Password and Confirm Password do not match!', 'error');
        }

        if (new_password.length < 6) {
            return Swal.fire('Error', 'Password must be at least 6 characters long!', 'error');
        }

        let data = {
            email: email,
            current_password: current_password,
            new_password: new_password,
            new_password_confirmation: confirm_password
        };
        //console.log(data);
        try {
            let res = await axios.post('/admin/password/update', data, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                Swal.fire('Success', 'Password updated successfully!', 'success').then(() => {
                    localStorage.removeItem('token');
                    window.location.href = '/admin/login';
                });
            } else {
                Swal.fire('Error', res.data.message || 'Password update failed!', 'error');
            }
        } catch (error) {
            if (error.response) {
                if (error.response.status === 422) {
                    // Validation errors
                    let errors = error.response.data.errors;
                    let messages = Object.values(errors).flat().join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: messages,
                    });
                } else {
                    // Other errors
                    Swal.fire('Error', error.response.data.message || 'Something went wrong!', 'error');
                }
            } else {
                Swal.fire('Error', 'Network error or server not responding!', 'error');
            }
            //console.log(error);
        }

    }

    // Toggle Password Show/Hide
    $('#showPasswords').on('change', function() {
        let type = this.checked ? 'text' : 'password';
        $('#password_current_password, #password_new_password, #confirm_password').attr('type', type);
    });
</script>
