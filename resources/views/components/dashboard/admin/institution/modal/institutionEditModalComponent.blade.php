<!-- Edit Institution Modal -->
<div class="modal fade" id="editInstitutionModal" tabindex="-1" role="dialog" aria-labelledby="editInstitutionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-primary">
                <h5 class="modal-title text-primary font-weight-bold" id="editInstitutionModalLabel">Update Institution
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editInstitutionForm">
                <input type="hidden" name="id" id="edit_institution_id">
                <div class="modal-body">

                    {{-- <div class="form-group">
            <label for="edit_name">Institution ID</label>
            <input type="text" class="form-control" id="edit_institution_id" name="id" placeholder="Enter institution id">
            <span id="edit_institution_name_error" class="text-danger small"></span>
          </div> --}}
                    <div class="form-group">
                        <label for="edit_name">Institution Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name"
                            placeholder="Enter institution name">
                        <span id="edit_institution_name_error" class="text-danger small"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit_type">Institution Type</label>
                        <select class="form-control" id="edit_type" name="type">
                            <option value="" disabled selected>--CHOOSE ONE --</option>
                            <option value="school">School</option>
                            <option value="college">College</option>
                            <option value="combined">Combined</option>
                        </select>
                        <span id="edit_institution_type_error" class="text-danger small"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit_eiin">EIIN</label>
                        <input type="text" class="form-control" id="edit_eiin" name="eiin"
                            placeholder="Enter EIIN (optional)">
                        <span id="edit_institution_eiin_error" class="text-danger small"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="2" placeholder="Enter address (optional)"></textarea>
                        <span id="edit_institution_address_error" class="text-danger small"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" onclick="updateInstitution(event)">Update
                        Institution</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to populate form with institution data
    async function fillUpInstitutionForm(id) {
        let token = localStorage.getItem('token');
        if (!token || !id) {
            alert('Unauthorized Access. Token Not found');
            return;
        }
        document.getElementById('edit_institution_id').value = id;
        try {
            let res = await axios.post('/institution/edit-by-id', {
                id: id
            }, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                const institution = res.data.institution;
                console.log(institution);

                document.getElementById('edit_name').value = institution.name;
                document.getElementById('edit_type').value = institution.type;
                document.getElementById('edit_eiin').value = institution.eiin || '';
                document.getElementById('edit_address').value = institution.address || '';

                // Clear any previous errors
                document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
            } else {
                alert(res.data.message || 'Failed to fetch institution data');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching institution data');
        }
    }



    //update Institution
    async function updateInstitution(event) {
        event.preventDefault();
        const token = localStorage.getItem('token');
        const id = document.getElementById('edit_institution_id').value;
        if (!token || !id) {
            alert('Unauthorized access');
            return;
        }
        const name = document.getElementById('edit_name').value;
        const type = document.getElementById('edit_type').value;
        const eiin = document.getElementById('edit_eiin').value;
        const address = document.getElementById('edit_address').value;
        let data = {
            id: id,
            name: name,
            type: type,
            eiin: eiin,
            address: address,
        }

        try {
            const res = await axios.post('/institution/update', data, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            if (res.data.status === 'success') {
                //alert(res.data.message);
                await getInstitutions();
                $('#editInstitutionModal').modal('hide');
                // Reload institution list or update UI as needed
                //location.reload(); // Or a more elegant solution
            } else {
                // Display validation errors if any
                if (res.data.errors) {
                    Object.entries(res.data.errors).forEach(([field, messages]) => {
                        const errorElement = document.getElementById(`edit_institution_${field}_error`);
                        if (errorElement) errorElement.textContent = messages[0];
                    });
                } else {
                    alert(res.data.message || 'Failed to update institution');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating institution');
        }
    }
</script>
