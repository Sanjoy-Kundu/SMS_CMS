 <div class="container-fluid">
    <div class="row">
        <!-- Left Column: Subject Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-header bg-white py-3" style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 class="m-0 text-primary font-weight-bold">ADD SUBJECT</h5>
                    <button class="btn btn-primary text-white"><a href="{{url('/subject/overview')}}" style="color: white; text-decoration: none;">Subject Overview</a></button>
                </div>
                <div class="card-body">
                    <form id="subjectForm">
                        <div class="form-group">
                            <label for="class_id">Select Class</label>
                            <select class="form-control" id="class_id" name="class_id">
                                <option value="" disabled selected>-- Select Class --</option>
                            </select>
                            <span id="class_id_error" class="text-danger small">--</span>
                        </div>
                        
                        <!-- Division dropdown container - initially hidden -->
                        <div id="divisionDropdownContainer" style="display: none;">
                            <div class="form-group">
                                <label for="division_id">Select Division</label>
                                <select class="form-control" id="division_id" name="division_id">
                                    <option value="" disabled selected>-- Select Division --</option>
                                </select>
                                <span id="division_id_error" class="text-danger small">--</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Subject Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                placeholder="e.g. Bangla, English, Math">
                            <span id="name_error" class="text-danger small">--</span>
                        </div>
                        <div class="form-group">
                            <label for="code">Subject Code</label>
                            <input type="text" class="form-control" id="code" name="code" 
                                placeholder="e.g. 101, 102, 103">
                            <span id="code_error" class="text-danger small">--</span>
                        </div>
                        <div class="form-group">
                            <label for="type">Subject Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="compulsory" selected>Compulsory</option>
                                <option value="optional">Optional</option>
                                <option value="additional">Additional</option>
                            </select>
                            <span id="type_error" class="text-danger small">--</span>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                                <label class="custom-control-label" for="is_active">Active Status</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add Subject</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Subjects Table -->
        <div class="col-xl-7 col-md-6 mb-4">
            <div class="card border-left-secondary shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-secondary font-weight-bold">SUBJECT LISTS</h5>
                    <div class="spinner-border spinner-border-sm text-secondary d-none" id="subjectsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Class Filter -->
                    <div class="form-group mb-3">
                        <label for="classFilter">Filter by Class</label>
                        <select class="form-control" id="classFilter">
                            <option value="">All Classes</option>
                        </select>
                    </div>
                    
                    <!-- Division Filter - initially hidden -->
                    <div id="divisionFilterContainer" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="divisionFilter">Filter by Division</label>
                            <select class="form-control" id="divisionFilter">
                                <option value="">All Divisions</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Search Box -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="subjectSearch" placeholder="Search by Subject Name, Code, Class or Division...">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="searchSubjectBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button class="btn btn-outline-secondary" type="button" id="clearSubjectSearchBtn">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="subjects-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Class Name</th>
                                    <th>Subject Name</th>
                                    <th>View Subjects</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Trashed Subjects Card -->
            <div class="card border-left-danger shadow mt-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-danger font-weight-bold">Trashed Subjects</h5>
                    <div class="spinner-border spinner-border-sm text-danger d-none" id="trashedSubjectsLoader"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Box for Trashed Items -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="trashedSubjectSearch" placeholder="Search by Subject Name or Code...">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="button" id="searchTrashedSubjectBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button class="btn btn-outline-secondary" type="button" id="clearTrashedSubjectSearchBtn">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="trashed-subjects-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Subject Name</th>
                                    <th>Code</th>
                                    <th>Deleted At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog"
    aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-primary">
                <h5 class="modal-title text-primary font-weight-bold" id="editSubjectModalLabel">Edit Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSubjectForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_class_id">Select Class</label>
                        <select class="form-control" id="edit_class_id" name="class_id">
                            <option value="" disabled selected>-- Select Class --</option>
                        </select>
                        <span id="edit_class_id_error" class="text-danger small"></span>
                    </div>
                    
                    <!-- Edit division dropdown container - initially hidden -->
                    <div id="editDivisionDropdownContainer" style="display: none;">
                        <div class="form-group">
                            <label for="edit_division_id">Select Division</label>
                            <select class="form-control" id="edit_division_id" name="division_id">
                                <option value="" disabled selected>-- Select Division --</option>
                            </select>
                            <span id="edit_division_id_error" class="text-danger small"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_name">Subject Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                        <span id="edit_name_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_code">Subject Code</label>
                        <input type="text" class="form-control" id="edit_code" name="code">
                        <span id="edit_code_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_type">Subject Type</label>
                        <select class="form-control" id="edit_type" name="type">
                            <option value="compulsory">Compulsory</option>
                            <option value="optional">Optional</option>
                            <option value="additional">Additional</option>
                        </select>
                        <span id="edit_type_error" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="edit_is_active" name="is_active">
                            <label class="custom-control-label" for="edit_is_active">Active Status</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Subject</button>
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
        alert('Unauthorized Access');
        return;
    }
    
    // Initialize data
    getClasses();
    getSubjects();
    getTrashedSubjects();
    
    // Class change event for main form
    $('#class_id').on('change', function() {
        const classId = $(this).val();
        if (classId) {
            getDivisionsByClass(classId, '#divisionDropdownContainer', '#division_id');
        } else {
            // Hide division dropdown if no class selected
            $('#divisionDropdownContainer').hide();
            $('#division_id').val('');
        }
    });
    
    // Class change event for edit modal
    $('#edit_class_id').on('change', function() {
        const classId = $(this).val();
        if (classId) {
            getDivisionsByClass(classId, '#editDivisionDropdownContainer', '#edit_division_id');
        } else {
            // Hide division dropdown if no class selected
            $('#editDivisionDropdownContainer').hide();
            $('#edit_division_id').val('');
        }
    });
    
    // Class filter change event
    $('#classFilter').on('change', function() {
        const classId = $(this).val();
        if (classId) {
            // Show division filter and populate it
            $('#divisionFilterContainer').show();
            getDivisionsForFilter(classId);
            // Filter subjects by class
            filterSubjectsByClass(classId);
        } else {
            // Hide division filter if no class selected
            $('#divisionFilterContainer').hide();
            $('#divisionFilter').val('');
            // Get all subjects
            getSubjects();
        }
    });
    
    // Division filter change event
    $('#divisionFilter').on('change', function() {
        const classId = $('#classFilter').val();
        const divisionId = $(this).val();
        
        if (classId) {
            if (divisionId) {
                filterSubjectsByClassAndDivision(classId, divisionId);
            } else {
                filterSubjectsByClass(classId);
            }
        }
    });
    
    // Subject Form Submit
    $('#subjectForm').on('submit', async function(e) {
        e.preventDefault();
        await createSubject();
    });
    
    // Edit Subject Form Submit
    $('#editSubjectForm').on('submit', async function(e) {
        e.preventDefault();
        await updateSubject();
    });
    
    // Reset modal when it's closed
    $('#editSubjectModal').on('hidden.bs.modal', function() {
        $('#editSubjectForm')[0].reset();
        $('#editDivisionDropdownContainer').hide();
        $('.text-danger').text('');
    });
    
    // Search functionality for Subjects
    $('#searchSubjectBtn').on('click', function() {
        filterSubjects();
    });
    
    // Clear search functionality
    $('#clearSubjectSearchBtn').on('click', function() {
        $('#subjectSearch').val('');
        const classId = $('#classFilter').val();
        const divisionId = $('#divisionFilter').val();
        
        if (classId && divisionId) {
            filterSubjectsByClassAndDivision(classId, divisionId);
        } else if (classId) {
            filterSubjectsByClass(classId);
        } else {
            getSubjects();
        }
    });
    
    // Search on Enter key press
    $('#subjectSearch').on('keyup', function(e) {
        if (e.key === 'Enter') {
            filterSubjects();
        }
    });
    
    // Real-time search as user types
    $('#subjectSearch').on('input', function() {
        const searchTerm = $(this).val().trim();
        if (searchTerm === '') {
            const classId = $('#classFilter').val();
            const divisionId = $('#divisionFilter').val();
            
            if (classId && divisionId) {
                filterSubjectsByClassAndDivision(classId, divisionId);
            } else if (classId) {
                filterSubjectsByClass(classId);
            } else {
                getSubjects();
            }
        } else {
            filterSubjectsClientSide(searchTerm);
        }
    });
    
    // Search functionality for Trashed Subjects
    $('#searchTrashedSubjectBtn').on('click', function() {
        filterTrashedSubjects();
    });
    
    // Clear search functionality for trashed
    $('#clearTrashedSubjectSearchBtn').on('click', function() {
        $('#trashedSubjectSearch').val('');
        getTrashedSubjects();
    });
    
    // Search on Enter key press for trashed
    $('#trashedSubjectSearch').on('keyup', function(e) {
        if (e.key === 'Enter') {
            filterTrashedSubjects();
        }
    });
    
    // Real-time search for trashed as user types
    $('#trashedSubjectSearch').on('input', function() {
        const searchTerm = $(this).val().trim();
        if (searchTerm === '') {
            getTrashedSubjects();
        } else {
            filterTrashedSubjectsClientSide(searchTerm);
        }
    });
});

