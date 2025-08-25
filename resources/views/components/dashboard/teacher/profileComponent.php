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
                                    style="font-size: 20px;color:green;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Action</td>
                            <td>
                                <button type="button" class="btn passwordChangeBtn"
                                    style="background-color: #007B7F; color: white;">Change Password</button>
                                <button type="button" class="btn viewProfileCV"
                                    style="background-color: #418bff; color: white;">View Profile</button>
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
                    <input type="text" name="'institution_id" class="institution_id" hidden>
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

                              <!-- myself -->
                        <div class="mb-3">
                            <label for="about_me" class="form-label">About MySelf</label>
                            <textarea name="about_me" class="form-control about_me"></textarea>
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

            <!-- Education -->
            <div class="card shadow mb-4">
                <div class="card-header">Educational Qualifications</div>
                <div class="card-body">
                     <!-- Editor select if needed -->
                        <input type="number" readonly name="teacher_id" class="teacher_id form-control" hidden>
                    <form action="" id="teacherEducaionl_qualificationForm">
                       

                        <div class="mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Level</label>
                                <select name="level" class="form-control">
                                    <option value="">---Select Level---</option>
                                    <option value="SSC">SSC</option>
                                    <option value="HSC">HSC</option>
                                    <option value="Graduation">Graduation</option>
                                    <option value="Masters">Masters</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Roll Number</label>
                            <input type="text" name="roll_number" class="form-control"
                                placeholder="Enter Roll Number">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Board/University</label>
                            <input type="text" name="board_university" class="form-control"
                                placeholder="Enter Board/University">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Result</label>
                                <input type="text" name="result" class="form-control"
                                    placeholder="GPA/Division">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Passing Year</label>
                                <input type="number" name="passing_year" class="form-control" placeholder="YYYY">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Course Duration</label>
                                <input type="text" name="course_duration" class="form-control"
                                    placeholder="Only for Graduation/Masters">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success" onclick="teacherEducation(event)">Save
                            Education</button>
                    </form>


                    <!-- Education List (View) -->
                    <hr>
                    <h6 class="section-title">Educational Qualifications</h6>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Board</th>
                                <th>Roll Number</th>
                                <th>Result</th>
                                <th>Year</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="educationTableBody"></tbody>
                    </table>
                </div>
            </div>




            <!-- Address -->
             
            <div class="card shadow mb-4">
                <div class="card-header">Addresses</div>
                <div class="card-body">
                    <input type="number" name="teacher_id" class="form-control address_teacher_id" readonly hidden>
                    <form id="teacher_address_Form">
                        <!-- Address Type -->
                        <div class="mb-3">
                            <label class="form-label">Address Type</label>
                            <select name="type" class="form-control" required>
                                <option value="">---Select Type---</option>
                                <option value="present">Present</option>
                                <option value="permanent">Permanent</option>
                            </select>
                        </div>

                        <!-- Village -->
                        <div class="mb-3">
                            <label class="form-label">Village</label>
                            <input type="text" name="village" class="form-control" placeholder="Village"
                                required>
                        </div>

                        <!-- District -->
                        <div class="mb-3">
                            <label class="form-label">District</label>
                            <input type="text" name="district" class="form-control" placeholder="District">
                        </div>

                        <!-- Upazila -->
                        <div class="mb-3">
                            <label class="form-label">Upazila</label>
                            <input type="text" name="upazila" class="form-control" placeholder="Upazila">
                        </div>

                        <!-- Post Office -->
                        <div class="mb-3">
                            <label class="form-label">Post Office</label>
                            <input type="text" name="post_office" class="form-control" placeholder="Post Office">
                        </div>

                        <!-- Postal Code -->
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-success" onclick="TeacherAddress(event)">Save
                            Address</button>
                    </form>

                    <!-- Address List (View) -->
                    <hr>
                    <h6 class="section-title">Address List</h6>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Village</th>
                                <th>District</th>
                                <th>Upazila</th>
                                <th>Post Office</th>
                                <th>Postal Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="TeacherAddressTableBody">
                           
                        </tbody>
                    </table>
                </div>
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
            let res = await axios.post('/auth/teacher/details', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                let teachersDetails = res.data.data.teachers[0];
               // console.log(teachersDetails);
                document.querySelector('.teacher_id').value = teachersDetails.id;
                document.querySelector('.address_teacher_id').value = teachersDetails.id;
                document.querySelector('.profile_name').innerHTML = res.data.data.name || 'N/A';
                document.querySelector('.profile_email').innerHTML = res.data.data.email || 'N/A';
                document.querySelector('.profile_phone').innerHTML = teachersDetails.phone || 'N/A';
                document.querySelector('.profile_role').innerHTML = res.data.data.role || 'N/A';
              
                document.querySelector('.profile_status').innerHTML = teachersDetails.is_active === 1 ?
                      'Active' : 'Inactive';
                document.querySelector('.profile_joined_at').innerHTML = res.data.data.created_at ? new Date(res
                    .data.data.created_at).toLocaleDateString() : 'N/A';
                document.querySelector('.profile_updated_at').innerHTML = res.data.data.updated_at ? new Date(res
                    .data.data.updated_at).toLocaleDateString() : 'N/A';
                 let birthDate = teachersDetails.birth_date;


                
                document.querySelector('input[name="father_name"]').value = teachersDetails.father_name ?
                    teachersDetails.father_name : 'N/A'
                document.querySelector('input[name="mother_name"]').value = teachersDetails.mother_name ?
                    teachersDetails.mother_name : 'N/A'
                document.querySelector('input[name="phone"]').value = teachersDetails.phone ? teachersDetails.phone :
                    'N/A'
                document.querySelector('textarea[name="address"]').value = teachersDetails.address ? teachersDetails
                    .address : 'N/A'
                document.querySelector('input[name="nid"]').value = teachersDetails.nid ? teachersDetails.nid : 'N/A'
                //date
                let birthDateInput = document.querySelector('input[name="birth_date"]');
                if (birthDateInput) birthDateInput.value = teachersDetails.birth_date || '';
                // Gender
                let genderSelect = document.querySelector('select[name="gender"]');
                if (genderSelect) genderSelect.value = teachersDetails.gender || '';

                // Religion
                let religionSelect = document.querySelector('select[name="religion"]');
                if (religionSelect) religionSelect.value = teachersDetails.religion || '';

                // Marital Status
                let maritalSelect = document.querySelector('select[name="marital_status"]');
                if (maritalSelect) maritalSelect.value = teachersDetails.marital_status || '';

                document.querySelector('input[name="nationality"]').value = teachersDetails.nationality ?
                    teachersDetails.nationality : 'N/A'
                // Profile image set if exists
                if (teachersDetails.image) {
                    document.querySelector('#profile_img_preview').src =
                        `/uploads/teacher/profile/${teachersDetails.image}`;
                } else {
                    document.querySelector('#profile_img_preview').src = `/uploads/teacher/profile/default.png`;
                }

                
            }

            if (res.data.status === 'error') {
                console.log('success Error', res.data);
                alert('Unauthorized Access');
                window.location.href = '/teacher/login';
            }
        } catch (error) {
            Swal.fire('Error', 'Authentication failed. Please login again.', 'error').then(() => {
                localStorage.removeItem('token');
                window.location.href = '/teacher/login';
                console.log(error)
            });
        } finally {
            document.getElementById('loader').style.display = 'none';
        }
    }

    //Institutions Details
    getInstitutionDetailsInfo();
    async function getInstitutionDetailsInfo() {
        document.getElementById('loader').style.display = 'block';
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/teacher/login';
            return;
        }

        try {
            let res = await axios.post('/teacher/institution/details', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                //console.log(res.data.data[0].id);
                document.querySelector('.institution_id').value =res.data.data[0].id;
            }

            if (res.data.status === 'error') {
                alert('Unauthorized Access');
                console.log('success Error', res.data);
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
        formData.append('about_me', getValue('textarea[name="about_me"]'));
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
            const res = await axios.post('/teacher/update-profile', formData, {
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

    //teacher eductoin
    async function teacherEducation(event) {
        event.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }

        //get value
        let teacher_id = document.querySelector('input[name="teacher_id"]').value;
        let level = document.querySelector('select[name="level"]').value;
        let roll_number = document.querySelector('input[name="roll_number"]').value;
        let board_university = document.querySelector('input[name="board_university"]').value;
        let result = document.querySelector('input[name="result"]').value;
        let passing_year = parseInt(document.querySelector('input[name="passing_year"]').value);
        let course_duration = document.querySelector('input[name="course_duration"]').value;

        let data = {
            teacher_id: teacher_id,
            level: level,
            roll_number: roll_number,
            board_university: board_university,
            result: result,
            passing_year: passing_year,
            course_duration: course_duration
        }
        //console.log(data);
        try {
            const res = await axios.post('/teacher/education', data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                }
            });

            // Hide loader
            document.getElementById('loader').style.display = 'none';

            if (res.data.status === 'success') {
                Swal.fire('Success', 'Data Inserted successfully', 'success');
                await getTeacherEducationLists(); // Refresh Education Table
                document.getElementById('teacherEducaionl_qualificationForm').reset();



                //getUserInfo(); // Refresh profile info
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
                    //console.log(messages);
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Validation Error',
                    //     html: messages
                    // });
                } else {
                    //console.log(error.response.data);
                    Swal.fire('Error', error.response.data.message || 'Failed to update profile', 'error');
                }
            } else {
                Swal.fire('Error', 'Network or unknown error occurred', 'error');
            }
        }

    }

    //editor educatoin lists
    getTeacherEducationLists();
    async function getTeacherEducationLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }
        try {
            let res = await axios.post('/teacher/education/lists', {}, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            //console.log(res.data.educationLists)
            let educationLists = res.data.educationLists;
            let tbody = document.querySelector('.educationTableBody');
            tbody.innerHTML = ''; // Clear old rows
            if (educationLists.length > 0) {
                educationLists.forEach((education) => {
                    let tr = document.createElement('tr');

                    tr.innerHTML = `
                    <td>${education.level || ''}</td>
                    <td>${education.board_university || ''}</td>
                    <td>${education.roll_number || 'N/A'}</td>
                    <td>${education.result || ''}</td>
                    <td>${education.passing_year || ''}</td>
                    <td>${education.course_duration || 'N/A'}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-info teacherEducationEdit" data-id="${education.id}">EDIT</button>
                        </div>
                    </td>
                `;

                    tbody.appendChild(tr);
                });


                $('.teacherEducationEdit').on('click', async function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    await fillUpdateEducationForm(id);
                    $('#editEducationModal').modal('show');

                    console.log(id);
                })
            } else {
                // No data
                tbody.innerHTML = `<tr><td colspan="4" class="text-center">No education found</td></tr>`;
            }
        } catch (error) {
            console.log(error);
        }
    }


    //teacher Address
    async function TeacherAddress(event) {
        event.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }

        // Get values
        let teacher_id = document.querySelector('input[name="teacher_id"]').value;
        let type = document.querySelector('select[name="type"]').value;
        let village = document.querySelector('input[name="village"]').value;
        let district = document.querySelector('input[name="district"]').value;
        let upazila = document.querySelector('input[name="upazila"]').value;
        let post_office = document.querySelector('input[name="post_office"]').value;
        let postal_code = document.querySelector('input[name="postal_code"]').value;

        let data = {
            teacher_id: teacher_id,
            type: type,
            village: village,
            district: district,
            upazila: upazila,
            post_office: post_office,
            postal_code: postal_code
        };

        try {
            const res = await axios.post('/teacher/address', data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                }
            });

            document.getElementById('loader').style.display = 'none';

            if (res.data.status === 'success') {
                await getTeacherAddressLists();
                Swal.fire('Success', res.data.message || 'Address added successfully', 'success');
                let type = document.querySelector('select[name="type"]').value = "";
                document.querySelector('input[name="village"]').value = "";
                document.querySelector('input[name="district"]').value = "";
                document.querySelector('input[name="upazila"]').value = "";
                document.querySelector('input[name="post_office"]').value = "";
                document.querySelector('input[name="postal_code"]').value = "";

            } else {
                Swal.fire('Error', res.data.message || 'Something went wrong', 'error');
                //console.log(res.data);
            }
        } catch (error) {
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
                    Swal.fire('Error', error.response.data.message || 'Failed to save address', 'error');
                    console.log(error.response.data);
                }
            } else {
                Swal.fire('Error', 'Network or unknown error occurred', 'error');
                console.log(error);
            }
        }
    }


    //Teacher address lists
    getTeacherAddressLists();
    async function getTeacherAddressLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }
        try {
            let res = await axios.post('/teacher/address/lists', {}, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            //console.log(res.data.addressLists)
            let addressLists = res.data.addressLists;
            let tbody = document.querySelector('.TeacherAddressTableBody');
            tbody.innerHTML = ''; // Clear old rows
            if (addressLists.length > 0) {
                addressLists.forEach((address) => {
                    let tr = document.createElement('tr');

                    tr.innerHTML = `
                    <td>${address.type || ''}</td>
                    <td>${address.village || ''}</td>
                    <td>${address.district || 'N/A'}</td>
                    <td>${address.upazila || ''}</td>
                    <td>${address.post_office || ''}</td>
                    <td>${address.postal_code || 'N/A'}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-info TeacherAddressEdit" data-id="${address.id}">EDIT</button>
                            <button type="button" class="btn btn-danger TeacherAddressDelete" data-id="${address.id}">DELETE</button>
                        </div>
                    </td>
                `;

                    tbody.appendChild(tr);
                });

                //teacher address edit 
                $('.TeacherAddressEdit').on('click', async function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    await fillUpdateAddressForm(id);
                    $('#editAddressModal').modal('show');
                    //console.log(id);
                })

                // teacher address delete
                $('.TeacherAddressDelete').on('click', async function() {
                    let token = localStorage.getItem('token');
                    let id = $(this).data('id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This address will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                let res = await axios.post('/teacher/address/delete', {
                                    id: id
                                }, {
                                    headers: {
                                        Authorization: `Bearer ${token}`
                                    }
                                });

                                if (res.data.status === 'success') {
                                    await getTeacherAddressLists();
                                    Swal.fire(
                                        'Deleted!',
                                        res.data.message,
                                        'success'
                                    );

                                    
                                    $(`.address-row-${id}`).remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        res.data.message || 'Something went wrong!',
                                        'error'
                                    );
                                }
                            } catch (error) {
                                console.log(error);
                                Swal.fire(
                                    'Error!',
                                    error.response?.data?.message ||
                                    'Server error occurred',
                                    'error'
                                );
                            }
                        }
                    });
                });



            } else {
                // No data
                tbody.innerHTML = `<tr><td colspan="7" class="text-center">No address found</td></tr>`;
            }
        } catch (error) {
            console.log(error);
        }
    }




        //View Profile
    $('.viewProfileCV').on('click', async function() {
        let token = localStorage.getItem('token');
        // if (!token) {
        //     window.location.href = '/admin/login';
        //     return;
        // }
        let email = $('.profile_email').text().trim();
        //console.log(email);
        if (email) {
            console.log(email);
            await teacherDetailsCVFormat(email);
            $('#teacherDetailsCVFormatModal').modal('show');
        }
    });


        //password change button
    $('.passwordChangeBtn').on('click', async function() {
        let token = localStorage.getItem('token');
        // if (!token) {
        //     window.location.href = '/admin/login';
        //     return;
        // }
        let email = $('.profile_email').text().trim();
        //console.log(email);
        if (email) {
            await teacherFillUpdatePasswordForm(email);
            $('#teacherChangePasswordModal').modal('show');
        }
    });




    
