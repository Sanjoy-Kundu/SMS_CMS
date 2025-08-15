<div class="container-fluid">
    <div class="row">
        <!-- Left Column: Class Model Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-primary font-weight-bold">ADD YOUR INSTITUTE CLASS</h5>
                </div>
                <div class="card-body">
                    <form id="classModelForm">
                        <div class="form-group">
                            <label for="academic_section_id">Select Academic Section</label>
                            <select class="form-control" id="academic_section_id" name="academic_section_id">
                                <option value="" disabled selected>-- Select Academic Section --</option>
                                
                            </select>
                            <span id="academic_section_id_error" class="text-danger small">--</span>
                        </div>
                        <div class="form-group">
                            <label for="class_name">Class Name</label>
                            <input type="text" class="form-control" id="class_name" name="name" 
                                placeholder="e.g. six, seven, eight, nine, ten, eleven, twelve">
                            <span id="name_error" class="text-danger small">--</span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add Class Model</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Right Column: Class Models Table -->
        <div class="col-xl-7 col-md-6 mb-4">
            <div class="card border-left-success shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-success font-weight-bold">UPLOADED CLASS LISTS</h5>
                    <div class="spinner-border spinner-border-sm text-success d-none" id="classModelsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Box Added Here -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="classModelSearch" placeholder="Search by Class Name or Institute Type...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="searchClassModelBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="class-models-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Institute Type</th>
                                    <th>Class Name</th>
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
            <!-- Trashed Class Models Card -->
            <div class="card border-left-warning shadow mt-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-warning font-weight-bold">Trashed Class Models</h5>
                    <div class="spinner-border spinner-border-sm text-warning d-none" id="trashedClassModelsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Box for Trashed Items Added Here -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="trashedClassModelSearch" placeholder="Search by Class Name...">
                            <div class="input-group-append">
                                <button class="btn btn-warning" type="button" id="searchTrashedClassModelBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button class="btn btn-outline-secondary" type="button" id="clearTrashedSearchBtn">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="trashed-class-models-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Class Name</th>
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
<!-- Edit Class Model Modal -->
<div class="modal fade" id="editClassModelModal" tabindex="-1" role="dialog"
    aria-labelledby="editClassModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-primary">
                <h5 class="modal-title text-primary font-weight-bold" id="editClassModelModalLabel">Edit Class Model
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editClassModelForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_academic_section_id">Select Academic Section</label>
                        <select class="form-control" id="edit_academic_section_id" name="academic_section_id" required>
                            <option value="" disabled selected>-- Select Academic Section --</option>
                        </select>
                        <span id="edit_academic_section_id_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_class_name">Class Name</label>
                        <input type="text" class="form-control" id="edit_class_name" name="name" required
                            placeholder="e.g. ষষ্ঠ, সপ্তম, অষ্টম">
                        <span id="edit_name_error" class="text-danger small"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Class Model</button>
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
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    $(document).ready(function() {
        let token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorize Access')
            return;
        }
        getAcademicSections();
        getClassModels();
        getTrashedClassModels();
        
        // Class Model Form Submit
        $('#classModelForm').on('submit', async function(e) {
            e.preventDefault();
            await createClassModel();
        });
        
        // Edit Class Model Form Submit
        $('#editClassModelForm').on('submit', async function(e) {
            e.preventDefault();
            await updateClassModel();
        });
        
        // Reset modal when it's closed
        $('#editClassModelModal').on('hidden.bs.modal', function() {
            $('#editClassModelForm')[0].reset();
            $('.text-danger').text('');
        });
        
        // Search functionality for Class Models
        $('#searchClassModelBtn').on('click', function() {
            filterClassModels();
        });
        
        // Clear search functionality
        $('#clearSearchBtn').on('click', function() {
            $('#classModelSearch').val('');
            getClassModels();
        });
        
        // Search on Enter key press
        $('#classModelSearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                filterClassModels();
            }
        });
        
        // Real-time search as user types
        $('#classModelSearch').on('input', function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm === '') {
                getClassModels();
            } else {
                // Client-side filtering for better UX
                filterClassModelsClientSide(searchTerm);
            }
        });
        
        // Search functionality for Trashed Class Models
        $('#searchTrashedClassModelBtn').on('click', function() {
            filterTrashedClassModels();
        });
        
        // Clear search functionality for trashed
        $('#clearTrashedSearchBtn').on('click', function() {
            $('#trashedClassModelSearch').val('');
            getTrashedClassModels();
        });
        
        // Search on Enter key press for trashed
        $('#trashedClassModelSearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                filterTrashedClassModels();
            }
        });
        
        // Real-time search for trashed as user types
        $('#trashedClassModelSearch').on('input', function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm === '') {
                getTrashedClassModels();
            } else {
                // Client-side filtering for better UX
                filterTrashedClassModelsClientSide(searchTerm);
            }
        });
    });
    
    // Client-side filtering for Class Models
    function filterClassModelsClientSide(searchTerm) {
        const term = searchTerm.toLowerCase();
        $('#class-models-table tbody tr').each(function() {
            const row = $(this);
            const className = row.find('td:nth-child(3)').text().toLowerCase();
            const instituteType = row.find('td:nth-child(2)').text().toLowerCase();
            
            if (className.includes(term) || instituteType.includes(term)) {
                row.show();
            } else {
                row.hide();
            }
        });
    }
    
    // Client-side filtering for Trashed Class Models
    function filterTrashedClassModelsClientSide(searchTerm) {
        const term = searchTerm.toLowerCase();
        $('#trashed-class-models-table tbody tr').each(function() {
            const row = $(this);
            const className = row.find('td:nth-child(2)').text().toLowerCase();
            
            if (className.includes(term)) {
                row.show();
            } else {
                row.hide();
            }
        });
    }
    
    // Server-side filtering for Class Models
    async function filterClassModels() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        
        const searchTerm = $('#classModelSearch').val().trim();
        
        // Show loader
        $('#classModelsLoader').removeClass('d-none');
        
        try {
            const response = await axios.post('/class-model/search', {
                search_term: searchTerm
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            
            if (response.data.status === 'success') {
                populateClassModelsTable(response.data.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to search class models. Please try again later.'
                });
            }
        } catch (error) {
            console.error('Error searching class models:', error);
            // Fallback to client-side filtering if server-side fails
            filterClassModelsClientSide(searchTerm);
        } finally {
            // Hide loader
            $('#classModelsLoader').addClass('d-none');
        }
    }
    
    // Server-side filtering for Trashed Class Models
    async function filterTrashedClassModels() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        
        const searchTerm = $('#trashedClassModelSearch').val().trim();
        
        // Show loader
        $('#trashedClassModelsLoader').removeClass('d-none');
        
        try {
            const response = await axios.post('/class-model/trashed-search', {
                search_term: searchTerm
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            
            if (response.data.status === 'success') {
                populateTrashedClassModelsTable(response.data.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to search trashed class models. Please try again later.'
                });
            }
        } catch (error) {
            console.error('Error searching trashed class models:', error);
            // Fallback to client-side filtering if server-side fails
            filterTrashedClassModelsClientSide(searchTerm);
        } finally {
            // Hide loader
            $('#trashedClassModelsLoader').addClass('d-none');
        }
    }
    
    // Get Academic Sections for dropdown
    async function getAcademicSections() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/academic/section/lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                populateAcademicSectionDropdowns(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching academic sections:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fail to load Accedemic Sections. Please try again later.'
            });
        }
    }
    
    // Populate Academic Section dropdowns
    function populateAcademicSectionDropdowns(sections) {
        let options = '<option value="" disabled selected>-- Choose One --</option>';
        if (sections && sections.length > 0) {
            sections.forEach(section => {
                const sectionType = section.section_type ? section.section_type: 'N/A';
                options +=
                    `<option value="${section.id}">${sectionType.toUpperCase()}</option>`;
            });
        } else {
            options += '<option value="" disabled>Fail to load academic section</option>';
        }
        $('#academic_section_id').html(options);
        $('#edit_academic_section_id').html(options);
    }
    
    // Get Class Models