// Get Classes for dropdown
async function getClasses() {
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
            populateClassDropdowns(response.data.data);
            populateClassFilter(response.data.data);
        }
    } catch (error) {
        console.error('Error fetching classes:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load classes. Please try again later.'
        });
    }
}

// Populate Class dropdowns
function populateClassDropdowns(classes) {
    let options = '<option value="" disabled selected>-- Select Class --</option>';
    
    if (classes && classes.length > 0) {
        classes.forEach(classModel => {
            options += `<option value="${classModel.id}">${classModel.name}</option>`;
        });
    } else {
        options += '<option value="" disabled>No classes available</option>';
    }
    
    $('#class_id').html(options);
    $('#edit_class_id').html(options);
}

// Populate Class Filter dropdown
function populateClassFilter(classes) {
    let options = '<option value="">All Classes</option>';
    
    if (classes && classes.length > 0) {
        classes.forEach(classModel => {
            options += `<option value="${classModel.id}">${classModel.name}</option>`;
        });
    }
    
    $('#classFilter').html(options);
}

// Get divisions by class ID
async function getDivisionsByClass(classId, containerId, selectId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    try {
        const response = await axios.post('/subject/get-divisions-by-class', {
            class_id: classId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            const divisions = response.data.data;
            
            if (divisions.length > 0) {
                // Show division dropdown and populate it
                $(containerId).show();
                populateDivisionDropdown(divisions, selectId);
            } else {
                // Hide division dropdown if no divisions exist
                $(containerId).hide();
                $(selectId).val('');
            }
        } else {
            console.error('Error loading divisions:', response.data.message);
            $(containerId).hide();
        }
    } catch (error) {
        console.error('Error fetching divisions:', error);
        $(containerId).hide();
    }
}

// Get divisions for filter dropdown
async function getDivisionsForFilter(classId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    try {
        const response = await axios.post('/subject/get-divisions-by-class', {
            class_id: classId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            const divisions = response.data.data;
            let options = '<option value="">All Divisions</option>';
            
            divisions.forEach(division => {
                options += `<option value="${division.id}">${division.name}</option>`;
            });
            
            $('#divisionFilter').html(options);
        } else {
            console.error('Error loading divisions:', response.data.message);
            $('#divisionFilterContainer').hide();
        }
    } catch (error) {
        console.error('Error fetching divisions:', error);
        $('#divisionFilterContainer').hide();
    }
}

// Populate division dropdown
function populateDivisionDropdown(divisions, selectId) {
    let options = '<option value="" disabled selected>-- Select Division --</option>';
    
    divisions.forEach(division => {
        options += `<option value="${division.id}">${division.name}</option>`;
    });
    
    $(selectId).html(options);
}

// Get Subjects
async function getSubjects() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    // Show loader
    $('#subjectsLoader').removeClass('d-none');
    
    try {
        const response = await axios.post('/subject/lists', {}, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            populateSubjectsTable(response.data.data);
        }
    } catch (error) {
        console.error('Error fetching subjects:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load subjects. Please try again later.'
        });
    } finally {
        // Hide loader
        $('#subjectsLoader').addClass('d-none');
    }
}

