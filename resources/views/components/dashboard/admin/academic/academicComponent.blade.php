<div class="container-fluid">
    <div class="row">
        <!-- Left Column: Academic Section Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-primary font-weight-bold">Add Academic Section</h5>
                </div>
                <div class="card-body">
                    <form id="academicSectionForm">
                        <div class="form-group">
                            <label for="institution_id">Select Institution</label>
                            <select class="form-control" id="institution_id" name="institution_id" required>
                                <option value="" disabled selected>-- Select Institution --</option>
                                <!-- এখান ডাইনামিক ভাবে ইনস্টিটিউশন অপশনস আসবে -->
                            </select>
                            <span id="institution_id_error" class="text-danger small">--</span>
                        </div>
                        <div class="form-group">
                            <label for="section_type">Section Type</label>
                            <select class="form-control" id="section_type" name="section_type" required>
                                <option value="" disabled selected>-- Select Section Type --</option>
                                <option value="school">School</option>
                                <option value="college">College</option>
                            </select>
                            <span id="section_type_error" class="text-danger small">--</span>
                        </div>
                        <div class="form-group">
                            <label for="approval_letter_no">Approval Letter No (optional)</label>
                            <input type="text" class="form-control" id="approval_letter_no" name="approval_letter_no"
                                placeholder="Enter approval letter no">
                        </div>
                        <div class="form-group">
                            <label for="approval_date">Approval Date (optional)</label>
                            <input type="date" class="form-control" id="approval_date" name="approval_date">
                        </div>
                        <div class="form-group">
                            <label for="approval_stage">Approval Stage (optional)</label>
                            <input type="text" class="form-control" id="approval_stage" name="approval_stage"
                                placeholder="Enter approval stage">
                        </div>
                        <div class="form-group">
                            <label for="level">Level (optional)</label>
                            <input type="text" class="form-control" id="level" name="level"
                                placeholder="e.g. নিম্ন মাধ্যমিক, মাধ্যমিক, একাদশ">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add Academic Section</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Right Column: Academic Sections Table -->
        <div class="col-xl-7 col-md-6 mb-4">
            <div class="card border-left-success shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-success font-weight-bold">Academic Sections List</h5>
                    <div class="spinner-border spinner-border-sm text-success d-none" id="sectionsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="academic-sections-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Institution</th>
                                    <th>Section Type</th>
                                    <th>Approval Letter No</th>
                                    <th>Approval Date</th>
                                    <th>Approval Stage</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ডাইনামিক ডাটা আসবে এখানে -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Trashed Academic Sections Card -->
            <div class="card border-left-warning shadow mt-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-warning font-weight-bold">Trashed Academic Sections</h5>
                    <div class="spinner-border spinner-border-sm text-warning d-none" id="trashedSectionsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="trashed-academic-sections-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Institution</th>
                                    <th>Section Type</th>
                                    <th>Deleted At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ডাইনামিক ডাটা আসবে এখানে -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Academic Section Modal -->
