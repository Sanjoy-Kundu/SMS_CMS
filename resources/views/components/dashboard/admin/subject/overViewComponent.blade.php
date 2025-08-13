{{-- <div class="container-fluid">
    <div class="row">
        <div class="col-xl-10 col-md-10 mb-0 mx-auto">
            <div class="card border-left-primary shadow h-100">
                <div class="card-header bg-white py-1 d-flex justify-content-between align-items-center">
                    <select class="form-control" id="class_id" name="class_id" style="width: 300px">
                        <option value="" disabled selected>-- Select Class --</option>
                        <option value="6">Six</option>
                        <option value="7">Seven</option>
                    </select>
                    <h5 class="m-0 text-primary font-weight-bold">ADD SUBJECT</h5>
                </div>

                <div class="card-body">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="govt_logo.png" alt="Govt Logo" style="height:50px; margin-right:20px;">
                        <img src="school_logo.png" alt="School Logo" style="height:50px;">
                        <h2>Govt. High School, Dhaka</h2>
                        <p>EIIN: 123456 | Academic Year: 2025-2026</p>
                    </div>

                    <table border="1" cellspacing="0" cellpadding="8"
                        style="width:100%; border-collapse: collapse; text-align:left;">
                        <thead style="background-color:#f2f2f2; text-align:center;">
                            <tr>
                                <th>Subject</th>
                                <th>Code</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Normal Subjects -->
                            <tr>
                                <td>Bangla</td>
                                <td>101</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <td>English</td>
                                <td>102</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <td>Math</td>
                                <td>103</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <td>ICT</td>
                                <td>104</td>
                                <td>100</td>
                            </tr>

                            <!-- Science Group -->
                            <tr>
                                <td rowspan="3">Science Group</td>
                                <td>Physics (201)</td>
                                <td rowspan="3">100</td>
                            </tr>
                            <tr>
                                <td>Chemistry (202)</td>
                           
                            </tr>
                            <tr>
                                <td>Biology (203)</td>
                              
                            </tr>

                            <!-- Commerce Group Example (Optional) -->
                          
                                    <tr>
                                        <td rowspan="2">Commerce Group</td>
                                        <td>Accounting (301)</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <td>Business Studies (302)</td>
                                        <td>100</td>
                                    </tr>
     
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>
</div>


 --}}

<style>
    .overview-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .overview-header {
        background-color: #f8f9fc;
        padding: 15px;
        border-bottom: 1px solid #e3e6f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .institution-info {
        text-align: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .institution-logo {
        height: 50px;
        margin-right: 15px;
    }
    
    .subject-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    .subject-table th, 
    .subject-table td {
        border: 1px solid #e3e6f0;
        padding: 10px;
        text-align: left;
    }
    
    .subject-table th {
        background-color: #f8f9fc;
        font-weight: 600;
        text-align: center;
    }
    
    .division-row td {
        background-color: #f1f5f9;
        font-weight: 600;
    }
    
    .subject-row td:first-child {
        padding-left: 30px;
    }
    
    .class-filter {
        width: 300px;
    }
    
    .no-data {
        text-align: center;
        padding: 30px;
        color: #858796;
    }
    
    .subject-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 600;
        display: inline-block;
        margin-right: 5px;
    }
    
    .badge-compulsory {
        background-color: #4e73df;
        color: white;
    }
    
    .badge-optional {
        background-color: #1cc88a;
        color: white;
    }
    
    .badge-additional {
        background-color: #f6c23e;
        color: white;
    }
    
    .badge-active {
        background-color: #1cc88a;
        color: white;
    }
    
    .badge-inactive {
        background-color: #e74a3b;
        color: white;
    }
</style>



<div class="container-fluid">
    <div class="row">
        <div class="col-xl-10 col-md-10 mx-auto">
            <div class="overview-card">
                <div class="overview-header">
                    <select class="form-control class-filter" id="class_id" name="class_id">
                        <option value="">All Classes</option>
                    </select>
                    <h5 class="m-0 text-primary font-weight-bold">SUBJECT OVERVIEW</h5>
                </div>
                <div class="card-body">
                    <!-- Institution Info -->
                    <div class="institution-info" id="institutionInfo">
                        <div>
                            <img src="{{ asset('images/govt_logo.png') }}" alt="Govt Logo" class="institution-logo">
                            <img src="{{ asset('images/school_logo.png') }}" alt="School Logo" class="institution-logo">
                            <h2 id="institutionName">Govt. High School, Dhaka</h2>
                            <p id="institutionDetails">EIIN: 123456 | Academic Year: 2025-2026</p>
                        </div>
                    </div>
                    
                    <!-- Subject Table Container -->
                    <div id="subjectTableContainer">
                        <div class="no-data">
                            <i class="fas fa-book fa-3x mb-3"></i>
                            <h4>Loading subject data...</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
