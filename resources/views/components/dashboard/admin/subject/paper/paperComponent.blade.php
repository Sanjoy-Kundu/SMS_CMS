<div class="container-fluid">
     <div class="row">
         <!-- Left Column: Subject Form -->
         <div class="col-xl-5 col-md-6 mb-4">
             <div class="card border-left-primary shadow h-100">
                 <div class="card-header bg-white py-3"
                     style="display: flex; justify-content: space-between; align-items: center;">
                     <h5 class="m-0 text-primary font-weight-bold">ADD PAPER</h5>
                 </div>
                 <div class="card-body">
                     <form id="PaperForm">
                         <div class="form-group">
                             <label for="class_id">Select Class</label>
                             <select class="form-control" id="class_id" name="class_id">
                                 <option value="" disabled selected>-- Select Class --</option>
                             </select>
                             <span id="class_id_error" class="text-danger small">--</span>
                         </div>
                         <!-- Division dropdown container - initially hidden -->
                         <div class="form-group">
                             <label for="subject_id">Select Subject</label>
                             <select class="form-control" id="subject_id" name="subject_id">
                                 <option value="" disabled selected>-- Select Subject --</option>
                             </select>
                             <span id="subject_id_error" class="text-danger small">--</span>
                         </div>
                         <div class="form-group">
                             <label for="name">Paper Name</label>
                             <input type="text" class="form-control" id="name" name="name"
                                 placeholder="e.g. Bangla, English, Math">
                             <span id="name_error" class="text-danger small">--</span>
                         </div>
                         <div class="form-group">
                             <label for="code">Paper Code</label>
                             <input type="text" class="form-control" id="code" name="code"
                                 placeholder="e.g. 101, 102, 103">
                             <span id="code_error" class="text-danger small">--</span>
                         </div>
                         <div class="form-group">
                             <div class="custom-control custom-switch">
                                 <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                     checked>
                                 <label class="custom-control-label" for="is_active">Active Status</label>
                             </div>
                         </div>
                         <button type="submit" class="btn btn-primary btn-block">Add Paper</button>
                     </form>
                 </div>
             </div>
         </div>
         <!-- Right Column: Papers Table -->
         <div class="col-xl-7 col-md-6 mb-4">
             <div class="card border-left-secondary shadow">
                 <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                     <h5 class="m-0 text-secondary font-weight-bold">Paper LISTS</h5>
                     <div class="spinner-border spinner-border-sm text-secondary d-none" id="papersLoader"
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
                             <input type="text" class="form-control" id="paperSearch"
                                 placeholder="Search by Paper Name, Code, Class or Subject...">
                             <div class="input-group-append">
                                 <button class="btn btn-secondary" type="button" id="searchPaperBtn">
                                     <i class="fas fa-search"></i> Search
                                 </button>
                                 <button class="btn btn-outline-secondary" type="button" id="clearPaperSearchBtn">
                                     <i class="fas fa-times"></i> Clear
                                 </button>
                             </div>
                         </div>
                     </div>
                     <div class="table-responsive">
                         <table class="table table-bordered table-hover table-sm" id="papers-table">
                             <thead class="thead-light">
                                 <tr>
                                     <th>Sr No.</th>
                                     <th>Class Name</th>
                                     <th>Subject Name</th>
                                     <th>Paper Name</th>
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
             <!-- Trashed Papers Card -->
             <div class="card border-left-danger shadow mt-3">
                 <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                     <h5 class="m-0 text-danger font-weight-bold">Trashed Papers</h5>
                     <div class="spinner-border spinner-border-sm text-danger d-none" id="trashedPapersLoader"
                         role="status">
                         <span class="sr-only">Loading...</span>
                     </div>
                 </div>
                 <div class="card-body">
                     <!-- Search Box for Trashed Items -->
                     <div class="form-group mb-3">
                         <div class="input-group">
                             <input type="text" class="form-control" id="trashedPaperSearch"
                                 placeholder="Search by Paper Name or Code...">
                             <div class="input-group-append">
                                 <button class="btn btn-danger" type="button" id="searchTrashedPaperBtn">
                                     <i class="fas fa-search"></i> Search
                                 </button>
                                 <button class="btn btn-outline-secondary" type="button"
                                     id="clearTrashedPaperSearchBtn">
                                     <i class="fas fa-times"></i> Clear
                                 </button>
                             </div>
                         </div>
                     </div>
                     <div class="table-responsive">
                         <table class="table table-bordered table-hover table-sm" id="trashed-papers-table">
                             <thead class="thead-light">
                                 <tr>
                                     <th>Sr No.</th>
                                     <th>Paper Name</th>
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
 <!-- Edit Paper Modal -->
 <div class="modal fade" id="editPaperModal" tabindex="-1" role="dialog"
     aria-labelledby="editPaperModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header border-primary">
                 <h5 class="modal-title text-primary font-weight-bold" id="editPaperModalLabel">Edit Paper</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form id="editPaperForm">
                 <div class="modal-body">
                     <div class="form-group">
                         <label for="edit_class_id">Select Class</label>
                         <select class="form-control" id="edit_class_id" name="class_id">
                             <option value="" disabled selected>-- Select Class --</option>
                         </select>
                         <span id="edit_class_id_error" class="text-danger small">--</span>
                     </div>
                     <!-- Division dropdown container - initially hidden -->
                     <div class="form-group">
                         <label for="edit_subject_id">Select Subject</label>
                         <select class="form-control" id="edit_subject_id" name="subject_id">
                             <option value="" disabled selected>-- Select Subject --</option>
                         </select>
                         <span id="edit_subject_id_error" class="text-danger small">--</span>
                     </div>
                     <div class="form-group">
                         <label for="edit_name">Paper Name</label>
                         <input type="text" class="form-control" id="edit_name" name="name"
                             placeholder="e.g. Bangla, English, Math">
                         <span id="edit_name_error" class="text-danger small">--</span>
                     </div>
                     <div class="form-group">
                         <label for="edit_code">Paper Code</label>
                         <input type="text" class="form-control" id="edit_code" name="code"
                             placeholder="e.g. 101, 102, 103">
                         <span id="edit_code_error" class="text-danger small">--</span>
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
                     <button type="submit" class="btn btn-primary">Update Paper</button>
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
    getPapers();
    getTrashedPapers();
    
    // Class change event for main form
    $('#class_id').on('change', function() {
        const classId = $(this).val();
        if (classId) {
            getSubjectsByClass(classId);
        } else {
            // Clear subject dropdown if no class selected
            $('#subject_id').html('<option value="" disabled selected>-- Select Subject --</option>');
        }
    });
    
    // Class change event for edit modal
    $('#edit_class_id').on('change', function() {
        const classId = $(this).val();
        if (classId) {
            getSubjectsByClassForEdit(classId);
        } else {
            // Clear subject dropdown if no class selected
            $('#edit_subject_id').html('<option value="" disabled selected>-- Select Subject --</option>');
        }
    });
    
    // Class filter change event
    $('#classFilter').on('change', function() {
        const classId = $(this).val();
        if (classId) {
            // Show division filter and populate it
            $('#divisionFilterContainer').show();
            getDivisionsForFilter(classId);
            // Filter papers by class
            filterPapersByClass(classId);
        } else {
            // Hide division filter if no class selected
            $('#divisionFilterContainer').hide();
            $('#divisionFilter').val('');
            // Get all papers
            getPapers();
        }
    });
    
    // Division filter change event
    $('#divisionFilter').on('change', function() {
        const classId = $('#classFilter').val();
        const divisionId = $(this).val();
        if (classId) {
            if (divisionId) {
                filterPapersByClassAndDivision(classId, divisionId);
            } else {
                filterPapersByClass(classId);
            }
        }
    });
    
    // Paper Form Submit
    $('#PaperForm').on('submit', async function(e) {
        e.preventDefault();
        await createPaper();
    });
    
    // Edit Paper Form Submit
    $('#editPaperForm').on('submit', async function(e) {
        e.preventDefault();
        await updatePaper();
    });
    
    // Reset modal when it's closed
    $('#editPaperModal').on('hidden.bs.modal', function() {
        $('#editPaperForm')[0].reset();
        $('.text-danger').text('');
    });
    
    // Search functionality for Papers
    $('#searchPaperBtn').on('click', function() {
        filterPapers();
    });
    
    // Clear search functionality
    $('#clearPaperSearchBtn').on('click', function() {
        $('#paperSearch').val('');
        const classId = $('#classFilter').val();
        const divisionId = $('#divisionFilter').val();
        if (classId && divisionId) {
            filterPapersByClassAndDivision(classId, divisionId);
        } else if (classId) {
            filterPapersByClass(classId);
        } else {
            getPapers();
        }
    });
    
    // Search on Enter key press
    $('#paperSearch').on('keyup', function(e) {
        if (e.key === 'Enter') {
            filterPapers();
        }
    });
    
    // Real-time search as user types
    $('#paperSearch').on('input', function() {
        const searchTerm = $(this).val().trim();
        if (searchTerm === '') {
            const classId = $('#classFilter').val();
            const divisionId = $('#divisionFilter').val();
            if (classId && divisionId) {
                filterPapersByClassAndDivision(classId, divisionId);
            } else if (classId) {
                filterPapersByClass(classId);
            } else {
                getPapers();
            }
        } else {
            filterPapersClientSide(searchTerm);
        }
    });
    
    // Search functionality for Trashed Papers
    $('#searchTrashedPaperBtn').on('click', function() {
        filterTrashedPapers();
    });
    
    // Clear search functionality for trashed
    $('#clearTrashedPaperSearchBtn').on('click', function() {
        $('#trashedPaperSearch').val('');
        getTrashedPapers();
    });
    
    // Search on Enter key press for trashed
    $('#trashedPaperSearch').on('keyup', function(e) {
        if (e.key === 'Enter') {
            filterTrashedPapers();
        }
    });
    
    // Real-time search for trashed as user types
    $('#trashedPaperSearch').on('input', function() {
        const searchTerm = $(this).val().trim();
        if (searchTerm === '') {
            getTrashedPapers();
        } else {
            filterTrashedPapersClientSide(searchTerm);
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
        console.log(response.data.status === 'success');
        if (response.data.data) {  // Fixed: changed from status to success
            let classLists = response.data.data;
            populateClassDropdowns(classLists);
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
function populateClassDropdowns(classLists) {
    console.log(classLists);
    let options = '<option value="" disabled selected>-- Select Class --</option>';
    if (classLists && classLists.length > 0) {
        classLists.forEach(classLists => {
            console.log(classLists);
            options += `<option value="${classLists.id}">${classLists.name}</option>`;
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

// Get subjects by class ID for main form
async function getSubjectsByClass(classId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    try {
        const response = await axios.post('/paper/get-subjects-by-class-and-division', {  // Fixed: changed endpoint
            class_id: classId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            const subjects = response.data.data;
            let options = '<option value="" disabled selected>-- Select Subject --</option>';
            subjects.forEach(subject => {
                options += `<option value="${subject.id}">${subject.name}</option>`;
            });
            $('#subject_id').html(options);
        } else {
            console.error('Error loading subjects:', response.data);
            $('#subject_id').html('<option value="" disabled>No subjects available</option>');
        }
    } catch (error) {
        console.error('Error fetching subjects:', error);
        $('#subject_id').html('<option value="" disabled>Error loading subjects</option>');
    }
}

// Get subjects by class ID for edit form
async function getSubjectsByClassForEdit(classId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    try {
        const response = await axios.post('/paper/get-subjects-by-class-and-division', {  // Fixed: changed endpoint
            class_id: classId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            const subjects = response.data.data;
            let options = '<option value="" disabled selected>-- Select Subject --</option>';
            subjects.forEach(subject => {
                options += `<option value="${subject.id}">${subject.name}</option>`;
            });
            $('#edit_subject_id').html(options);
        } else {
            console.error('Error loading subjects:', response.data.message);
            $('#edit_subject_id').html('<option value="" disabled>No subjects available</option>');
        }
    } catch (error) {
        console.error('Error fetching subjects:', error);
        $('#edit_subject_id').html('<option value="" disabled>Error loading subjects</option>');
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
        const response = await axios.post('/paper/get-divisions-by-class', {
            class_id: classId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
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

// Get Papers
async function getPapers() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    // Show loader
    $('#papersLoader').removeClass('d-none');
    try {
        const response = await axios.post('/paper/list', {}, {  // Fixed: changed from lists to list
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            populatePapersTable(response.data.data);
        }
    } catch (error) {
        console.error('Error fetching papers:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load papers. Please try again later.'
        });
    } finally {
        // Hide loader
        $('#papersLoader').addClass('d-none');
    }
}

// Populate Papers Table
// Populate Papers Table
function populatePapersTable(papers) {
    let tbody = '';
    if (!papers || papers.length === 0) {
        tbody = `<tr><td colspan="5" class="text-center">Paper Data Not Found</td></tr>`;
    } else {
        papers.forEach((paper, index) => {
            tbody += `
            <tr>
                <td>${index + 1}</td>
                <td>${paper.subject.classModel ? paper.subject.classModel.name : 'N/A'}</td>
                <td>${paper.subject.name}</td>
                <td>${paper.name} (${paper.code})</td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-primary edit-paper-btn" data-id="${paper.id}">EDIT</button>
                        <button type="button" class="btn btn-sm btn-warning trash-paper-btn" data-id="${paper.id}">TRASH</button>
                    </div>
                </td>
            </tr>`;
        });
    }
    $('#papers-table tbody').html(tbody);
}
// function populatePapersTable(papers) {
//     let tbody = '';
//     if (!papers || papers.length === 0) {
//         tbody = `<tr><td colspan="5" class="text-center">Paper Data Not Found</td></tr>`;
//     } else {
//         papers.forEach((paper, index) => {
            
//             tbody += `
//             <tr>
//                 <td>${index + 1}</td>
//                 <td>${paper.subject.class ? paper.subject.class.name : 'N/A'}</td>
//                 <td>${paper.subject.name}</td>
//                 <td>${paper.name} (${paper.code})</td>
//                 <td>
//                     <div class="btn-group" role="group">
//                         <button type="button" class="btn btn-sm btn-primary edit-paper-btn" data-id="${paper.id}">EDIT</button>
//                         <button type="button" class="btn btn-sm btn-warning trash-paper-btn" data-id="${paper.id}">TRASH</button>
//                     </div>
//                 </td>
//             </tr>`;
//         });
//     }
//     $('#papers-table tbody').html(tbody);
// }

// Filter papers by class
async function filterPapersByClass(classId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    // Show loader
    $('#papersLoader').removeClass('d-none');
    try {
        const response = await axios.post('/paper/list', {
            class_id: classId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            populatePapersTable(response.data.data);
        }
    } catch (error) {
        console.error('Error fetching papers:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load papers. Please try again later.'
        });
    } finally {
        // Hide loader
        $('#papersLoader').addClass('d-none');
    }
}

// Filter papers by class and division
async function filterPapersByClassAndDivision(classId, divisionId) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    // Show loader
    $('#papersLoader').removeClass('d-none');
    try {
        const response = await axios.post('/paper/list', {
            class_id: classId,
            division_id: divisionId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            populatePapersTable(response.data.data);
        }
    } catch (error) {
        console.error('Error fetching papers:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load papers. Please try again later.'
        });
    } finally {
        // Hide loader
        $('#papersLoader').addClass('d-none');
    }
}

// Create Paper
async function createPaper() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    // Reset errors
    $('.text-danger').text('');
    // Get form data
    const formData = {
        subject_id: $('#subject_id').val(),
        name: $('#name').val(),
        code: $('#code').val(),
        is_active: $('#is_active').is(':checked')
    };
    // Validation
    if (!formData.subject_id) {
        $('#subject_id_error').text('Please select a subject');
        return;
    }
    if (!formData.name) {
        $('#name_error').text('Paper name is required');
        return;
    }
    if (!formData.code) {
        $('#code_error').text('Paper code is required');
        return;
    }
    try {
        const response = await axios.post('/paper/create', formData, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            Swal.fire({
                icon: 'success',
                title: 'SUCCESS!',
                text: response.data.message
            });
            // Reset form
            $('#PaperForm')[0].reset();
            // Get current class filter
            const classId = $('#classFilter').val();
            const divisionId = $('#divisionFilter').val();
            // Refresh tables
            if (classId && divisionId) {
                await filterPapersByClassAndDivision(classId, divisionId);
            } else if (classId) {
                await filterPapersByClass(classId);
            } else {
                await getPapers();
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: response.data.message
            });
        }
    } catch (error) {
        console.log(error);
        if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            if (errors.subject_id) $('#subject_id_error').text(errors.subject_id[0]);
            if (errors.name) $('#name_error').text(errors.name[0]);
            if (errors.code) $('#code_error').text(errors.code[0]);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something went wrong'
            });
        }
    }
}

// Edit Paper
$(document).on('click', '.edit-paper-btn', async function() {
    const paperId = $(this).data('id');
    await getPaperForEdit(paperId);
    $('#editPaperModal').modal('show');
});

// Get Paper for Edit
async function getPaperForEdit(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    try {
        const response = await axios.post('/paper/edit-by-id', {
            id
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            const paper = response.data.data;
            // Populate form
            $('#edit_class_id').val(paper.subject.class_id);
            // Load subjects for this class
            if (paper.subject.class_id) {
                await getSubjectsByClassForEdit(paper.subject.class_id);
                // Set subject value after dropdown is populated
                setTimeout(() => {
                    $('#edit_subject_id').val(paper.subject_id);
                }, 300);
            }
            $('#edit_name').val(paper.name);
            $('#edit_code').val(paper.code);
            $('#edit_is_active').prop('checked', paper.is_active);
            // Store ID for update
            $('#editPaperForm').data('id', paper.id);
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

// Update Paper
async function updatePaper() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    // Reset errors
    $('.text-danger').text('');
    // Get form data
    const formData = {
        id: $('#editPaperForm').data('id'),
        subject_id: $('#edit_subject_id').val(),
        name: $('#edit_name').val(),
        code: $('#edit_code').val(),
        is_active: $('#edit_is_active').is(':checked')
    };
    // Validation
    if (!formData.subject_id) {
        $('#edit_subject_id_error').text('Please select a subject');
        return;
    }
    if (!formData.name) {
        $('#edit_name_error').text('Paper name is required');
        return;
    }
    if (!formData.code) {
        $('#edit_code_error').text('Paper code is required');
        return;
    }
    try {
        const response = await axios.post('/paper/update', formData, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            Swal.fire({
                icon: 'success',
                title: 'SUCCESS!',
                text: response.data.message
            });
            // Close modal
            $('#editPaperModal').modal('hide');
            // Get current class and division filters
            const classId = $('#classFilter').val();
            const divisionId = $('#divisionFilter').val();
            // Refresh tables
            if (classId && divisionId) {
                await filterPapersByClassAndDivision(classId, divisionId);
            } else if (classId) {
                await filterPapersByClass(classId);
            } else {
                await getPapers();
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
            if (errors.subject_id) $('#edit_subject_id_error').text(errors.subject_id[0]);
            if (errors.name) $('#edit_name_error').text(errors.name[0]);
            if (errors.code) $('#edit_code_error').text(errors.code[0]);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ERROR!',
                text: 'Something went wrong'
            });
        }
    }
}

// Trash Paper
$(document).on('click', '.trash-paper-btn', async function() {
    const paperId = $(this).data('id');
    const result = await Swal.fire({
        title: 'Are You Sure?',
        text: "Do you want to move this paper to trash?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'YES, TRASH CONFIRM',
        cancelButtonText: 'CANCEL'
    });
    if (result.isConfirmed) {
        await trashPaper(paperId);
    }
});

// Trash Paper Function
async function trashPaper(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    try {
        const response = await axios.post('/paper/trash', {
            id
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
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
                await filterPapersByClassAndDivision(classId, divisionId);
            } else if (classId) {
                await filterPapersByClass(classId);
            } else {
                await getPapers();
            }
            await getTrashedPapers();
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

// Get Trashed Papers
async function getTrashedPapers() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    // Show loader
    $('#trashedPapersLoader').removeClass('d-none');
    try {
        const response = await axios.post('/paper/trashed-list', {}, {  // Fixed: changed from trashed-lists to trashed-list
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            populateTrashedPapersTable(response.data.data);
        }
    } catch (error) {
        console.error('Error fetching trashed papers:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to fetch trashed papers'
        });
    } finally {
        // Hide loader
        $('#trashedPapersLoader').addClass('d-none');
    }
}

// Populate Trashed Papers Table
function populateTrashedPapersTable(trashLists) {
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
                        <button type="button" class="btn btn-sm btn-success restore-paper-btn" data-id="${trashData.id}">RESTORE</button>
                        <button type="button" class="btn btn-sm btn-danger delete-paper-btn" data-id="${trashData.id}">PER. DELETE</button>
                    </div>
                </td>
            </tr>`;
        });
    }
    $('#trashed-papers-table tbody').html(tbody);
}

// Restore Paper
$(document).on('click', '.restore-paper-btn', async function() {
    const paperId = $(this).data('id');
    const result = await Swal.fire({
        title: 'Are You Sure?',
        text: "Do you want to restore this paper?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'YES, RESTORE!',
        cancelButtonText: 'CANCEL'
    });
    if (result.isConfirmed) {
        await restorePaper(paperId);
    }
});

// Restore Paper Function
async function restorePaper(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    try {
        const response = await axios.post('/paper/restore', {
            id
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
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
                await filterPapersByClassAndDivision(classId, divisionId);
            } else if (classId) {
                await filterPapersByClass(classId);
            } else {
                await getPapers();
            }
            await getTrashedPapers();
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

// Permanently Delete Paper
$(document).on('click', '.delete-paper-btn', async function() {
    const paperId = $(this).data('id');
    const result = await Swal.fire({
        title: 'Are You Sure?',
        text: "Do you want to permanently delete this paper? This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#28a745',
        confirmButtonText: 'YES! DELETE PERMANENTLY',
        cancelButtonText: 'CANCEL'
    });
    if (result.isConfirmed) {
        await deletePaper(paperId);
    }
});

// Delete Paper Function
async function deletePaper(id) {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    try {
        const response = await axios.post('/paper/delete', {
            id
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            Swal.fire({
                icon: 'success',
                title: 'DELETED SUCCESSFULLY!',
                text: response.data.message
            });
            // Refresh trashed papers table
            await getTrashedPapers();
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

// Server-side filtering for Papers
async function filterPapers() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    const searchTerm = $('#paperSearch').val().trim();
    const classId = $('#classFilter').val();
    const divisionId = $('#divisionFilter').val();
    // Show loader
    $('#papersLoader').removeClass('d-none');
    try {
        const response = await axios.post('/paper/search', {
            search: searchTerm,
            class_id: classId,
            division_id: divisionId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  //
            populatePapersTable(response.data.data);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to search papers. Please try again later.'
            });
        }
    } catch (error) {
        console.error('Error searching papers:', error);
        // Fallback to client-side filtering if server-side fails
        filterPapersClientSide(searchTerm);
    } finally {
        // Hide loader
        $('#papersLoader').addClass('d-none');
    }
}

// Client-side filtering for Papers
function filterPapersClientSide(searchTerm) {
    const term = searchTerm.toLowerCase();
    $('#papers-table tbody tr').each(function() {
        const row = $(this);
        const className = row.find('td:nth-child(2)').text().toLowerCase();
        const subjectName = row.find('td:nth-child(3)').text().toLowerCase();
        const paperName = row.find('td:nth-child(4)').text().toLowerCase();
        
        if (className.includes(term) || subjectName.includes(term) || paperName.includes(term)) {
            row.show();
        } else {
            row.hide();
        }
    });
}

// Server-side filtering for Trashed Papers
async function filterTrashedPapers() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    const searchTerm = $('#trashedPaperSearch').val().trim();
    // Show loader
    $('#trashedPapersLoader').removeClass('d-none');
    try {
        const response = await axios.post('/paper/trashed-search', {
            search: searchTerm
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        if (response.data.success) {  // Fixed: changed from status to success
            populateTrashedPapersTable(response.data.data);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to search trashed papers. Please try again later.'
            });
        }
    } catch (error) {
        console.error('Error searching trashed papers:', error);
        // Fallback to client-side filtering if server-side fails
        filterTrashedPapersClientSide(searchTerm);
    } finally {
        // Hide loader
        $('#trashedPapersLoader').addClass('d-none');
    }
}

// Client-side filtering for Trashed Papers
function filterTrashedPapersClientSide(searchTerm) {
    const term = searchTerm.toLowerCase();
    $('#trashed-papers-table tbody tr').each(function() {
        const row = $(this);
        const paperName = row.find('td:nth-child(2)').text().toLowerCase();
        const paperCode = row.find('td:nth-child(3)').text().toLowerCase();
        
        if (paperName.includes(term) || paperCode.includes(term)) {
            row.show();
        } else {
            row.hide();
        }
    });
}
 </script>