// Populate Subjects Table
function populateSubjectsTable(subjects) {
    let tbody = '';
    
    if (!subjects || subjects.length === 0) {
        tbody = `<tr><td colspan="4" class="text-center">Subject Data Not Found</td></tr>`;
    } else {
        subjects.forEach((subject, index) => {
            tbody += `
                <tr>
                    <td>${index + 1}</td>
                    <td data-class-id="${subject.class_id}">${subject.class_model ? subject.class_model.name : 'N/A'}</td>
                    <td>${subject.name}</td>
                     <td>
                        <a href="/subject/overview?class_id=${subject.class_id}" class="btn btn-sm btn-info">
                            View Subjects
                        </a>
                    </td>
                    
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-primary edit-subject-btn" data-id="${subject.id}">EDIT</button>
                            <button type="button" class="btn btn-sm btn-danger trash-subject-btn" data-id="${subject.id}">TRASH</button>
                        </div>
                    </td>
                </tr>`;
        });
    }
    
    $('#subjects-table tbody').html(tbody);
}

// Filter subjects by class
async function filterSubjectsByClass(classId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    // Show loader
    $('#subjectsLoader').removeClass('d-none');
    
    try {
        const response = await axios.post('/subject/lists', {}, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            // Filter subjects by class
            const filteredSubjects = response.data.data.filter(subject => subject.class_id == classId);
            populateSubjectsTable(filteredSubjects);
        }
    } catch (error) {
        console.error('Error fetching subjects:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load subjects. Please try again later.'
        });
    } finally {
        // Hide loader
        $('#subjectsLoader').addClass('d-none');
    }
}

