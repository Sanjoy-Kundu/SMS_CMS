<style>
    .profile-img-table {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #007B7F;
        box-shadow: 0 0 8px rgba(23, 162, 184, 0.6);
    }

    .table-profile {
        max-width: 100%;
        margin-top: 1rem;
    }

    .btn-change-password-table {
        margin-top: 1rem;
        width: 100%;
        font-weight: 600;
    }
</style>
<div class="container-fluid mt-4">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Teacher Profile</h1>

    <div class="row">

        <div class="col-lg-4">
            <div class="card shadow card-profile">
                <!-- Profile Image Centered -->
                <div class="text-center">
                    <img id="profile_img_preview" src="/uploads/teacher/profile/default.png" alt="Profile Picture"
                        class="profile-img-table">
                </div>

                <!-- Profile Info Table -->
                <table class="table table-striped w-100 table-profile">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td id="profile_name"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="profile_email"></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td id="profile_phone"></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td id="profile_role"></td>
                        </tr>
                        <tr>
                            <th>Joined On</th>
                            <td id="profile_joined_at"></td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td id="profile_updated_at"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span id="profile_status" class="badge status-badge"
                                    style="font-size: 20px;color:white; background-color:#007B7F;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Action</td>
                            <td>
                                <button type="button" class="btn passwordChangeBtn"
                                    style="background-color: #007B7F; color: white;">
                                    Change Password
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>






        <!-- Profile Edit Form -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" value="" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="nid" class="form-label">NID</label>
                            <input type="text" name="nid" id="nid" value="" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select form-control">
                                <option value="">---Choose One ---</option>
                                <option value="male"> Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary" onclick="updateUserProfile(event)">Update
                            Profile</button>
                    </form>
                </div>
            </div>


        </div>

    </div>
    <div id="loader"
        style="
                display:none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(255,255,255,0.7);
                z-index: 1050;
                text-align: center;
                padding-top: 20vh;
               ">
        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    getUserInfor();

    async function getUserInfor() {
        document.getElementById('loader').style.display = 'block';
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/teacher/login';
            return;
        }

        try {
            let res = await axios.post('/auth/teacher/details', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                let birthDate = res.data.data.teacher.birth_date;

                /*console.log(res.data)
                console.log(res.data.data.email)
                */

                document.querySelector('#profile_name').innerHTML = res.data.data.name || 'N/A';
                document.querySelector('#profile_email').innerHTML = res.data.data.email || 'N/A';
                document.querySelector('#profile_phone').innerHTML = res.data.data.teacher.phone || 'N/A';
                document.querySelector('#profile_role').innerHTML = res.data.data.role || 'N/A';
                document.querySelector('#profile_status').innerHTML = res.data.data.teacher.is_active ? 'Active' :
                    'Inactive';
                document.querySelector('#profile_joined_at').innerHTML = res.data.data.created_at ? new Date(res
                    .data.data.created_at).toLocaleDateString() : 'N/A';
                document.querySelector('#profile_updated_at').innerHTML = res.data.data.updated_at ? new Date(res
                    .data.data.updated_at).toLocaleDateString() : 'N/A';

                //form details
                document.querySelector('#phone').value = res.data.data.teacher.phone ? res.data.data.teacher.phone : '';
                document.querySelector('#address').value = res.data.data.teacher.address ? res.data.data.teacher
                    .address : '';
                if (birthDate) {
                    document.querySelector('#birth_date').value = birthDate.substring(0, 10); // "YYYY-MM-DD"
                } else {
                    document.querySelector('#birth_date').value = '';
                }
                document.querySelector('#nid').value = res.data.data.teacher.nid ? res.data.data.teacher.nid : '';
                document.querySelector('#gender').value = res.data.data.teacher.gender ? res.data.data.teacher.gender :
                    '';



                // Profile image set if exists
                if (res.data.data.teacher.image) {
                    document.querySelector('#profile_img_preview').src = res.data.data.teacher.image;
                }
            }

            if (res.data.status === 'error') {
                localStorage.removeItem('token');
                window.location.href = '/teacher/login';
            }
        } catch (error) {
            Swal.fire('Error', 'Authentication failed. Please login again.', 'error').then(() => {
                // localStorage.removeItem('token');
                // window.location.href = '/teacher/login';
                conosle.log(error)
            });
        } finally {
            document.getElementById('loader').style.display = 'none';
        }
    }

    // Image preview handler
    document.querySelector('#image').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#profile_img_preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });



    //password change button
    $('.passwordChangeBtn').on('click',async function() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/teacher/login';
            return;
        }
        let email = $('#profile_email').text().trim();
        //console.log(email);
        if (email) {
            await fillUpdatePasswordForm(email);
            $('#changePasswordModal').modal('show');
        }
    });



    // Update user profile
    async function updateUserProfile(event) {
        event.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/teacher/login';
            return;
        }

        let phone = document.querySelector('#phone').value.trim();
        let address = document.querySelector('#address').value.trim();
        let birth_date = document.querySelector('#birth_date').value.trim();
        let nid = document.querySelector('#nid').value.trim();
        let gender = document.querySelector('#gender').value.trim();
        let image = document.querySelector('#image').files[0];

        // Validation (frontend)
        if (!phone) return Swal.fire('Error', 'Phone is required', 'error');
        if (!address) return Swal.fire('Error', 'Address is required', 'error');
        if (!birth_date) return Swal.fire('Error', 'Birth Date is required', 'error');
        if (!nid) return Swal.fire('Error', 'NID is required', 'error');
        if (!gender) return Swal.fire('Error', 'Gender is required', 'error');

        let formData = new FormData();
        formData.append('phone', phone);
        formData.append('address', address);
        formData.append('birth_date', birth_date);
        formData.append('nid', nid);
        formData.append('gender', gender);
        if (image) formData.append('image', image);

        // Show loader
        document.getElementById('loader').style.display = 'block';

        try {
            let res = await axios.post('/teacher/update-profile', formData, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'multipart/form-data'
                }
            });

            // Hide loader
            document.getElementById('loader').style.display = 'none';

            if (res.data.status === 'success') {
                Swal.fire('Success', 'Profile updated successfully', 'success');
                getUserInfor(); // Refresh profile info
            } else {
                Swal.fire('Error', res.data.message || 'Something went wrong', 'error');
            }
        } catch (error) {
            // Hide loader
            document.getElementById('loader').style.display = 'none';

            if (error.response) {
                if (error.response.status === 422) {
                    // Laravel validation errors (422 Unprocessable Entity)
                    const errors = error.response.data.errors;
                    let messages = '';
                    for (const key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            messages += errors[key].join(' ') + '<br>';
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: messages
                    });
                } else if (error.response.status === 400) {
                    // Your custom "Please Change Something" error
                    Swal.fire('Error', error.response.data.message || 'Please change something', 'error');
                } else {
                    // Other errors
                    Swal.fire('Error', error.response.data.message || 'Failed to update profile', 'error');
                }
            } else {
                Swal.fire('Error', 'Network or unknown error occurred', 'error');
            }
        }
    }
</script>
