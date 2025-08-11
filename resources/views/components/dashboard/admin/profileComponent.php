<div class="container-fluid mt-4">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Admin Profile</h1>

    <div class="row">

        <!-- Profile Info Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <img id="profile_img_preview" src="/uploads/admin/profile/default.png" alt="Profile Picture"
                        class="rounded-circle img-fluid mb-3 text-center"
                        style="width: 150px; height: 150px; object-fit: cover; margin:0 auto">

                    <h5 class="card-title">Name: <span id="profile_name"></span></h5>
                    <h5 class="card-title">Email: <span id="profile_email"></span></h5>
                    <h5 class="card-title">Phone: <span id="profile_phone"></span></h5>
                    <h5 class="card-title">Role: <span id="profile_role"></span></h5>
                    <h5 class="card-title">Status: <span class="badge bg-primary text-white p-1"
                            id="profile_status"></span></h5>
                </div>
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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    getUserInfor();

    async function getUserInfor() {
        document.getElementById('loader').style.display = 'block';
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/admin/login';
            return;
        }

        try {
            let res = await axios.post('/auth/admin/details', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                let birthDate = res.data.data.admin.birth_date;

                console.log(res.data.data.admin.image)

                document.querySelector('#profile_name').innerHTML = res.data.data.name || 'N/A';
                document.querySelector('#profile_email').innerHTML = res.data.data.email || 'N/A';
                document.querySelector('#profile_phone').innerHTML = res.data.data.admin.phone || 'N/A';
                document.querySelector('#profile_role').innerHTML = res.data.data.role || 'N/A';
                document.querySelector('#profile_status').innerHTML = res.data.data.admin.is_active ? 'Active' :
                    'Inactive';

                //form details
                document.querySelector('#phone').value = res.data.data.admin.phone ? res.data.data.admin.phone : '';
                document.querySelector('#address').value = res.data.data.admin.address ? res.data.data.admin
                    .address : '';
                if (birthDate) {
                    document.querySelector('#birth_date').value = birthDate.substring(0, 10); // "YYYY-MM-DD"
                } else {
                    document.querySelector('#birth_date').value = '';
                }
                document.querySelector('#nid').value = res.data.data.admin.nid ? res.data.data.admin.nid : '';
                document.querySelector('#gender').value = res.data.data.admin.gender ? res.data.data.admin.gender :
                    '';



                // Profile image set if exists
                if (res.data.data.admin.image) {
                    document.querySelector('#profile_img_preview').src = res.data.data.admin.image;
                }
            }

            if (res.data.status === 'error') {
                localStorage.removeItem('token');
                window.location.href = '/admin/login';
            }
        } catch (error) {
            Swal.fire('Error', 'Authentication failed. Please login again.', 'error').then(() => {
                // localStorage.removeItem('token');
                // window.location.href = '/admin/login';
                conosle.log(error)
            });
        }finally{
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



    // Update user profile
    async function updateUserProfile(event) {
        event.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/admin/login';
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
            let res = await axios.post('/admin/update-profile', formData, {
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