// Filter subjects by class and division
async function filterSubjectsByClassAndDivision(classId, divisionId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    // Show loader
    $('#subjectsLoader').removeClass('d-none');
    
    try {
        const response = await axios.post('/subject/lists', {}, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            // Filter subjects by class and division
            const filteredSubjects = response.data.data.filter(subject => 
                subject.class_id == classId && subject.division_id == divisionId
            );
            populateSubjectsTable(filteredSubjects);
        }
    } catch (error) {
        console.error('Error fetching subjects:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load subjects. Please try again later.'
        });
    } finally {
        // Hide loader
        $('#subjectsLoader').addClass('d-none');
    }
}

// Create Subject
async function createSubject() {
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
        division_id: $('#division_id').val() || null, // Can be null
        name: $('#name').val(),
        code: $('#code').val(),
        type: $('#type').val(),
        is_active: $('#is_active').is(':checked')
    };
    
    // Validation
    if (!formData.class_id) {
        $('#class_id_error').text('Please select a class');
        return;
    }
    
    if (!formData.name) {
        $('#name_error').text('Subject name is required');
        return;
    }
    
    try {
        const response = await axios.post('/subject/create', formData, {
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
            $('#subjectForm')[0].reset();
            $('#divisionDropdownContainer').hide();
            
            // Set class filter to the selected class
            $('#classFilter').val(formData.class_id);
            
            // Show division filter and populate it
            $('#divisionFilterContainer').show();
            await getDivisionsForFilter(formData.class_id);
            
            // If division was selected, set it and filter by both
            if (formData.division_id) {
                $('#divisionFilter').val(formData.division_id);
                await filterSubjectsByClassAndDivision(formData.class_id, formData.division_id);
            } else {
                // Otherwise just filter by class
                await filterSubjectsByClass(formData.class_id);
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: response.data.message
            });
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            console.log(error.response.data.errors);
            const errors = error.response.data.errors;
            if (errors.class_id) $('#class_id_error').text(errors.class_id[0]);
            if (errors.division_id) $('#division_id_error').text(errors.division_id[0]);
            if (errors.name) $('#name_error').text(errors.name[0]);
            if (errors.code) $('#code_error').text(errors.code[0]);
            if (errors.type) $('#type_error').text(errors.type[0]);
        } else {
            console.log(error)
        }
    }
}

// Edit Subject
$(document).on('click', '.edit-subject-btn', async function() {
    const subjectId = $(this).data('id');
    await getSubjectForEdit(subjectId);
    $('#editSubjectModal').modal('show');
});

// Get Subject for Edit
async function getSubjectForEdit(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    try {
        const response = await axios.post('/subject/edit-by-id', {
            id
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            const subject = response.data.subject;
            
            // Populate form
            $('#edit_class_id').val(subject.class_id);
            
            // Load divisions for this class
            if (subject.class_id) {
                await getDivisionsByClass(subject.class_id, '#editDivisionDropdownContainer', '#edit_division_id');
                
                // Set division value after dropdown is populated
                setTimeout(() => {
                    if (subject.division_id) {
                        $('#edit_division_id').val(subject.division_id);
                    }
                }, 300);
            }
            
            $('#edit_name').val(subject.name);
            $('#edit_code').val(subject.code);
            $('#edit_type').val(subject.type);
            $('#edit_is_active').prop('checked', subject.is_active);
            
            // Store ID for update
            $('#editSubjectForm').data('id', subject.id);
            
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
            text: 'Something went wrong'
        });
    }
}

