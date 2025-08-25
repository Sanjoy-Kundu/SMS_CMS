<!-- Modal -->
<div class="modal fade" id="controlPanelTeacherViewCvFormatModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="controlPanelTeacherViewCvFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teacher Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="controlPanelTeacherCVContent">
                <p>Loading...</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="controlPanelTeacherView">Close</button>
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
                const userData = res.data.user;
                const image = teacherData.image ? teacherData.image : 'default.png';

                let html = `
        <div style="display:flex;align-items:center;gap:20px;margin-bottom:20px;">
            <img src="/uploads/teacher/profile/${image}" alt="Profile" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:2px solid #ddd;">
            <div>
                <h3 style="margin:0;">${userData.name}</h3>
                <p style="margin:0;color:#555;">${userData.email}</p>
                <p style="margin:0;"><strong>Role:</strong> ${userData.role}</p>
            </div>
        </div>

        <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
            <tr><th colspan="2" style="background:#f5f5f5;padding:8px;text-align:left;">Personal Information</th></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Phone</td><td style="padding:6px;border:1px solid #ddd;">${teacherData.phone ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Address</td><td style="padding:6px;border:1px solid #ddd;">${teacherData.address ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Birth Date</td><td style="padding:6px;border:1px solid #ddd;">${teacherData.birth_date ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Gender</td><td style="padding:6px;border:1px solid #ddd;">${teacherData.gender ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Religion</td><td style="padding:6px;border:1px solid #ddd;">${teacherData.religion ?? 'N/A'}</td></tr>
        </table>

        <h4 style="margin-top:20px;">Educational Background</h4>
        <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:8px;border:1px solid #ddd;">Level</th>
                    <th style="padding:8px;border:1px solid #ddd;">Board/University</th>
                    <th style="padding:8px;border:1px solid #ddd;">Passing Year</th>
                    <th style="padding:8px;border:1px solid #ddd;">Result</th>
                </tr>
            </thead>
            <tbody>
                ${teacherData.educations.map(e => `
                    <tr>
                        <td style="padding:6px;border:1px solid #ddd;">${e.level ?? 'N/A'}</td>
                        <td style="padding:6px;border:1px solid #ddd;">${e.board_university ?? 'N/A'}</td>
                        <td style="padding:6px;border:1px solid #ddd;">${e.passing_year ?? 'N/A'}</td>
                        <td style="padding:6px;border:1px solid #ddd;">${e.result ?? 'N/A'}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>

        <h4 style="margin-top:20px;">Addresses</h4>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:8px;border:1px solid #ddd;">Type</th>
                    <th style="padding:8px;border:1px solid #ddd;">Village</th>
                    <th style="padding:8px;border:1px solid #ddd;">Upazila</th>
                    <th style="padding:8px;border:1px solid #ddd;">District</th>
                    <th style="padding:8px;border:1px solid #ddd;">Postal Code</th>
                </tr>
            </thead>
            <tbody>
                ${teacherData.addresses.map(a => `
                    <tr>
                        <td style="padding:6px;border:1px solid #ddd;">${a.type ?? ''}</td>
                        <td style="padding:6px;border:1px solid #ddd;">${a.village ?? ''}</td>
                        <td style="padding:6px;border:1px solid #ddd;">${a.upazila ?? ''}</td>
                        <td style="padding:6px;border:1px solid #ddd;">${a.district ?? ''}</td>
                        <td style="padding:6px;border:1px solid #ddd;">${a.postal_code ?? ''}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
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