async function getClassModels() {
    let token = localStorage.getItem('token');

    // Token না থাকলে সরাসরি লগইন পেইজে পাঠানো
    if (!token) {
        alert('Unauthorized Access. Please login first.');
        window.location.href = "/admin/login";
        return;
    }

    // Loader show
    $('#classModelsLoader').removeClass('d-none');

    try {
        const response = await axios.get('/class-model/lists', {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });

        if (response.data.status === 'success') {
            const sortedData = response.data.data.sort((a, b) => a.id - b.id);

            // Table populate
            populateClassModelsTable(sortedData);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: response.data.message || 'No data found'
            });
        }

    } catch (error) {
        console.error('Error fetching class models:', error);

        // Token expire হলে লগআউট
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('token');
            window.location.href = "/admin/login";
            return;
        }

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Fail to load class models. Please try again later'
        });

    } finally {
        // Loader hide
        $('#classModelsLoader').addClass('d-none');
    }
}

    
    // Populate Class Models Table
    function populateClassModelsTable(classModels) {
        let tbody = '';
        if (!classModels || classModels.length === 0) {
            tbody = `<tr><td colspan="4" class="text-center">Class Data Not Found</td></tr>`;
        } else {
            classModels.forEach((classModel, index) => {
                tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${classModel.academic_section.section_type.toUpperCase() || 'N/A'}</td>
                        <td>${classModel.name.toUpperCase() || 'N/A'}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary edit-class-model-btn" data-id="${classModel.id}">EDIT</button>
                                <button type="button" class="btn btn-sm btn-danger trash-class-model-btn" data-id="${classModel.id}">TRASH</button>
                            </div>
                        </td>
                    </tr>`;
            });
        }
        $('#class-models-table tbody').html(tbody);
    }
    
    // Create Class Model
    async function createClassModel() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Reset errors
        $('.text-danger').text('');
        // Get form data
        const formData = {
            academic_section_id: $('#academic_section_id').val(),
            name: $('#class_name').val()
        };
        // Validation
        if (!formData.academic_section_id) {
            $('#academic_section_id_error').text('Please select academic section');
            return;
        }
        if (!formData.name) {
            $('#name_error').text('Class name is required');
            return;
        }
        try {
            const response = await axios.post('/class-model/create', formData, {
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
                // Reset form
                $('#classModelForm')[0].reset();
                // Refresh table
                await getClassModels();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: response.data.message
                });
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.academic_section_id) $('#academic_section_id_error').text(errors.academic_section_id[0]);
                if (errors.name) $('#name_error').text(errors.name[0]);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'Something went wrong. Please try again later.'
                });
            }
        }
    }
    
    // Edit Class Model
    $(document).on('click', '.edit-class-model-btn', async function() {
        const classModelId = $(this).data('id');
        await getClassModelForEdit(classModelId);
        $('#editClassModelModal').modal('show');
    });
    
    // Get Class Model for Edit
    async function getClassModelForEdit(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/class-model/edit-by-id', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                const classModel = response.data.class_model;
                // Populate form
                $('#edit_academic_section_id').val(classModel.academic_section_id);
                $('#edit_class_name').val(classModel.name);
                // Store ID for update
                $('#editClassModelForm').data('id', classModel.id);
                // Clear errors
                $('.text-danger').text('');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
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
    
    // Update Class Model
    async function updateClassModel() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Reset errors
        $('.text-danger').text('');
        // Get form data
        const formData = {
            id: $('#editClassModelForm').data('id'),
            academic_section_id: $('#edit_academic_section_id').val(),
            name: $('#edit_class_name').val()
        };
        // Validation
        if (!formData.academic_section_id) {
            $('#edit_academic_section_id_error').text('Choose Section');
            return;
        }
        if (!formData.name) {
            $('#edit_name_error').text('Name is Required');
            return;
        }
        try {
            const response = await axios.post('/class-model/update', formData, {
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
                $('#editClassModelModal').modal('hide');
                // Refresh table
                await getClassModels();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: response.data.message
                });
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.academic_section_id) $('#edit_academic_section_id_error').text(errors
                    .academic_section_id[0]);
                if (errors.name) $('#edit_name_error').text(errors.name[0]);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'Something is Wrong'
                });
            }
        }
    }
    
    // Trash Class Model
    $(document).on('click', '.trash-class-model-btn', async function() {
        const classModelId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Do you want to move this class to trash?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YES, TRASH CONFIRM',
            cancelButtonText: 'CANCEL'
        });
        if (result.isConfirmed) {
            await trashClassModel(classModelId);
        }
    });
    
    // Trash Class Model Function
    async function trashClassModel(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/class-model/trash', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Moved to trash, Successfully!',
                    text: response.data.message
                });
                // Refresh tables
                await getClassModels();
                await getTrashedClassModels();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: response.data.message
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something went wrong, Please try again later'
            });
        }
    }
    
    // Get Trashed Class Models
    async function getTrashedClassModels() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Show loader
        $('#trashedClassModelsLoader').removeClass('d-none');
        try {
            const response = await axios.post('/class-model/trashed-list', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                populateTrashedClassModelsTable(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching trashed class models:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fail to fetch trashed class models'
            });
        } finally {
            // Hide loader
            $('#trashedClassModelsLoader').addClass('d-none');
        }
    }
    
    // Populate Trashed Class Models Table
    function populateTrashedClassModelsTable(trashLists) {
        let tbody = '';
        if (!trashLists || trashLists.length === 0) {
            tbody = `<tr><td colspan="5" class="text-center">No Trash Data Found.</td></tr>`;
        } else {
            trashLists.forEach((trashData, index) => {
                tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${trashData.name.toUpperCase() || 'N/A'}</td>
                        <td>${trashData.deleted_at ? trashData.deleted_at.split('T')[0] : 'N/A'}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-success restore-class-model-btn" data-id="${trashData.id}">RESTORE</button>
                                <button type="button" class="btn btn-sm btn-danger delete-class-model-btn" data-id="${trashData.id}">PER. DELETE</button>
                            </div>
                        </td>
                    </tr>`;
            });
        }
        $('#trashed-class-models-table tbody').html(tbody);
    }
    
    // Restore Class Model
    $(document).on('click', '.restore-class-model-btn', async function() {
        const classModelId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Do you want to restore this class?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YES, RESTORE!',
            cancelButtonText: 'CANCEL'
        });
        if (result.isConfirmed) {
            await restoreClassModel(classModelId);
        }
    });
    
    // Restore Class Model Function
    async function restoreClassModel(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/class-model/restore', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'RESTORE SUCCESSFUL',
                    text: response.data.message
                });
                // Refresh both tables
                await getClassModels();
                await getTrashedClassModels();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: response.data.message 
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something went wrong. Please try again later'
            });
        }
    }
    
    // Permanently Delete Class Model
    $(document).on('click', '.delete-class-model-btn', async function() {
        const classModelId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Do you want to permanently delete this class? This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#28a745',
            confirmButtonText: 'YES! DELETE PERMANENTLY',
            cancelButtonText: 'CANCEL'
        });
        if (result.isConfirmed) {
            await deleteClassModel(classModelId);
        }
    });
    
    // Delete Class Model Function
    async function deleteClassModel(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/class-model/delete', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'DELETED SUCCESSFULLY!',
                    text: response.data.message
                });
                // Refresh trashed sections table
                await getTrashedClassModels();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: response.data.message
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something went wrong. Please try again later.'
            });
        }
    }
    

</script>