// Update Subject
async function updateSubject() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    // Reset errors
    $('.text-danger').text('');
    
    // Get form data
    const formData = {
        id: $('#editSubjectForm').data('id'),
        class_id: $('#edit_class_id').val(),
        division_id: $('#edit_division_id').val() || null, // Can be null
        name: $('#edit_name').val(),
        code: $('#edit_code').val(),
        type: $('#edit_type').val(),
        is_active: $('#edit_is_active').is(':checked')
    };
    
    // Validation
    if (!formData.class_id) {
        $('#edit_class_id_error').text('Please select a class');
        return;
    }
    
    if (!formData.name) {
        $('#edit_name_error').text('Subject name is required');
        return;
    }
    
    try {
        const response = await axios.post('/subject/update', formData, {
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
            $('#editSubjectModal').modal('hide');
            
            // Set class filter to the selected class
            $('#classFilter').val(formData.class_id);
            
            // Show division filter and populate it
            $('#divisionFilterContainer').show();
            await getDivisionsForFilter(formData.class_id);
            
            // If division was selected, set it and filter by both
            if (formData.division_id) {
                $('#divisionFilter').val(formData.division_id);
                await filterSubjectsByClassAndDivision(formData.class_id, formData.division_id);
            } else {
                // Otherwise just filter by class
                await filterSubjectsByClass(formData.class_id);
            }
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
            if (errors.division_id) $('#edit_division_id_error').text(errors.division_id[0]);
            if (errors.name) $('#edit_name_error').text(errors.name[0]);
            if (errors.code) $('#edit_code_error').text(errors.code[0]);
            if (errors.type) $('#edit_type_error').text(errors.type[0]);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something went wrong'
            });
        }
    }
}

// Trash Subject
$(document).on('click', '.trash-subject-btn', async function() {
    const subjectId = $(this).data('id');
    
    const result = await Swal.fire({
        title: 'Are You Sure?',
        text: "Do you want to move this subject to trash?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'YES, TRASH CONFIRM',
        cancelButtonText: 'CANCEL'
    });
    
    if (result.isConfirmed) {
        await trashSubject(subjectId);
    }
});

