<!-- Modal -->
<div class="modal fade" id="editorDetailsCVFormatModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="editorDetailsCVFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editor Details Like CV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="editorCVContent">
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
async function editorDetailsCVFormat(email){
    let token = localStorage.getItem('token');
    if(!token){
        alert('Unauthorized access');
        return;
    }

    $('#editorDetailsCVFormatModal').modal('show');
    document.getElementById('editorCVContent').innerHTML = '<p>Loading...</p>';

    try {
        let res = await axios.post('/editor/cv-details', 
            { email: email }, 
            { headers: { 'Authorization': 'Bearer ' + token } }
        );

        if(res.data.status === 'success'){
            const editorData = res.data.editor;
            const userData = res.data.user;

            let html = `
                <h4>${userData.name} (${userData.email})</h4>
                <p><strong>Role:</strong> ${userData.role}</p>
                <p><strong>Designation:</strong> ${editorData.designation ?? 'N/A'}</p>
                <p><strong>Phone:</strong> ${editorData.phone ?? 'N/A'}</p>
                <p><strong>Address:</strong> ${editorData.address ?? 'N/A'}</p>
                <p><strong>Birth Date:</strong> ${editorData.birth_date ?? 'N/A'}</p>
                <p><strong>Gender:</strong> ${editorData.gender ?? 'N/A'}</p>
                <p><strong>Religion:</strong> ${editorData.religion ?? 'N/A'}</p>
                <hr>
                <h5>Educations:</h5>
                <ul>
                    ${editorData.educations.map(e => `
                        <li>${e.level ?? 'N/A'} - ${e.board_university ?? 'N/A'} (${e.passing_year ?? 'N/A'}) - Result: ${e.result ?? 'N/A'}</li>
                    `).join('')}
                </ul>
                <hr>
                <h5>Addresses:</h5>
                <ul>
                    ${editorData.addresses.map(a => `
                        <li>${a.type ?? ''} Address: ${a.village ?? ''}, ${a.upazila ?? ''}, ${a.district ?? ''} - ${a.postal_code ?? ''}</li>
                    `).join('')}
                </ul>
            `;

            document.getElementById('editorCVContent').innerHTML = html;

        } else {
            document.getElementById('editorCVContent').innerHTML = `<p class="text-danger">${res.data.error ?? 'Something went wrong!'}</p>`;
        }

    } catch (error) {
        console.error(error);
        document.getElementById('editorCVContent').innerHTML = '<p class="text-danger">Editor not found or unauthorized!</p>';
    }
}

</script>
