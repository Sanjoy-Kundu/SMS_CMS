<!-- Modal -->
<div class="modal fade" id="editEducationModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="editEducationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editor Educational Qualifications Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="editorEducaionl_qualificationUpdateForm">
                    <input type="hidden" name="id" class="form-control id">

                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-control">
                            <option value="">---Select Level---</option>
                            <option value="SSC">SSC</option>
                            <option value="HSC">HSC</option>
                            <option value="Graduation">Graduation</option>
                            <option value="Masters">Masters</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Roll Number</label>
                        <input type="text" name="roll_number" class="form-control" placeholder="Enter Roll Number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Board/University</label>
                        <input type="text" name="board_university" class="form-control"
                            placeholder="Enter Board/University">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Result</label>
                            <input type="text" name="result" class="form-control" placeholder="GPA/Division">
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

                    <button type="submit" class="btn btn-success" onclick="updateEducationInfo(event)">Update Education</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ============================
    // Fill Modal Form with Existing Data
    // ============================
    async function fillUpdateEducationForm(id) {
        let token = localStorage.getItem('token');
        if (!token) { alert('Unauthorized'); return; }

        const form = document.getElementById('editorEducaionl_qualificationUpdateForm');
        form.querySelector('input[name="id"]').value = id;

        try {
            let res = await axios.post('/editor/education/by-id', { id }, {
                headers: { Authorization: `Bearer ${token}` }
            });

            if (res.data.status === 'success') {
                const data = res.data.data;
                const fields = ['level','roll_number','board_university','result','passing_year','course_duration'];
                fields.forEach(f => {
                    let input = form.querySelector(`[name="${f}"]`);
                    if(input) input.value = data[f] || '';
                });

                // Show modal
                $('#editEducationModal').modal('show');
            } else {
                Swal.fire('Error', res.data.message || 'Education not found', 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Failed to fetch education data', 'error');
        }
    }

    // ============================
    // Update Education
    // ============================
    async function updateEducationInfo(event) {
        event.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) { alert('Unauthorized'); return; }

        const form = document.getElementById('editorEducaionl_qualificationUpdateForm');
        const data = {
            id: form.querySelector('input[name="id"]').value,
            level: form.querySelector('select[name="level"]').value,
            roll_number: form.querySelector('input[name="roll_number"]').value,
            board_university: form.querySelector('input[name="board_university"]').value,
            result: form.querySelector('input[name="result"]').value,
            passing_year: form.querySelector('input[name="passing_year"]').value,
            course_duration: form.querySelector('input[name="course_duration"]').value
        };

        try {
            let res = await axios.post('/editor/education/update', data, {
                headers: { Authorization: `Bearer ${token}` }
            });

            if(res.data.status === 'success'){
                Swal.fire('Success', res.data.message || 'Education updated successfully', 'success');
                $('#editEducationModal').modal('hide');

                // Optional: refresh education table if you have a function
                if(typeof getEdiorEducationLists === 'function'){
                    getEdiorEducationLists();
                }
            } else {
                Swal.fire('Error', res.data.message || 'Failed to update education', 'error');
            }
        } catch (error) {
            console.error(error);
            if(error.response && error.response.status === 422){
                const errors = error.response.data.errors;
                let messages = '';
                for(const key in errors){ messages += errors[key].join(' ') + '<br>'; }
                Swal.fire({icon:'error', title:'Validation Error', html: messages});
            } else {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        }
    }
</script>
