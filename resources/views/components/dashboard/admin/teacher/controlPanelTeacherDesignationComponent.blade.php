<!-- Teacher Designation Modal -->
<div class="modal fade" id="controlPanelTeacherDesignationModal" tabindex="-1" role="dialog"
    aria-labelledby="controlPanelTeacherDesignationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="controlPanelTeacherDesignationModalLabel">
                    Set Teacher Designation
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="teacherDesignationForm">

                    <!-- Teacher Info -->
                    <div class="border rounded p-3 mb-3 bg-light">
                        <h6 class="mb-1" hidden><strong>Id:</strong> <span id="teacher_id">0</span></h6>
                        <h6 class="mb-1"><strong>Name:</strong> <span id="teacher_name">Mr. Example Teacher</span></h6>
                        <p class="mb-0"><strong>Email:</strong> <span id="teacher_email">example@email.com</span></p>
                    </div>

                    <!-- Hidden field for designation id -->
                    {{-- <input type="hidden" id="designation_id" name="designation_id"> --}}

                    <!-- Designation Dropdown -->
                    <div class="form-group">
                        <label for="designation">Select Designation</label>
                        <select class="form-control" id="designation" name="designation" required>
                            <option value="">-- Choose Designation --</option>
                            <!-- Dynamic options will be loaded here -->
                        </select>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit"  class="btn btn-success" onclick="updateDesignation(event)">Save</button>
            </div>

        </div>
    </div>
</div>



<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Load Designations dynamically into dropdown
    loadDesignationsDropdown();
    async function loadDesignationsDropdown() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Authorization failed');
            return;
        }

        try {
            let res = await axios.post('/admin/designation/list', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                const designations = res.data.data;

                // Clear old options
                let select = document.getElementById("designation");
                select.innerHTML = '<option value="">-- Choose Designation --</option>';

                // Append dynamic options
                designations.forEach(d => {
                    let option = document.createElement("option");
                    option.value = d.id;  
                    option.textContent = d.title; 
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire("Error!", "Failed to load designations", "error");
        }
    }







    function setTeacherDesignation(teacherId, teacherName, teacherEmail,designation_id) {
        document.getElementById("teacher_id").textContent = teacherId;
        document.getElementById("teacher_name").textContent = teacherName;
        document.getElementById("teacher_email").textContent = teacherEmail;
       // loadDesignationsDropdown(null)
           // set selected designation in dropdown
        if (designation_id) {
            document.querySelector("#designation").value = designation_id;
        } else {
            document.querySelector("#designation").value = "";
        }
    }

    // Update Designation
    async function updateDesignation(event) {
        event.preventDefault();

        let token = localStorage.getItem("token");
        if (!token) {
            alert('Unauthorized Access');
            return;
        }

        let id = document.querySelector('#teacher_id').textContent;
        let designation_id = document.querySelector('#designation').value;

        if (!designation_id) {
            Swal.fire("Warning!", "Please select a designation", "warning");
            return;
        }

        let data = { id: id, designation_id: designation_id };
        console.log(data);

        try {
            let res = await axios.post('/update/teacher/designation', data, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                let updatedDesignationId = res.data.data.designation_id;
                document.querySelector('#designation').value = updatedDesignationId;
                //console.log(res.data.data.designation_id);
                Swal.fire("Success!", res.data.message, "success");
                await controlPanelAllTeacherLists();
                

                // 
                $('#controlPanelTeacherDesignationModal').modal('hide');

            } else {
                Swal.fire("Error!", res.data.message || "Failed to update designation", "error");
            }
        } catch (error) {
            console.error(error);
            Swal.fire("Error!", "Something went wrong", "error");
        }
    }

</script>