$(document).ready(function() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    // Load overview data
    loadOverviewData();
    
    // Class filter change event
    $('#class_id').on('change', function() {
        loadOverviewData();
    });
});

// Load overview data
async function loadOverviewData() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    const classId = $('#class_id').val();
    
    try {
        const response = await axios.post('/subject/overview-data', {
            class_id: classId || null
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            const data = response.data.data;
            
            // Update institution info
            updateInstitutionInfo(data.institution);
            
            // Update class filter dropdown
            updateClassFilter(data.classes, classId);
            
            // Display subject table
            displaySubjectTable(data.grouped_subjects);
        } else {
            console.error('Error loading overview data:', response.data.message);
            displayError('Failed to load subject data');
        }
    } catch (error) {
        console.error('Error fetching overview data:', error);
        displayError('Failed to load subject data');
    }
}

// Update institution information
function updateInstitutionInfo(institution) {
    if (institution) {
        $('#institutionName').text(institution.name || 'Govt. High School, Dhaka');
        $('#institutionDetails').html(
            `EIIN: ${institution.eiin || '123456'} | Academic Year: 2025-2026`
        );
    }
}

// Update class filter dropdown
function updateClassFilter(classes, selectedClassId) {
    const classFilter = $('#class_id');
    classFilter.empty();
    classFilter.append('<option value="">All Classes</option>');
    
    if (classes && classes.length > 0) {
        classes.forEach(classModel => {
            const selected = classModel.id == selectedClassId ? 'selected' : '';
            classFilter.append(`<option value="${classModel.id}" ${selected}>${classModel.name}</option>`);
        });
    }
}

// Display subject table
function displaySubjectTable(groupedSubjects) {
    const container = $('#subjectTableContainer');
    container.empty();
    
    if (Object.keys(groupedSubjects).length === 0) {
        container.html(`
            <div class="no-data">
                <i class="fas fa-book fa-3x mb-3"></i>
                <h4>No subjects found</h4>
                <p>Try selecting a different class or add subjects first</p>
            </div>
        `);
        return;
    }
    
    let tableHtml = `
        <table class="subject-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    // Iterate through each class
    Object.keys(groupedSubjects).forEach(className => {
        const classData = groupedSubjects[className];
        
        // Iterate through each division in the class
        Object.keys(classData.divisions).forEach(divisionName => {
            const divisionData = classData.divisions[divisionName];
            
            // Add division row if it's not "General"
            if (divisionName !== 'General') {
                const subjectCount = divisionData.subjects.length;
                tableHtml += `
                    <tr class="division-row">
                        <td rowspan="${subjectCount}">${divisionName}</td>
                        ${subjectCount > 0 ? generateSubjectRows(divisionData.subjects, true) : '<td colspan="3">No subjects in this division</td>'}
                    </tr>
                `;
            } else {
                // For General division, just add the subject rows
                tableHtml += generateSubjectRows(divisionData.subjects, false);
            }
        });
    });
    
    tableHtml += `
            </tbody>
        </table>
    `;
    
    container.html(tableHtml);
}

// Generate subject rows HTML
function generateSubjectRows(subjects, isFirstRow) {
    let html = '';
    
    subjects.forEach((subject, index) => {
        if (index === 0 && isFirstRow) {
            // First subject in a division with rowspan
            html += `
                <td class="subject-row">
                    ${subject.name}
                    <div>
                        <span class="subject-badge badge-${subject.type}">${subject.type}</span>
                        <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                            ${subject.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </div>
                </td>
                <td>${subject.code || 'N/A'}</td>
                <td>
                    <span class="subject-badge badge-${subject.type}">${subject.type}</span>
                </td>
                <td>
                    <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                        ${subject.is_active ? 'Active' : 'Inactive'}
                    </span>
                </td>
            </tr>
            `;
        } else {
            // Subsequent subjects in a division
            html += `
                <tr class="subject-row">
                    <td>
                        ${subject.name}
                        <div>
                            <span class="subject-badge badge-${subject.type}">${subject.type}</span>
                            <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                                ${subject.is_active ? 'Active' : 'Inactive'}
                            </span>
                        </div>
                    </td>
                    <td>${subject.code || 'N/A'}</td>
                    <td>
                        <span class="subject-badge badge-${subject.type}">${subject.type}</span>
                    </td>
                    <td>
                        <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                            ${subject.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                </tr>
            `;
        }
    });
    
    return html;
}

// Display error message
function displayError(message) {
    const container = $('#subjectTableContainer');
    container.html(`
        <div class="no-data">
            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
            <h4>Error</h4>
            <p>${message}</p>
        </div>
    `);
}
</script>
