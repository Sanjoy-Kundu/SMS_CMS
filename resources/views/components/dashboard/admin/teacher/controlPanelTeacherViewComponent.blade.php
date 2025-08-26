<!-- Modal -->
<!-- Teacher CV Modal -->
<div class="modal fade" id="controlPanelTeacherViewCvFormatModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="controlPanelTeacherViewCvFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0 rounded-lg">
            
            <!-- Header -->
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title font-weight-bold" id="controlPanelTeacherViewCvFormatModalLabel">
                    Teacher Information
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body" id="controlPanelTeacherCVContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-3 text-muted">Loading teacher information...</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Export as PDF</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    async function controlPanelTeacherDetailsCVFormat(email) {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized access');
            return;
        }

        $('#controlPanelTeacherViewCvFormatModal').modal('show');
        document.getElementById('controlPanelTeacherCVContent').innerHTML = '<p>Loading...</p>';

        try {
            let res = await axios.post('/admin/teacher/control/panel/cv-details', {
                email: email
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (res.data.status === 'success') {
                //console.log(res.data.teacher)
                //console.log(res.data.user)
                const teacherData = res.data.teacher;
                console.log(teacherData);
                const userData = res.data.user;
                const image = teacherData.image ? teacherData.image : 'default.png';

                let html = `
                    <!-- Profile Header -->
                    <div class="d-flex align-items-center mb-4">
                        <img src="/uploads/teacher/profile/${image}" 
                            class="rounded-circle border shadow-sm mr-3" 
                            style="width:120px; height:120px; object-fit:cover;">
                        <div>
                            <h4 class="mb-1">${userData.name}</h4>
                            <p class="mb-0 text-muted">${userData.email}</p>
                            <span class="badge badge-success text-uppercase">${userData.role}</span>
                        </div>
                    </div>

                    <!-- About Myself -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 font-weight-bold text-dark">About Myself</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">${teacherData.about_me ?? 'N/A'}</p>
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 font-weight-bold text-dark">Personal Information</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm mb-0">
                                <tbody>
                                    <tr><th style="width:180px;">Father Name: </th><td>${teacherData.father_name ?? 'N/A'}</td></tr>
                                    <tr><th style="width:180px;">Phone: </th><td>${teacherData.phone ?? 'N/A'}</td></tr>
                                    <tr><th>Address: </th><td>${teacherData.address ?? 'N/A'}</td></tr>
                                    <tr><th>Birth Date: </th><td>${teacherData.birth_date ?? 'N/A'}</td></tr>
                                    <tr><th>Gender: </th><td>${teacherData.gender ?? 'N/A'}</td></tr>
                                    <tr><th>Religion: </th><td>${teacherData.religion ?? 'N/A'}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 font-weight-bold text-dark">Educational Background</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Level</th>
                                        <th>Board/University</th>
                                        <th>Passing Year</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${teacherData.educations.map(e => `
                                        <tr>
                                            <td>${e.level ?? 'N/A'}</td>
                                            <td>${e.board_university ?? 'N/A'}</td>
                                            <td>${e.passing_year ?? 'N/A'}</td>
                                            <td>${e.result ?? 'N/A'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 font-weight-bold text-dark">Addresses</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Village</th>
                                        <th>Upazila</th>
                                        <th>District</th>
                                        <th>Postal Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${teacherData.addresses.map(a => `
                                        <tr>
                                            <td>${a.type ?? ''}</td>
                                            <td>${a.village ?? ''}</td>
                                            <td>${a.upazila ?? ''}</td>
                                            <td>${a.district ?? ''}</td>
                                            <td>${a.postal_code ?? ''}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;



                document.getElementById('controlPanelTeacherCVContent').innerHTML = html;

            } else {
                document.getElementById('controlPanelTeacherCVContent').innerHTML =
                    `<p class="text-danger">${res.data.error ?? 'Something went wrong!'}</p>`;
            }


        } catch (error) {
            console.error(error);
            document.getElementById('controlPanelTeacherCVContent').innerHTML =
                '<p class="text-danger">teacher not found or unauthorized!</p>';
        }
    }
</script>