</script>



<!-- <script>
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
                //console.log(res.data.data.editors[0].id);
                // console.log(res.data.data.editors[0]);
                let editorDetails = res.data.data.editors[0]
                document.querySelector('.teacher_id').value = editorDetails.id;
                document.querySelector('.address_teacher_id').value = editorDetails.id;
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


                document.querySelector('input[name="father_name"]').value = editorDetails.father_name ?
                    editorDetails.father_name : 'N/A'
                document.querySelector('input[name="mother_name"]').value = editorDetails.mother_name ?
                    editorDetails.mother_name : 'N/A'
                document.querySelector('input[name="phone"]').value = editorDetails.phone ? editorDetails.phone :
                    'N/A'
                document.querySelector('textarea[name="address"]').value = editorDetails.address ? editorDetails
                    .address : 'N/A'
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
                console.log('success Error', res.data);
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
    $('.passwordChangeBtn').on('click', async function() {
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


    //View Profile
    $('.viewProfileCV').on('click', async function() {
        let token = localStorage.getItem('token');
        // if (!token) {
        //     window.location.href = '/admin/login';
        //     return;
        // }
        let email = $('.profile_email').text().trim();
        //console.log(email);
        if (email) {
            await editorDetailsCVFormat(email);
            $('#editorDetailsCVFormatModal').modal('show');
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

    //edior eductoin
    async function teacherEducation(event) {
        event.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }

        //get value
        let teacher_id = document.querySelector('input[name="teacher_id"]').value;
        let level = document.querySelector('select[name="level"]').value;
        let roll_number = document.querySelector('input[name="roll_number"]').value;
        let board_university = document.querySelector('input[name="board_university"]').value;
        let result = document.querySelector('input[name="result"]').value;
        let passing_year = parseInt(document.querySelector('input[name="passing_year"]').value);
        let course_duration = document.querySelector('input[name="course_duration"]').value;

        let data = {
            teacher_id: teacher_id,
            level: level,
            roll_number: roll_number,
            board_university: board_university,
            result: result,
            passing_year: passing_year,
            course_duration: course_duration
        }
        //console.log(data);
        try {
            const res = await axios.post('/editor/education', data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                }
            });

            // Hide loader
            document.getElementById('loader').style.display = 'none';

            if (res.data.status === 'success') {
                Swal.fire('Success', 'Data Inserted successfully', 'success');
                await getTeacherEducationLists(); // Refresh Education Table
                document.getElementById('teacherEducaionl_qualificationForm').reset();



                //getUserInfo(); // Refresh profile info
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
                    //console.log(messages);
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Validation Error',
                    //     html: messages
                    // });
                } else {
                    //console.log(error.response.data);
                    Swal.fire('Error', error.response.data.message || 'Failed to update profile', 'error');
                }
            } else {
                Swal.fire('Error', 'Network or unknown error occurred', 'error');
            }
        }

    }

    //editor educatoin lists
    getTeacherEducationLists();
    async function getTeacherEducationLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }
        try {
            let res = await axios.post('/editor/education/list', {}, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            //console.log(res.data.educationLists)
            let educationLists = res.data.educationLists;
            let tbody = document.querySelector('.educationTableBody');
            tbody.innerHTML = ''; // Clear old rows
            if (educationLists.length > 0) {
                educationLists.forEach((education) => {
                    let tr = document.createElement('tr');

                    tr.innerHTML = `
                    <td>${education.level || ''}</td>
                    <td>${education.board_university || ''}</td>
                    <td>${education.roll_number || 'N/A'}</td>
                    <td>${education.result || ''}</td>
                    <td>${education.passing_year || ''}</td>
                    <td>${education.course_duration || 'N/A'}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-info teacherEducationEdit" data-id="${education.id}">EDIT</button>
                        </div>
                    </td>
                `;

                    tbody.appendChild(tr);
                });


                $('.teacherEducationEdit').on('click', async function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    await fillUpdateEducationForm(id);
                    $('#editEducationModal').modal('show');

                    console.log(id);
                })
            } else {
                // No data
                tbody.innerHTML = `<tr><td colspan="4" class="text-center">No education found</td></tr>`;
            }
        } catch (error) {
            console.log(error);
        }
    }



    //editor Address
    async function TeacherAddress(event) {
        event.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }

        // Get values
        let teacher_id = document.querySelector('input[name="teacher_id"]').value;
        let type = document.querySelector('select[name="type"]').value;
        let village = document.querySelector('input[name="village"]').value;
        let district = document.querySelector('input[name="district"]').value;
        let upazila = document.querySelector('input[name="upazila"]').value;
        let post_office = document.querySelector('input[name="post_office"]').value;
        let postal_code = document.querySelector('input[name="postal_code"]').value;

        let data = {
            teacher_id: teacher_id,
            type: type,
            village: village,
            district: district,
            upazila: upazila,
            post_office: post_office,
            postal_code: postal_code
        };

        try {
            const res = await axios.post('/editor/address', data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                }
            });

            document.getElementById('loader').style.display = 'none';

            if (res.data.status === 'success') {
                await getTeacherAddressLists();
                Swal.fire('Success', res.data.message || 'Address added successfully', 'success');
                let type = document.querySelector('select[name="type"]').value = "";
                document.querySelector('input[name="village"]').value = "";
                document.querySelector('input[name="district"]').value = "";
                document.querySelector('input[name="upazila"]').value = "";
                document.querySelector('input[name="post_office"]').value = "";
                document.querySelector('input[name="postal_code"]').value = "";

            } else {
                Swal.fire('Error', res.data.message || 'Something went wrong', 'error');
                //console.log(res.data);
            }
        } catch (error) {
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
                    Swal.fire('Error', error.response.data.message || 'Failed to save address', 'error');
                    console.log(error.response.data);
                }
            } else {
                Swal.fire('Error', 'Network or unknown error occurred', 'error');
                console.log(error);
            }
        }
    }

    //editor address lists
    getTeacherAddressLists();
    async function getTeacherAddressLists() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized user');
            return;
        }
        try {
            let res = await axios.post('/editor/address/list', {}, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            //console.log(res.data.addressLists)
            let addressLists = res.data.addressLists;
            let tbody = document.querySelector('.TeacherAddressTableBody');
            tbody.innerHTML = ''; // Clear old rows
            if (addressLists.length > 0) {
                addressLists.forEach((address) => {
                    let tr = document.createElement('tr');

                    tr.innerHTML = `
                    <td>${address.type || ''}</td>
                    <td>${address.village || ''}</td>
                    <td>${address.district || 'N/A'}</td>
                    <td>${address.upazila || ''}</td>
                    <td>${address.post_office || ''}</td>
                    <td>${address.postal_code || 'N/A'}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-info TeacherAddressEdit" data-id="${address.id}">EDIT</button>
                            <button type="button" class="btn btn-danger TeacherAddressDelete" data-id="${address.id}">DELETE</button>
                        </div>
                    </td>
                `;

                    tbody.appendChild(tr);
                });

                //editor address edit 
                $('.TeacherAddressEdit').on('click', async function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    await fillUpdateAddressForm(id);
                    $('#editAddressModal').modal('show');
                    console.log(id);
                })

                // editor address delete
                $('.TeacherAddressDelete').on('click', async function() {
                    let token = localStorage.getItem('token');
                    let id = $(this).data('id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This address will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                let res = await axios.post('/editor/address/delete', {
                                    id: id
                                }, {
                                    headers: {
                                        Authorization: `Bearer ${token}`
                                    }
                                });

                                if (res.data.status === 'success') {
                                    await getTeacherAddressLists();
                                    Swal.fire(
                                        'Deleted!',
                                        res.data.message,
                                        'success'
                                    );

                                    // DOM থেকে ওই row remove করো (optional)
                                    $(`.address-row-${id}`).remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        res.data.message || 'Something went wrong!',
                                        'error'
                                    );
                                }
                            } catch (error) {
                                Swal.fire(
                                    'Error!',
                                    error.response?.data?.message ||
                                    'Server error occurred',
                                    'error'
                                );
                            }
                        }
                    });
                });



            } else {
                // No data
                tbody.innerHTML = `<tr><td colspan="7" class="text-center">No address found</td></tr>`;
            }
        } catch (error) {
            console.log(error);
        }
    }
</script> -->
