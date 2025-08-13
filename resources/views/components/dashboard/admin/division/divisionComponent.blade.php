<!-- Division Section -->
<div class="container-fluid">
    <div class="row">
        <!-- Left Column: Division Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 text-info font-weight-bold">ADD DIVISION</h5>
                </div>
                <div class="card-body">
                    <form id="divisionForm">
                        <div class="form-group">
                            <label for="class_id">Select Class</label>
                            <select class="form-control" id="class_id" name="class_id">
                                <option value="" disabled selected>-- Select Class --</option>
                                
                            </select>
                            <span id="class_id_error" class="text-danger small">--</span>
                        </div>
                        <div class="form-group">
                            <label for="division_name">Division Name</label>
                            <input type="text" class="form-control" id="division_name" name="name" 
                                placeholder="e.g. A, B, C, Science, Arts">
                            <span id="division_name_error" class="text-danger small">--</span>
                        </div>
                        <button type="submit" class="btn btn-info btn-block">Add Division</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Right Column: Divisions Table -->
        <div class="col-xl-7 col-md-6 mb-4">
            <div class="card border-left-secondary shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-secondary font-weight-bold">DIVISION LISTS</h5>
                    <div class="spinner-border spinner-border-sm text-secondary d-none" id="divisionsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Box Added Here -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="divisionSearch" placeholder="Search by Division Name or Class Name...">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="searchDivisionBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button class="btn btn-outline-secondary" type="button" id="clearDivisionSearchBtn">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="divisions-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Class Name</th>
                                    <th>Division Name</th>
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
            <!-- Trashed Divisions Card -->
            <div class="card border-left-danger shadow mt-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-danger font-weight-bold">Trashed Divisions</h5>
                    <div class="spinner-border spinner-border-sm text-danger d-none" id="trashedDivisionsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Box for Trashed Items Added Here -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="trashedDivisionSearch" placeholder="Search by Division Name...">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="button" id="searchTrashedDivisionBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button class="btn btn-outline-secondary" type="button" id="clearTrashedDivisionSearchBtn">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="trashed-divisions-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Division Name</th>
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
<!-- Edit Division Modal -->
<div class="modal fade" id="editDivisionModal" tabindex="-1" role="dialog"
    aria-labelledby="editDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-info">
                <h5 class="modal-title text-info font-weight-bold" id="editDivisionModalLabel">Edit Division
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDivisionForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_class_id">Select Class</label>
                        <select class="form-control" id="edit_class_id" name="class_id" required>
                            <option value="" disabled selected>-- Select Class --</option>
                        </select>
                        <span id="edit_class_id_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_division_name">Division Name</label>
                        <input type="text" class="form-control" id="edit_division_name" name="name" required
                            placeholder="e.g. A, B, C, Science, Arts">
                        <span id="edit_division_name_error" class="text-danger small"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">Update Division</button>
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
        getClassesForDivision();
        getDivisions();
        getTrashedDivisions();
        
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
        
        // Division Form Submit
        $('#divisionForm').on('submit', async function(e) {
            e.preventDefault();
            await createDivision();
        });
        
        // Edit Division Form Submit
        $('#editDivisionForm').on('submit', async function(e) {
            e.preventDefault();
            await updateDivision();
        });
        
        // Reset modal when it's closed
        $('#editDivisionModal').on('hidden.bs.modal', function() {
            $('#editDivisionForm')[0].reset();
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
        
        // Search functionality for Divisions
        $('#searchDivisionBtn').on('click', function() {
            filterDivisions();
        });
        
        // Clear search functionality for divisions
        $('#clearDivisionSearchBtn').on('click', function() {
            $('#divisionSearch').val('');
            getDivisions();
        });
        
        // Search on Enter key press for divisions
        $('#divisionSearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                filterDivisions();
            }
        });
        
        // Real-time search for divisions as user types
        $('#divisionSearch').on('input', function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm === '') {
                getDivisions();
            } else {
                // Client-side filtering for better UX
                filterDivisionsClientSide(searchTerm);
            }
        });
        
        // Search functionality for Trashed Divisions
        $('#searchTrashedDivisionBtn').on('click', function() {
            filterTrashedDivisions();
        });
        
        // Clear search functionality for trashed divisions
        $('#clearTrashedDivisionSearchBtn').on('click', function() {
            $('#trashedDivisionSearch').val('');
            getTrashedDivisions();
        });
        
        // Search on Enter key press for trashed divisions
        $('#trashedDivisionSearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                filterTrashedDivisions();
            }
        });
        
        // Real-time search for trashed divisions as user types
        $('#trashedDivisionSearch').on('input', function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm === '') {
                getTrashedDivisions();
            } else {
                // Client-side filtering for better UX
                filterTrashedDivisionsClientSide(searchTerm);
            }
        });
    });
    
    // Normalize class name function - now just trims without number conversion
    function normalizeClassName(className) {
        if (!className) return '';
        return className.trim();
    }
    
    // Format class name for display - now just returns the name without conversion
    function formatClassName(className) {
        return className || 'N/A';
    }
    
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
    
    // Client-side filtering for Divisions
    function filterDivisionsClientSide(searchTerm) {
        const term = searchTerm.toLowerCase();
        $('#divisions-table tbody tr').each(function() {
            const row = $(this);
            const divisionName = row.find('td:nth-child(3)').text().toLowerCase();
            const className = row.find('td:nth-child(2)').text().toLowerCase();
            
            if (divisionName.includes(term) || className.includes(term)) {
                row.show();
            } else {
                row.hide();
            }
        });
    }
    
    // Client-side filtering for Trashed Divisions
    function filterTrashedDivisionsClientSide(searchTerm) {
        const term = searchTerm.toLowerCase();
        $('#trashed-divisions-table tbody tr').each(function() {
            const row = $(this);
            const divisionName = row.find('td:nth-child(2)').text().toLowerCase();
            
            if (divisionName.includes(term)) {
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
    
    // Server-side filtering for Divisions
    async function filterDivisions() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        
        const searchTerm = $('#divisionSearch').val().trim();
        
        // Show loader
        $('#divisionsLoader').removeClass('d-none');
        
        try {
            const response = await axios.post('/division-class/search', {
                search_term: searchTerm
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            
            if (response.data.status === 'success') {
                populateDivisionsTable(response.data.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to search divisions. Please try again later.'
                });
            }
        } catch (error) {
            console.error('Error searching divisions:', error);
            // Fallback to client-side filtering if server-side fails
            filterDivisionsClientSide(searchTerm);
        } finally {
            // Hide loader
            $('#divisionsLoader').addClass('d-none');
        }
    }
    
    // Server-side filtering for Trashed Divisions
    async function filterTrashedDivisions() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        
        const searchTerm = $('#trashedDivisionSearch').val().trim();
        
        // Show loader
        $('#trashedDivisionsLoader').removeClass('d-none');
        
        try {
            const response = await axios.post('/division-class/trashed-search', {
                search_term: searchTerm
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            
            if (response.data.status === 'success') {
                populateTrashedDivisionsTable(response.data.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to search trashed divisions. Please try again later.'
                });
            }
        } catch (error) {
            console.error('Error searching trashed divisions:', error);
            // Fallback to client-side filtering if server-side fails
            filterTrashedDivisionsClientSide(searchTerm);
        } finally {
            // Hide loader
            $('#trashedDivisionsLoader').addClass('d-none');
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
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Show loader
        $('#classModelsLoader').removeClass('d-none');
        try {
            const response = await axios.post('/class-model/lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                populateClassModelsTable(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching class models:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fail to load class models. Please try again later'
            });
        } finally {
            // Hide loader
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
                        <td>${classModel.academic_section.section_type || 'N/A'}</td>
                        <td>${formatClassName(classModel.name)}</td>
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
            name: normalizeClassName($('#class_name').val())
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
                // Refresh class dropdown for division
                await getClassesForDivision();
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
                $('#edit_class_name').val(formatClassName(classModel.name));
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
            name: normalizeClassName($('#edit_class_name').val())
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
                // Refresh class dropdown for division
                await getClassesForDivision();
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
                // Refresh class dropdown for division
                await getClassesForDivision();
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
                        <td>${formatClassName(trashData.name)}</td>
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
                // Refresh class dropdown for division
                await getClassesForDivision();
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
    
    // Get Classes for Division dropdown
    async function getClassesForDivision() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/class-model/lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                populateClassDropdownForDivision(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching classes for division:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fail to load classes. Please try again later.'
            });
        }
    }
    
    // Populate Class dropdown for Division
    function populateClassDropdownForDivision(classes) {
        let options = '<option value="" disabled selected>-- Select Class --</option>';
        if (classes && classes.length > 0) {
            classes.forEach(classModel => {
                const className = formatClassName(classModel.name);
                options += `<option value="${classModel.id}">${className}</option>`;
            });
        } else {
            options += '<option value="" disabled>No classes available</option>';
        }
        $('#class_id').html(options);
        $('#edit_class_id').html(options);
    }
    
    // Get Divisions
    async function getDivisions() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Show loader
        $('#divisionsLoader').removeClass('d-none');
        try {
            const response = await axios.post('/division-class/lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                console.log(response);
                populateDivisionsTable(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching divisions:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fail to load divisions. Please try again later'
            });
        } finally {
            // Hide loader
            $('#divisionsLoader').addClass('d-none');
        }
    }
    
    // Populate Divisions Table
    function populateDivisionsTable(divisions) {
        let tbody = '';
        if (!divisions || divisions.length === 0) {
            tbody = `<tr><td colspan="4" class="text-center">Division Data Not Found</td></tr>`;
        } else {
            divisions.forEach((division, index) => {
                console.log(division.class_model.name);
                //const className = division.classModel formatClassName(division.classModel.name) : 'N/A';
                tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${division.class_model.name.toUpperCase() ? division.class_model.name.toUpperCase() : 'N/A'}</td>
                        <td>${division.name?division.name.toUpperCase() :'N/A'}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-info edit-division-btn" data-id="${division.id}">EDIT</button>
                                <button type="button" class="btn btn-sm btn-danger trash-division-btn" data-id="${division.id}">TRASH</button>
                            </div>
                        </td>
                    </tr>`;
            });
        }
        $('#divisions-table tbody').html(tbody);
    }
    
    // Create Division
    async function createDivision() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Reset errors
        $('.text-danger').text('');
        // Get form data
        const formData = {
            class_id: $('#class_id').val(),
            name: $('#division_name').val()
        };
        // Validation
        if (!formData.class_id) {
            $('#class_id_error').text('Please select class');
            return;
        }
        if (!formData.name) {
            $('#division_name_error').text('Division name is required');
            return;
        }
        try {
            const response = await axios.post('/division-class/create', formData, {
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
                $('#divisionForm')[0].reset();
                // Refresh table
                await getDivisions();
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
                if (errors.class_id) $('#class_id_error').text(errors.class_id[0]);
                if (errors.name) $('#division_name_error').text(errors.name[0]);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'Something went wrong. Please try again later.'
                });
            }
        }
    }
    
    // Edit Division
    $(document).on('click', '.edit-division-btn', async function() {
        const divisionId = $(this).data('id');
        await getDivisionForEdit(divisionId);
        $('#editDivisionModal').modal('show');
    });
    
    // Get Division for Edit
    async function getDivisionForEdit(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/division-class/edit-by-id', {
                id
            }, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                const division = response.data.division;
                // Populate form
                $('#edit_class_id').val(division.class_id);
                $('#edit_division_name').val(division.name);
                // Store ID for update
                $('#editDivisionForm').data('id', division.id);
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
    
    // Update Division
    async function updateDivision() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Reset errors
        $('.text-danger').text('');
        // Get form data
        const formData = {
            id: $('#editDivisionForm').data('id'),
            class_id: $('#edit_class_id').val(),
            name: $('#edit_division_name').val()
        };
        // Validation
        if (!formData.class_id) {
            $('#edit_class_id_error').text('Choose Class');
            return;
        }
        if (!formData.name) {
            $('#edit_division_name_error').text('Name is Required');
            return;
        }
        try {
            const response = await axios.post('/division-class/update', formData, {
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
                $('#editDivisionModal').modal('hide');
                // Refresh table
                await getDivisions();
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
                if (errors.class_id) $('#edit_class_id_error').text(errors.class_id[0]);
                if (errors.name) $('#edit_division_name_error').text(errors.name[0]);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'Something is Wrong'
                });
            }
        }
    }
    
    // Trash Division
    $(document).on('click', '.trash-division-btn', async function() {
        const divisionId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Do you want to move this division to trash?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YES, TRASH CONFIRM',
            cancelButtonText: 'CANCEL'
        });
        if (result.isConfirmed) {
            await trashDivision(divisionId);
        }
    });
    
    // Trash Division Function
    async function trashDivision(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/division-class/trash', {
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
                await getDivisions();
                await getTrashedDivisions();
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
    
    // Get Trashed Divisions
    async function getTrashedDivisions() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        // Show loader
        $('#trashedDivisionsLoader').removeClass('d-none');
        try {
            const response = await axios.post('/division-class/trashed-list', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (response.data.status === 'success') {
                populateTrashedDivisionsTable(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching trashed divisions:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fail to fetch trashed divisions'
            });
        } finally {
            // Hide loader
            $('#trashedDivisionsLoader').addClass('d-none');
        }
    }
    
    // Populate Trashed Divisions Table
    function populateTrashedDivisionsTable(trashLists) {
        let tbody = '';
        if (!trashLists || trashLists.length === 0) {
            tbody = `<tr><td colspan="5" class="text-center">No Trash Data Found.</td></tr>`;
        } else {
            trashLists.forEach((trashData, index) => {
                tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${trashData.name || 'N/A'}</td>
                        <td>${trashData.deleted_at ? trashData.deleted_at.split('T')[0] : 'N/A'}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-success restore-division-btn" data-id="${trashData.id}">RESTORE</button>
                                <button type="button" class="btn btn-sm btn-danger delete-division-btn" data-id="${trashData.id}">PER. DELETE</button>
                            </div>
                        </td>
                    </tr>`;
            });
        }
        $('#trashed-divisions-table tbody').html(tbody);
    }
    
    // Restore Division
    $(document).on('click', '.restore-division-btn', async function() {
        const divisionId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Do you want to restore this division?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YES, RESTORE!',
            cancelButtonText: 'CANCEL'
        });
        if (result.isConfirmed) {
            await restoreDivision(divisionId);
        }
    });
    
    // Restore Division Function
    async function restoreDivision(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/division-class/restore', {
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
                await getDivisions();
                await getTrashedDivisions();
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
    
    // Permanently Delete Division
    $(document).on('click', '.delete-division-btn', async function() {
        const divisionId = $(this).data('id');
        const result = await Swal.fire({
            title: 'Are You Sure?',
            text: "Do you want to permanently delete this division? This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#28a745',
            confirmButtonText: 'YES! DELETE PERMANENTLY',
            cancelButtonText: 'CANCEL'
        });
        if (result.isConfirmed) {
            await deleteDivision(divisionId);
        }
    });
    
    // Delete Division Function
    async function deleteDivision(id) {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }
        try {
            const response = await axios.post('/division-class/delete', {
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
                await getTrashedDivisions();
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