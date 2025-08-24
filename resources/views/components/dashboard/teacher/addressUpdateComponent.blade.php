<!-- Modal -->
<div class="modal fade" id="editAddressModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editor Address Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="teacher_address_update_Form">
                    <!-- Editor ID -->
                    <input type="number" name="id" class="form-control id" readonly hidden>

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
                        <input type="text" name="village" class="form-control" placeholder="Village" required>
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
                    <button type="submit" class="btn btn-success" onclick="updateEditorAddress(event)">Save Address</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="addressModalClose">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ============================
    // Fill Modal Form with Existing Address
    // ============================
    async function fillUpdateAddressForm(id) {
        let token = localStorage.getItem('token');
        if(!token) { alert('Unauthorized'); return; }

        try {
            let res = await axios.post('/teacher/address/by-id', { id }, {
                headers: { Authorization: `Bearer ${token}` }
            });

            if(res.data.status === 'success'){
                const data = res.data.data;
                //console.log(data);

                const form = document.getElementById('teacher_address_update_Form');
                form.querySelector('input[name="id"]').value = id;
                form.querySelector('select[name="type"]').value = data.type || '';
                form.querySelector('input[name="village"]').value = data.village || '';
                form.querySelector('input[name="district"]').value = data.district || '';
                form.querySelector('input[name="upazila"]').value = data.upazila || '';
                form.querySelector('input[name="post_office"]').value = data.post_office || '';
                form.querySelector('input[name="postal_code"]').value = data.postal_code || '';

                $('#editAddressModal').modal('show');
            } else {
                Swal.fire('Error', res.data.message || 'Address not found', 'error');
            }
        } catch(error){
            console.error(error);
            Swal.fire('Error', 'Failed to fetch address data', 'error');
        }
    }

    // ============================
    // Update Address
    // ============================
    async function updateEditorAddress(event){
        event.preventDefault();

        let token = localStorage.getItem('token');
        if(!token) { alert('Unauthorized'); return; }

        const form = document.getElementById('teacher_address_update_Form');
        const formData = new FormData(form);

        try{
            let res = await axios.post('/teacher/address/update', formData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'multipart/form-data'
                }
            });

            if(res.data.status === 'success'){
                await getTeacherAddressLists();
                Swal.fire('Success', res.data.message || 'Address updated successfully', 'success');
                $('#editAddressModal').modal('hide');
               
               
            } else {
                Swal.fire('Error', res.data.message || 'Failed to update address', 'error');
            }

        } catch(error){
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
