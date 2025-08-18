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
    <h1 class="h3 mb-4 text-gray-800">Editor Profile</h1>

    <div class="row">

        <div class="col-lg-4">
            <div class="card shadow card-profile">
                <!-- Profile Image Centered -->
                <div class="text-center">
                    <img id="profile_img_preview" src="/uploads/admin/profile/default.png" alt="Profile Picture"
                        class="profile-img-table">
                </div>

                <!-- Profile Info Table -->
                <table class="table table-striped w-100 table-profile">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td class="profile_name"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td class="profile_email"></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td class="profile_phone"></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td class="profile_role"></td>
                        </tr>
                        <tr>
                            <th>Joined On</th>
                            <td class="profile_joined_at"></td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td class="profile_updated_at"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="profile_status" class="badge status-badge"
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
                    {{-- <input type="text" name="'user_id" class="user_id">
                    <input type="text" name="'institution_id" class="institution_id"> --}}
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- Father Name -->
                        <div class="mb-3">
                            <label for="father_name" class="form-label">Father's Name</label>
                            <input type="text" name="father_name" value="" class="form-control"
                                placeholder="Enter Your Fater's Name">
                        </div>

                        <!-- Mother Name -->
                        <div class="mb-3">
                            <label for="mother_name" class="form-label">Mother's Name</label>
                            <input type="text" name="mother_name" value=""class="form-control"
                                placeholder="Enter Your Mother's Name">
                        </div>
                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" value="" class="form-control phone"
                                placeholder="Enter Your Phone">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="form-control address"></textarea>
                        </div>

                        <!-- Birth Date -->
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Birth Date</label>
                            <input type="date" name="birth_date" value="" class="form-control birth_date">
                        </div>

                        <!-- NID -->
                        <div class="mb-3">
                            <label for="nid" class="form-label">NID</label>
                            <input type="text" name="nid" value="" class="form-control nid"
                                placeholder="Enter Your NID">
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" class="form-select form-control gender">
                                <option value="">---Choose One---</option>
                                <option value="male"> Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Religion -->
                        <div class="mb-3">
                            <label for="religion" class="form-label">Religion</label>
                            <select name="religion" class="form-select form-control religion">
                                <option value="">---Choose One---</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Muslim">Muslim</option>
                                <option value="Buddhist">Buddhist</option>
                                <option value="Christian">Christian</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Marital Status -->
                        <div class="mb-3">
                            <label for="marital_status" class="form-label">Marital Status</label>
                            <select name="marital_status" class="form-select form-control">
                                <option value="">---Choose One---</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>

                        <!-- Nationality -->
                        <div class="mb-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" name="nationality" value="Bangladeshi"
                                class="form-control nationality">
                        </div>
                        <!-- Profile Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control image" accept="image/*">
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary" onclick="updateProfile(event)">Update
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
    getUserInfo();
    async function getUserInfo() {
        document.getElementById('loader').style.display = 'block';
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/editor/login';
            return;
        }

        try {
            let res = await axios.post('/auth/editor/details', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
               // console.log(res.data.data.editors[0]);
                let editorDetails = res.data.data.editors[0]
                document.querySelector('.profile_name').innerHTML = res.data.data.name || 'N/A';
                document.querySelector('.profile_email').innerHTML = res.data.data.email || 'N/A';
                document.querySelector('.profile_phone').innerHTML = res.data.data.editors[0].phone || 'N/A';
                document.querySelector('.profile_role').innerHTML = res.data.data.role || 'N/A';
                document.querySelector('.profile_status').innerHTML = res.data.data.editors[0].is_active === 1 ?
                    'Active' : 'Inactive';
                document.querySelector('.profile_joined_at').innerHTML = res.data.data.created_at ? new Date(res
                    .data.data.created_at).toLocaleDateString() : 'N/A';
                document.querySelector('.profile_updated_at').innerHTML = res.data.data.updated_at ? new Date(res
                    .data.data.updated_at).toLocaleDateString() : 'N/A';
                let birthDate = res.data.data.editors[0].birth_date;


                document.querySelector('input[name="father_name"]').value = editorDetails.father_name ?editorDetails.father_name : 'N/A'
                document.querySelector('input[name="mother_name"]').value = editorDetails.mother_name ?editorDetails.mother_name : 'N/A'
                document.querySelector('input[name="phone"]').value = editorDetails.phone ? editorDetails.phone :'N/A'
                document.querySelector('textarea[name="address"]').value = editorDetails.address?editorDetails.address:'N/A'
                document.querySelector('input[name="nid"]').value = editorDetails.nid ? editorDetails.nid : 'N/A'
                //date
                let birthDateInput = document.querySelector('input[name="birth_date"]');
                if (birthDateInput) birthDateInput.value = editorDetails.birth_date || '';
                // Gender
                let genderSelect = document.querySelector('select[name="gender"]');
                if (genderSelect) genderSelect.value = editorDetails.gender || '';

                // Religion
                let religionSelect = document.querySelector('select[name="religion"]');
                if (religionSelect) religionSelect.value = editorDetails.religion || '';

                // Marital Status
                let maritalSelect = document.querySelector('select[name="marital_status"]');
                if (maritalSelect) maritalSelect.value = editorDetails.marital_status || '';

                document.querySelector('input[name="nationality"]').value = editorDetails.nationality ?
                    editorDetails.nationality : 'N/A'
                // Profile image set if exists
                if (editorDetails.image) {
                    document.querySelector('#profile_img_preview').src =
                        `/uploads/editor/profile/${editorDetails.image}`;
                } else {
                    document.querySelector('#profile_img_preview').src = `/uploads/editor/profile/default.png`;
                }


            }

            if (res.data.status === 'error') {
                console.log('success Error',res.data);
                // localStorage.removeItem('token');
                // window.location.href = '/admin/login';
            }
        } catch (error) {
            Swal.fire('Error', 'Authentication failed. Please login again.', 'error').then(() => {
                // localStorage.removeItem('token');
                // window.location.href = '/admin/login';
                console.log(error)
            });
        } finally {
            document.getElementById('loader').style.display = 'none';
        }
    }

    // Image preview handler
    document.querySelector('.image').addEventListener('change', function(event) {
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
        // if (!token) {
        //     window.location.href = '/admin/login';
        //     return;
        // }
        let email = $('.profile_email').text().trim();
        //console.log(email);
        if (email) {
            await editorFillUpdatePasswordForm(email);
            $('#editorChangePasswordModal').modal('show');
        }
    });




    // Update user profile
async function updateProfile(event) {
    event.preventDefault();
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = '/editor/login';
        return;
    }

    // Create formData
    let formData = new FormData();

    // Helper to safely get value
    function getValue(selector, defaultValue = '') {
        const el = document.querySelector(selector);
        return el ? el.value.trim() : defaultValue;
    }

    // Append text inputs
    formData.append('father_name', getValue('input[name="father_name"]'));
    formData.append('mother_name', getValue('input[name="mother_name"]'));
    formData.append('phone', getValue('input[name="phone"]'));
    formData.append('address', getValue('textarea[name="address"]'));
    formData.append('birth_date', getValue('input[name="birth_date"]'));
    formData.append('nid', getValue('input[name="nid"]'));
    formData.append('nationality', getValue('input[name="nationality"]'));

    // Append selects
    formData.append('gender', getValue('select[name="gender"]'));
    formData.append('religion', getValue('select[name="religion"]'));
    formData.append('marital_status', getValue('select[name="marital_status"]'));

    // Append image if selected
    const imageFile = document.querySelector('input[name="image"]')?.files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    // Show loader
    document.getElementById('loader').style.display = 'block';

    try {
        const res = await axios.post('/editor/update-profile', formData, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'multipart/form-data'
            }
        });

        // Hide loader
        document.getElementById('loader').style.display = 'none';

        if (res.data.status === 'success') {
            Swal.fire('Success', 'Profile updated successfully', 'success');

            // Update profile image if uploaded
            if (res.data.data.image) {
                document.querySelector('#profile_img_preview').src = res.data.data.image;
            }

            getUserInfo(); // Refresh profile info
        } else {
            Swal.fire('Error', res.data.message || 'Something went wrong', 'error');
        }
    } catch (error) {
        // Hide loader
        document.getElementById('loader').style.display = 'none';

        if (error.response) {
            if (error.response.status === 422) {
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
            } else {
                Swal.fire('Error', error.response.data.message || 'Failed to update profile', 'error');
            }
        } else {
            Swal.fire('Error', 'Network or unknown error occurred', 'error');
        }
    }
}

</script>
