<!-- Modal -->
<div class="modal fade" id="adminDBEditorDetailsModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="adminDBEditorDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editor Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="adminEditorCVContent">
                <p>Loading...</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="addressModalClose">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
async function adminEditorDetailsFormat(email){
    let token = localStorage.getItem('token');
    if(!token){
        alert('Unauthorized access');
        return;
    }

    $('#adminDBEditorDetailsModal').modal('show');
    document.getElementById('adminEditorCVContent').innerHTML = '<p>Loading...</p>';

    try {
        let res = await axios.post('/editor/cv-details', 
            { email: email }, 
            { headers: { 'Authorization': 'Bearer ' + token } }
        );

        // if(res.data.status === 'success'){
        //     const editorData = res.data.editor;
        //     //console.log(editorData.image);
        //     const userData = res.data.user;
        //     const image = editorData.image ? editorData.image : 'https://via.placeholder.com/150';

        //     let html = `
        //         <h4>${userData.name} (${userData.email})</h4>
        //         <p><strong>Role:</strong> ${userData.role}</p>
        //         <p><strong>Designation:</strong> ${editorData.designation ?? 'N/A'}</p>
        //         <p><strong>Phone:</strong> ${editorData.phone ?? 'N/A'}</p>
        //         <p><strong>Address:</strong> ${editorData.address ?? 'N/A'}</p>
        //         <p><strong>Birth Date:</strong> ${editorData.birth_date ?? 'N/A'}</p>
        //         <p><strong>Gender:</strong> ${editorData.gender ?? 'N/A'}</p>
        //         <p><strong>Religion:</strong> ${editorData.religion ?? 'N/A'}</p>
        //         <hr>
        //         <h5>Educations:</h5>
        //         <ul>
        //             ${editorData.educations.map(e => `
        //                 <li>${e.level ?? 'N/A'} - ${e.board_university ?? 'N/A'} (${e.passing_year ?? 'N/A'}) - Result: ${e.result ?? 'N/A'}</li>
        //             `).join('')}
        //         </ul>
        //         <hr>
        //         <h5>Addresses:</h5>
        //         <ul>
        //             ${editorData.addresses.map(a => `
        //                 <li>${a.type ?? ''} Address: ${a.village ?? ''}, ${a.upazila ?? ''}, ${a.district ?? ''} - ${a.postal_code ?? ''}</li>
        //             `).join('')}
        //         </ul>
        //     `;

        //     document.getElementById('adminEditorCVContent').innerHTML = html;

        // } else {
        //     document.getElementById('adminEditorCVContent').innerHTML = `<p class="text-danger">${res.data.error ?? 'Something went wrong!'}</p>`;
        // }
        if(res.data.status === 'success'){
    const editorData = res.data.editor;
    const userData = res.data.user;
    const image = editorData.image ? editorData.image : 'https://via.placeholder.com/150';

    let html = `
        <div style="display:flex;align-items:center;gap:20px;margin-bottom:20px;">
            <img src="/uploads/editor/profile/${image}" alt="Profile" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:2px solid #ddd;">
            <div>
                <h3 style="margin:0;">${userData.name}</h3>
                <p style="margin:0;color:#555;">${userData.email}</p>
                <p style="margin:0;"><strong>Role:</strong> ${userData.role}</p>
            </div>
        </div>

        <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
            <tr><th colspan="2" style="background:#f5f5f5;padding:8px;text-align:left;">Personal Information</th></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Phone</td><td style="padding:6px;border:1px solid #ddd;">${editorData.phone ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Address</td><td style="padding:6px;border:1px solid #ddd;">${editorData.address ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Birth Date</td><td style="padding:6px;border:1px solid #ddd;">${editorData.birth_date ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Gender</td><td style="padding:6px;border:1px solid #ddd;">${editorData.gender ?? 'N/A'}</td></tr>
            <tr><td style="padding:6px;border:1px solid #ddd;">Religion</td><td style="padding:6px;border:1px solid #ddd;">${editorData.religion ?? 'N/A'}</td></tr>
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
                ${editorData.educations.map(e => `
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
                ${editorData.addresses.map(a => `
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

    document.getElementById('adminEditorCVContent').innerHTML = html;

} else {
    document.getElementById('adminEditorCVContent').innerHTML = `<p class="text-danger">${res.data.error ?? 'Something went wrong!'}</p>`;
}


    } catch (error) {
        console.error(error);
        document.getElementById('adminEditorCVContent').innerHTML = '<p class="text-danger">Editor not found or unauthorized!</p>';
    }
}

</script>