// Trash Subject Function
async function trashSubject(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    try {
        const response = await axios.post('/subject/trash', {
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
            
            // Get current class and division filters
            const classId = $('#classFilter').val();
            const divisionId = $('#divisionFilter').val();
            
            // Refresh tables
            if (classId && divisionId) {
                await filterSubjectsByClassAndDivision(classId, divisionId);
            } else if (classId) {
                await filterSubjectsByClass(classId);
            } else {
                await getSubjects();
            }
            await getTrashedSubjects();
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

// Get Trashed Subjects
async function getTrashedSubjects() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    // Show loader
    $('#trashedSubjectsLoader').removeClass('d-none');
    
    try {
        const response = await axios.post('/subject/trashed-list', {}, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            populateTrashedSubjectsTable(response.data.data);
        }
    } catch (error) {
        console.error('Error fetching trashed subjects:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to fetch trashed subjects'
        });
    } finally {
        // Hide loader
        $('#trashedSubjectsLoader').addClass('d-none');
    }
}

// Populate Trashed Subjects Table
function populateTrashedSubjectsTable(trashLists) {
    let tbody = '';
    
    if (!trashLists || trashLists.length === 0) {
        tbody = `<tr><td colspan="5" class="text-center">No Trash Data Found.</td></tr>`;
    } else {
        trashLists.forEach((trashData, index) => {
            tbody += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${trashData.name}</td>
                    <td>${trashData.code || 'N/A'}</td>
                    <td>${trashData.deleted_at ? trashData.deleted_at.split('T')[0] : 'N/A'}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-success restore-subject-btn" data-id="${trashData.id}">RESTORE</button>
                            <button type="button" class="btn btn-sm btn-danger delete-subject-btn" data-id="${trashData.id}">PER. DELETE</button>
                        </div>
                    </td>
                </tr>`;
        });
    }
    
    $('#trashed-subjects-table tbody').html(tbody);
}

// Restore Subject
$(document).on('click', '.restore-subject-btn', async function() {
    const subjectId = $(this).data('id');
    
    const result = await Swal.fire({
        title: 'Are You Sure?',
        text: "Do you want to restore this subject?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'YES, RESTORE!',
        cancelButtonText: 'CANCEL'
    });
    
    if (result.isConfirmed) {
        await restoreSubject(subjectId);
    }
});

// Restore Subject Function
async function restoreSubject(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    try {
        const response = await axios.post('/subject/restore', {
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
            
            // Get current class and division filters
            const classId = $('#classFilter').val();
            const divisionId = $('#divisionFilter').val();
            
            // Refresh both tables
            if (classId && divisionId) {
                await filterSubjectsByClassAndDivision(classId, divisionId);
            } else if (classId) {
                await filterSubjectsByClass(classId);
            } else {
                await getSubjects();
            }
            await getTrashedSubjects();
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

// Permanently Delete Subject
$(document).on('click', '.delete-subject-btn', async function() {
    const subjectId = $(this).data('id');
    
    const result = await Swal.fire({
        title: 'Are You Sure?',
        text: "Do you want to permanently delete this subject? This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#28a745',
        confirmButtonText: 'YES! DELETE PERMANENTLY',
        cancelButtonText: 'CANCEL'
    });
    
    if (result.isConfirmed) {
        await deleteSubject(subjectId);
    }
});

// Delete Subject Function
async function deleteSubject(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    try {
        const response = await axios.post('/subject/delete', {
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
            
            // Refresh trashed subjects table
            await getTrashedSubjects();
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

// Server-side filtering for Subjects
async function filterSubjects() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    const searchTerm = $('#subjectSearch').val().trim();
    const classId = $('#classFilter').val();
    const divisionId = $('#divisionFilter').val();
    
    // Show loader
    $('#subjectsLoader').removeClass('d-none');
    
    try {
        const response = await axios.post('/subject/search', {
            search_term: searchTerm
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            // If class and division filters are applied, filter the results
            let subjects = response.data.data;
            if (classId) {
                subjects = subjects.filter(subject => subject.class_id == classId);
                
                if (divisionId) {
                    subjects = subjects.filter(subject => subject.division_id == divisionId);
                }
            }
            populateSubjectsTable(subjects);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to search subjects. Please try again later.'
            });
        }
    } catch (error) {
        console.error('Error searching subjects:', error);
        // Fallback to client-side filtering if server-side fails
        filterSubjectsClientSide(searchTerm);
    } finally {
        // Hide loader
        $('#subjectsLoader').addClass('d-none');
    }
}

// Client-side filtering for Subjects
function filterSubjectsClientSide(searchTerm) {
    const term = searchTerm.toLowerCase();
    const classId = $('#classFilter').val();
    const divisionId = $('#divisionFilter').val();
    
    $('#subjects-table tbody tr').each(function() {
        const row = $(this);
        const subjectName = row.find('td:nth-child(3)').text().toLowerCase();
        const className = row.find('td:nth-child(2)').text().toLowerCase();
        const rowClassId = row.find('td:nth-child(2)').data('class-id');
        
        // Check if class filter is applied and matches
        const classMatch = !classId || rowClassId == classId;
        
        // Check if division filter is applied and matches
        let divisionMatch = true;
        if (divisionId && classMatch) {
            // We need to get the division ID for this subject
            // Since we don't have it in the table, we'll need to fetch it or store it
            // For now, we'll assume division filtering is done server-side
            divisionMatch = false; // This is a limitation of client-side filtering
        }
        
        if (classMatch && divisionMatch && (subjectName.includes(term) || className.includes(term))) {
            row.show();
        } else {
            row.hide();
        }
    });
}

// Server-side filtering for Trashed Subjects
async function filterTrashedSubjects() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    const searchTerm = $('#trashedSubjectSearch').val().trim();
    
    // Show loader
    $('#trashedSubjectsLoader').removeClass('d-none');
    
    try {
        const response = await axios.post('/subject/trashed-search', {
            search_term: searchTerm
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            populateTrashedSubjectsTable(response.data.data);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to search trashed subjects. Please try again later.'
            });
        }
    } catch (error) {
        console.error('Error searching trashed subjects:', error);
        // Fallback to client-side filtering if server-side fails
        filterTrashedSubjectsClientSide(searchTerm);
    } finally {
        // Hide loader
        $('#trashedSubjectsLoader').addClass('d-none');
    }
}

// Client-side filtering for Trashed Subjects
function filterTrashedSubjectsClientSide(searchTerm) {
    const term = searchTerm.toLowerCase();
    
    $('#trashed-subjects-table tbody tr').each(function() {
        const row = $(this);
        const subjectName = row.find('td:nth-child(2)').text().toLowerCase();
        const subjectCode = row.find('td:nth-child(3)').text().toLowerCase();
        
        if (subjectName.includes(term) || subjectCode.includes(term)) {
            row.show();
        } else {
            row.hide();
        }
    });
}
</script> 