<div class="modal fade" id="editAcademicSectionModal" tabindex="-1" role="dialog"
    aria-labelledby="editAcademicSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-primary">
                <h5 class="modal-title text-primary font-weight-bold" id="editAcademicSectionModalLabel">Edit Academic
                    Section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAcademicSectionForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_institution_id">Select Institution</label>
                        <select class="form-control" id="edit_institution_id" name="institution_id" required>
                            <option value="" disabled selected>-- Select Institution --</option>
                        </select>
                        <span id="edit_institution_id_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_section_type">Section Type</label>
                        <select class="form-control" id="edit_section_type" name="section_type" required>
                            <option value="" disabled selected>-- Select Section Type --</option>
                            <option value="school">School</option>
                            <option value="college">College</option>
                        </select>
                        <span id="edit_section_type_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_approval_letter_no">Approval Letter No (optional)</label>
                        <input type="text" class="form-control" id="edit_approval_letter_no"
                            name="approval_letter_no" placeholder="Enter approval letter no">
                        <span id="edit_approval_letter_no_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_approval_date">Approval Date (optional)</label>
                        <input type="date" class="form-control" id="edit_approval_date" name="approval_date">
                        <span id="edit_approval_date_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_approval_stage">Approval Stage (optional)</label>
                        <input type="text" class="form-control" id="edit_approval_stage" name="approval_stage"
                            placeholder="Enter approval stage">
                        <span id="edit_approval_stage_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_level">Level (optional)</label>
                        <input type="text" class="form-control" id="edit_level" name="level"
                            placeholder="e.g. নিম্ন মাধ্যমিক, মাধ্যমিক, একাদশ">
                        <span id="edit_level_error" class="text-danger small"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Academic Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        getAcademics();
        getAcademicSections();
        getTrashedAcademicSections();

        // Academic Section Form Submit
        $('#academicSectionForm').on('submit', async function(e) {
            e.preventDefault();
            await createAcademicSection();
        });

        // Edit Academic Section Form Submit
        $('#editAcademicSectionForm').on('submit', async function(e) {
            e.preventDefault();
            await updateAcademicSection();
        });

        // Reset modal when it's closed
        $('#editAcademicSectionModal').on('hidden.bs.modal', function() {
            $('#editAcademicSectionForm')[0].reset();
            $('.text-danger').text('');
        });
    });

    // Format date for display
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('bn-BD');
    }

    // Get Institutions for dropdown
    async function getAcademics() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/institution/lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                let institutionLists = response.data.data;
                populateInstitutionDropdowns(institutionLists);
            }
        } catch (error) {
            console.error('Error fetching institutions:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'প্রতিষ্ঠানের তালিকা আনতে সমস্যা হয়েছে'
            });
        }
    }

    // Populate institution dropdowns
    function populateInstitutionDropdowns(institutionLists) {

        let options = '<option value="" disabled selected>-- প্রতিষ্ঠান নির্বাচন করুন --</option>';

        if (institutionLists && institutionLists.length > 0) {
            institutionLists.forEach(inst => {
                //console.log(inst.institution.name)
                options += `<option value="${inst.id}">${inst.name?inst.name:'N/A'}</option>`;
            });
        } else {
            options += '<option value="" disabled>কোনো প্রতিষ্ঠান পাওয়া যায়নি</option>';
        }

        $('#institution_id').html(options);
        $('#edit_institution_id').html(options);
    }

    // Get Academic Sections
    async function getAcademicSections() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        // Show loader
        $('#sectionsLoader').removeClass('d-none');

        try {
            const response = await axios.post('/academic/section/lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                populateAcademicSectionsTable(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching academic sections:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'একাডেমিক সেকশনের তালিকা আনতে সমস্যা হয়েছে'
            });
        } finally {
            // Hide loader
            $('#sectionsLoader').addClass('d-none');
        }
    }

    // Populate Academic Sections Table
    function populateAcademicSectionsTable(sections) {
        let tbody = '';

        if (!sections || sections.length === 0) {
            tbody = `<tr><td colspan="8" class="text-center">কোনো একাডেমিক সেকশন পাওয়া যায়নি</td></tr>`;
        } else {
            sections.forEach((section, index) => {
                // Use institution name from relationship
                const institutionName = section.institution ? section.institution.name : 'N/A';

                tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${institutionName}</td>
                        <td>${section.section_type ? section.section_type.charAt(0).toUpperCase() + section.section_type.slice(1) : 'N/A'}</td>
                        <td>${section.approval_letter_no || 'N/A'}</td>
                        <td>${section.approval_date}</td>
                        <td>${section.approval_stage || 'N/A'}</td>
                        <td>${section.level || 'N/A'}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary edit-section-btn" data-id="${section.id}">EDIT</button>
                                <button type="button" class="btn btn-sm btn-danger trash-section-btn" data-id="${section.id}">TRASH</button>
                            </div>
                        </td>
                    </tr>`;
            });
        }

        $('#academic-sections-table tbody').html(tbody);
    }

    // Create Academic Section
    async function createAcademicSection() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        // Reset errors
        $('.text-danger').text('');

        // Get form data
        const formData = {
            institution_id: $('#institution_id').val(),
            section_type: $('#section_type').val(),
            approval_letter_no: $('#approval_letter_no').val(),
            approval_date: $('#approval_date').val(),
            approval_stage: $('#approval_stage').val(),
            level: $('#level').val()
        };

        // Validation
        if (!formData.institution_id) {
            $('#institution_id_error').text('প্রতিষ্ঠান নির্বাচন করুন');
            return;
        }

        if (!formData.section_type) {
            $('#section_type_error').text('সেকশন টাইপ নির্বাচন করুন');
            return;
        }
        //console.log(formData);
        try {
            const response = await axios.post('/academic/section/create', formData, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'সফল!',
                    text: response.data.message || 'একাডেমিক সেকশন সফলভাবে যোগ করা হয়েছে'
                });

                // Reset form
                $('#academicSectionForm')[0].reset();

                // Refresh table
                await getAcademicSections();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ব্যর্থ!',
                    text: response.data.message || 'একাডেমিক সেকশন যোগ করতে ব্যর্থ হয়েছে'
                });
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.institution_id) $('#institution_id_error').text(errors.institution_id[0]);
                if (errors.section_type) $('#section_type_error').text(errors.section_type[0]);
                if (errors.approval_letter_no) $('#approval_letter_no_error').text(errors.approval_letter_no[0]);
                if (errors.approval_date) $('#approval_date_error').text(errors.approval_date[0]);
                if (errors.approval_stage) $('#approval_stage_error').text(errors.approval_stage[0]);
                if (errors.level) $('#level_error').text(errors.level[0]);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'Something is Wrong'
                });
            }
        }
    }

    // Edit Academic Section
    $(document).on('click', '.edit-section-btn', async function() {
        const sectionId = $(this).data('id');
        await getAcademicSectionForEdit(sectionId);
    });

    // Get Academic Section for Edit
    async function getAcademicSectionForEdit(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/academic/section/edit-by-id', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                const section = response.data.section;

                // Populate form
                $('#edit_institution_id').val(section.institution_id);
                $('#edit_section_type').val(section.section_type);
                $('#edit_approval_letter_no').val(section.approval_letter_no || '');

                // Format date for input field (YYYY-MM-DD format required by date input)
                if (section.approval_date) {
                    const date = new Date(section.approval_date);
                    const formattedDate = date.toISOString().split('T')[0];
                    $('#edit_approval_date').val(formattedDate);
                } else {
                    $('#edit_approval_date').val('');
                }

                $('#edit_approval_stage').val(section.approval_stage || '');
                $('#edit_level').val(section.level || '');

                // Store ID for update
                $('#editAcademicSectionForm').data('id', section.id);

                // Clear errors
                $('.text-danger').text('');

                // Open modal after populating data
                $('#editAcademicSectionModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ব্যর্থ!',
                    text: response.data.message || 'একাডেমিক সেকশনের তথ্য আনতে ব্যর্থ হয়েছে'
                });
            }
        } catch (error) {
            console.error('Error fetching academic section for edit:', error);
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something is Wrong'
            });
        }
    }

    // Update Academic Section
    async function updateAcademicSection() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Reset errors
        $('.text-danger').text('');
        // Get form data
        const formData = {
            id: $('#editAcademicSectionForm').data('id'),
            institution_id: $('#edit_institution_id').val(),
            section_type: $('#edit_section_type').val(),
            approval_letter_no: $('#edit_approval_letter_no').val(),
            approval_date: $('#edit_approval_date').val(),
            approval_stage: $('#edit_approval_stage').val(),
            level: $('#edit_level').val()
        };
        // Validation
        if (!formData.institution_id) {
            $('#edit_institution_id_error').text('Select Institution');
            return;
        }
        if (!formData.section_type) {
            $('#edit_section_type_error').text('Select Section Type');
            return;
        }
        try {
            const response = await axios.post('/academic/section/update', formData, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'SUCCESS!',
                    text: response.data.message
                });
                // Close modal
                $('#editAcademicSectionModal').modal('hide');
                // Refresh table
                await getAcademicSections();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ব্যর্থ!',
                    text: response.data.message || 'Fail To Updte Accademic Section'
                });
                console.log(response.data);
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.institution_id) $('#edit_institution_id_error').text(errors.institution_id[0]);
                if (errors.section_type) $('#edit_section_type_error').text(errors.section_type[0]);
                if (errors.approval_letter_no) $('#edit_approval_letter_no_error').text(errors.approval_letter_no[
                    0]);
                if (errors.approval_date) $('#edit_approval_date_error').text(errors.approval_date[0]);
                if (errors.approval_stage) $('#edit_approval_stage_error').text(errors.approval_stage[0]);
                if (errors.level) $('#edit_level_error').text(errors.level[0]);
            } else {
                console.error('Error updating academic section:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'Something is Wrong'
                });
            }
        }
    }


    // Trash Academic Section
    $(document).on('click', '.trash-section-btn', async function() {
        const sectionId = $(this).data('id');

        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Are You Sure that You want to get data trash?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, ট্র্যাশে পাঠান!',
            cancelButtonText: 'বাতিল করুন'
        });

        if (result.isConfirmed) {
            await trashAcademicSection(sectionId);
        }
    });

    // Trash Academic Section Function
    async function trashAcademicSection(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/academic/section/trash', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Trash Succesfully',
                    text: response.data.message
                });

                // Refresh table
                await getAcademicSections();
                await getTrashedAcademicSections();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ব্যর্থ!',
                    text: response.data.message
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something is Wrong'
            });
        }
    }




    /* Trash lists start */
    // Get Trashed Academic Sections
    async function getTrashedAcademicSections() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        // Show loader
        $('#trashedSectionsLoader').removeClass('d-none');

        try {
            const response = await axios.post('/academic/section/trashed-lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                populateTrashedSectionsTable(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching trashed academic sections:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error in Trash Lists'
            });
        } finally {
            // Hide loader
            $('#trashedSectionsLoader').addClass('d-none');
        }
    }

    // Populate Trashed Sections Table
    function populateTrashedSectionsTable(sections) {
        let tbody = '';
        if (!sections || sections.length === 0) {
            tbody = `<tr><td colspan="9" class="text-center">Data Not Found</td></tr>`;
        } else {
            sections.forEach((section, index) => {
                const institutionName = section.institution ? section.institution.name : 'N/A';
                tbody += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${institutionName}</td>
                    <td>${section.section_type ? section.section_type.charAt(0).toUpperCase() + section.section_type.slice(1) : 'N/A'}</td>
                    <td>${section.deleted_at}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-success restore-section-btn" data-id="${section.id}">RESTORE</button>
                            <button type="button" class="btn btn-sm btn-danger delete-section-btn" data-id="${section.id}">PERMANENT DELETE</button>
                        </div>
                    </td>
                </tr>`;
            });
        }
        $('#trashed-academic-sections-table tbody').html(tbody);
    }

    // Restore Academic Section
    $(document).on('click', '.restore-section-btn', async function() {
        const sectionId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Do you want to restore this section?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YES, RESTORE',
            cancelButtonText: 'CANCEL'
        });

        if (result.isConfirmed) {
            await restoreAcademicSection(sectionId);
        }
    });

    // Restore Academic Section Function
    async function restoreAcademicSection(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/academic/section/restore', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Restored',
                    text: response.data.message || 'একাডেমিক সেকশন সফলভাবে পুনরুদ্ধার করা হয়েছে'
                });

                // Refresh both tables
                await getAcademicSections();
                await getTrashedAcademicSections();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ব্যর্থ!',
                    text: response.data.message || 'একাডেমিক সেকশন পুনরুদ্ধার করতে ব্যর্থ হয়েছে'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Something is Wrong'
            });
        }
    }

    // Permanently Delete Academic Section
    $(document).on('click', '.delete-section-btn', async function() {
        const sectionId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Are you sure you want to permanently delete this section? This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#28a745',
            confirmButtonText: 'YES, DELETE IT!',
            cancelButtonText: 'CANCEL'
        });

        if (result.isConfirmed) {
            await deleteAcademicSection(sectionId);
        }
    });

    // Delete Academic Section Function
    async function deleteAcademicSection(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/academic/section/delete', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'মুছে ফেলা হয়েছে!',
                    text: response.data.message || 'একাডেমিক সেকশন স্থায়ীভাবে মুছে ফেলা হয়েছে'
                });

                // Refresh trashed sections table
                await getTrashedAcademicSections();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ব্যর্থ!',
                    text: response.data.message || 'একাডেমিক সেকশন মুছতে ব্যর্থ হয়েছে'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Something is Wrong!'
            });
        }
    }
    /* Trash lists end*/
</script>
