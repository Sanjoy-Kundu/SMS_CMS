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
    .division-row {
        background-color: #f1f5f9;
        font-weight: 600;
    }
    .type-row {
        background-color: #e2e8f0;
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
    .subject-name-cell {
        vertical-align: middle;
        font-weight: 500;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-10 col-md-10 mx-auto">
            <div class="overview-card">
                <div class="overview-header">
                    <select class="form-control class-filter" id="academic_section_id" name="academic_section_id">
                        <option value="">Choose Your Academic</option>
                    </select>
                    <select class="form-control class-filter" id="class_id" name="class_id">
                        <option value="">All Classes</option>
                    </select>
                </div>
                <div class="card-body">
                    <!-- Institution Info -->
                    <div class="institution-info" id="institutionInfo"
                        style="border-bottom: 2px solid #ccc; padding: 10px 0;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <!-- Left: Govt Logo -->
                            <div class="govt-logo">
                                <img src="{{ asset('logo/mousi.png') }}" alt="Govt Logo" style="height: 160px;">
                            </div>
                            <!-- Center: Govt Text -->
                            <div class="govt-text text-center" style="flex: 1; padding: 0 20px;">
                                <p style="margin: 0;font-size: 20px;font-weight: 600;line-height: 1.5;color: #0603c3;text-transform: uppercase;">
                                    Directorate of Secondary and Higher Education (DSHE),<br>
                                    Ministry of Education, Government of the People's Republic of Bangladesh
                                </p>
                            </div>
                            <!-- Right: School Logo -->
                            <div class="school-logo">
                                <img src="{{ asset('logo/logo.jpg') }}" alt="School Logo"
                                    style="height: 160px; border-radius: 50%;">
                            </div>
                        </div>
                        <!-- Below header row: School Name + EIIN + Academic Year -->
                        <div style="text-align: center; margin-top: 10px;">
                            <h2 id="institutionName" style="margin: 0;"></h2>
                            <h4 id="institutionAddress" style="margin: 0;"></h4>
                            <h6 style="margin: 0">
                                <b>EIIN</b>: <span id="institutionEiin"
                                    style="font-size: 15px; font-weight: bold;"></span> || <b>Academic Year</b>:
                                <span>{{ now()->year }} -
                                    {{ now()->year + 1 }}</span>
                            </h6>
                        </div>
                    </div>
                    
                    <!-- Subject Table Container -->
                    <div id="subjectTableContainer">
                        <div class="no-data">
                            <i class="fas fa-book fa-3x mb-3"></i>
                            <h4>Select an academic section and class to view subjects</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script>
    // Complete JavaScript solution
$(document).ready(function() {
    let token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }
    
    // Load academic sections on page load
    loadAcademicSections();
    
    // Academic section change event
    $('#academic_section_id').on('change', function() {
        const sectionId = $(this).val();
        if (sectionId) {
            loadClassesBySection(sectionId);
        } else {
            // Clear class dropdown and subject details
            $('#class_id').empty().append('<option value="">Please Choose Your Academic Part</option>');
            $('#subjectTableContainer').html('<div class="no-data"><i class="fas fa-book fa-3x mb-3"></i><h4>Select a class to view subjects</h4></div>');
        }
    });
    
    // Class change event
    $('#class_id').on('change', function() {
        const classId = $(this).val();
        if (classId) {
            loadSubjectDetails(classId);
        } else {
            $('#subjectTableContainer').html('<div class="no-data"><i class="fas fa-book fa-3x mb-3"></i><h4>Select a class to view subjects</h4></div>');
        }
    });
});
// Load academic sections
async function loadAcademicSections() {
    let token = localStorage.getItem('token');
    try {
        const response = await axios.post('/subject/get-academic-sections', {}, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            const sections = response.data.data;
            const institution = response.data.institution;
            
            // Update institution info
            document.querySelector('#institutionName').innerText = institution.name || 'Institute Name';
            document.querySelector('#institutionAddress').innerText = institution.address || 'Institute Address';
            document.querySelector('#institutionEiin').innerText = institution.eiin || 'Institute Eiin';
            
            const sectionDropdown = $('#academic_section_id');
            sectionDropdown.empty();
            sectionDropdown.append('<option value="">Choose Your Academic</option>');
            
            sections.forEach(section => {
                sectionDropdown.append(`<option value="${section.id}">${section.section_type}</option>`);
            });
        }
    } catch (error) {
        console.error('Error fetching academic sections:', error);
    }
}
// Load classes by section
async function loadClassesBySection(sectionId) {
    let token = localStorage.getItem('token');
    try {
        const response = await axios.post('/subject/get-classes-by-section', {
            academic_section_id: sectionId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            const classes = response.data.data;
            const classDropdown = $('#class_id');
            classDropdown.empty();
            classDropdown.append('<option value="">Choose Your Class</option>');
            
            classes.forEach(classModel => {
                classDropdown.append(`<option value="${classModel.id}">${classModel.name}</option>`);
            });
            
            // Clear subject details
            $('#subjectTableContainer').html('<div class="no-data"><i class="fas fa-book fa-3x mb-3"></i><h4>Select a class to view subjects</h4></div>');
        }
    } catch (error) {
        console.error('Error fetching classes:', error);
    }
}
// Load subject details
async function loadSubjectDetails(classId) {
    let token = localStorage.getItem('token');
    try {
        const response = await axios.post('/subject/get-subject-details', {
            class_id: classId
        }, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        
        if (response.data.status === 'success') {
            console.log(response.data.data);
            displaySubjectDetails(response.data.data);
        } else {
            displayError('No data found for this class');
        }
    } catch (error) {
        console.error('Error fetching subject details:', error);
        displayError('Failed to load subject details: ' + (error.response?.data?.message || error.message));
    }
}

function displaySubjectDetails(subjects) {
    const container = $('#subjectTableContainer');
    container.empty();
    
    if (!subjects || subjects.length === 0) {
        container.html(`
            <div class="no-data">
                <i class="fas fa-book fa-3x mb-3"></i>
                <h4>No subjects found for this class</h4>
            </div>
        `);
        return;
    }
    
    // Group subjects by division and then by type
    const groupedSubjects = {};
    subjects.forEach(subject => {
        const divisionName = subject.division ? subject.division.name : 'General';
        
        if (!groupedSubjects[divisionName]) {
            groupedSubjects[divisionName] = {
                compulsory: [],
                additional: [],
                optional: []
            };
        }
        
        // Add subject to appropriate type group
        if (subject.type === 'compulsory') {
            groupedSubjects[divisionName].compulsory.push(subject);
        } else if (subject.type === 'additional') {
            groupedSubjects[divisionName].additional.push(subject);
        } else if (subject.type === 'optional') {
            groupedSubjects[divisionName].optional.push(subject);
        }
    });
    
    // Check if there are divisions (other than General)
    const hasDivisions = Object.keys(groupedSubjects).some(name => name !== 'General');
    
    // Generate table HTML based on whether there are divisions
    let tableHtml;
    
    if (hasDivisions) {
        // Table with divisions (like class 9)
        tableHtml = `
            <table class="subject-table">
                <thead>
                    <tr>
                        <th>Division</th>
                        <th>Type</th>
                        <th>Subject Name</th>
                        <th>Subject Paper</th>
                        <th>Code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        // Process each division (including General)
        Object.keys(groupedSubjects).forEach(divisionName => {
            const division = groupedSubjects[divisionName];
            
            // Calculate total rows needed for this division (including all types and papers)
            let totalRows = 0;
            ['compulsory', 'additional', 'optional'].forEach(type => {
                division[type].forEach(subject => {
                    const papers = getPapersForSubject(subject);
                    totalRows += papers.length > 0 ? papers.length : 1;
                });
            });
            
            // Add division row with rowspan
            tableHtml += `
                <tr>
                    <td rowspan="${totalRows}" class="division-row">${divisionName}</td>
                    ${generateDivisionRows(division, true, true)}
                </tr>
            `;
        });
        
        tableHtml += `
                </tbody>
            </table>
        `;
    } else {
        // Table without divisions (like class 6)
        tableHtml = `
            <table class="subject-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Subject Name</th>
                        <th>Subject Paper</th>
                        <th>Code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        // Process each type in the General division
        const generalDivision = groupedSubjects['General'];
        ['compulsory', 'additional', 'optional'].forEach(type => {
            const subjectsOfType = generalDivision[type];
            if (subjectsOfType.length === 0) return;
            
            // Calculate total rows needed for this type (including papers)
            let totalRows = 0;
            subjectsOfType.forEach(subject => {
                const papers = getPapersForSubject(subject);
                totalRows += papers.length > 0 ? papers.length : 1;
            });
            
            // Add type row with rowspan
            tableHtml += `
                    <tr>
                        <td rowspan="${totalRows}" class="type-row">${type.charAt(0).toUpperCase() + type.slice(1)}</td>
                        ${generateSubjectRowsWithPapers(subjectsOfType, true, false)}
                    </tr>
                `;

        });
        
        tableHtml += `
                </tbody>
            </table>
        `;
    }
    
    container.html(tableHtml);
}
// Generate division rows with all types
function generateDivisionRows(division, isFirstRow, isDivisionCase) {
    let html = '';
    let firstTypeProcessed = false;
    
    // Process each type in the division
    ['compulsory', 'additional', 'optional'].forEach(type => {
        const subjectsOfType = division[type];
        if (subjectsOfType.length === 0) return;
        
        // Calculate total rows needed for this type (including papers)
        let totalRows = 0;
        subjectsOfType.forEach(subject => {
            const papers = getPapersForSubject(subject);
            totalRows += papers.length > 0 ? papers.length : 1;
        });
        
        if (!firstTypeProcessed) {
            // First type in the division
            html += `
                <td rowspan="${totalRows}" class="type-row">${type.charAt(0).toUpperCase() + type.slice(1)}</td>
                ${generateSubjectRowsWithPapers(subjectsOfType, true, isDivisionCase)}
            `;
            firstTypeProcessed = true;
        } else {
            // Subsequent types in the division
            html += `
                <tr>
                    <td rowspan="${totalRows}" class="type-row">${type.charAt(0).toUpperCase() + type.slice(1)}</td>
                    ${generateSubjectRowsWithPapers(subjectsOfType, false, isDivisionCase)}
                </tr>
            `;
        }
    });
    
    return html;
}

// Generate subject rows with papers
function generateSubjectRowsWithPapers(subjects, isFirstRow, isDivisionCase) {
    let html = '';
    
    subjects.forEach((subject, subjectIndex) => {
        const papers = getPapersForSubject(subject);
        
        if (papers.length === 0) {
            // Subject without papers
            if (subjectIndex === 0 && isFirstRow) {
                html += `
                    <td class="subject-name-cell">${subject.name}</td>
                    <td></td>
                    <td>${subject.code || 'N/A'}</td>
                    <td>
                        <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                            ${subject.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                `;
            } else {
                html += `
                    <tr>
                        <td class="subject-name-cell">${subject.name}</td>
                        <td></td>
                        <td>${subject.code || 'N/A'}</td>
                        <td>
                            <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                                ${subject.is_active ? 'Active' : 'Inactive'}
                            </span>
                        </td>
                    </tr>
                `;
            }
        } else {
            // Subject with papers
            papers.forEach((paper, paperIndex) => {
                if (paperIndex === 0) {
                    // First paper row for this subject
                    if (subjectIndex === 0 && isFirstRow) {
                        html += `
                            <td rowspan="${papers.length}" class="subject-name-cell">${subject.name}</td>
                            <td>${paper.name}</td>
                            <td>${paper.code}</td>
                            <td>
                                <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                                    ${subject.is_active ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                        `;
                    } else {
                        html += `
                            <tr>
                                <td rowspan="${papers.length}" class="subject-name-cell">${subject.name}</td>
                                <td>${paper.name}</td>
                                <td>${paper.code}</td>
                                <td>
                                    <span class="subject-badge badge-${subject.is_active ? 'active' : 'inactive'}">
                                        ${subject.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    // Subsequent paper rows for this subject
                    if (isDivisionCase) {
                        // For division tables (6 columns)
                        html += `
                            <tr>
                                <td></td>
                                <td></td>
                                <td>${paper.name}</td>
                                <td>${paper.code}</td>
                                <td></td>
                            </tr>
                        `;
                    } else {
                        // For non-division tables (5 columns)
                        html += `
                            <tr>
                                <td></td>
                                <td>${paper.name}</td>
                                <td>${paper.code}</td>
                                <td></td>
                            </tr>
                        `;
                    }
                }
            });
        }
    });
    
    return html;
}
// Function to get papers for a subject based on backend data
function getPapersForSubject(subject) {
    console.log('Getting papers for subject:', subject);
    
    // Use actual papers from the subject object if available
    if (subject.papers && subject.papers.length > 0) {
        return subject.papers.map(paper => ({
            name: paper.name,
            code: paper.code
        }));
    }
    
    // Fallback to generating papers based on subject name
    const subjectsWithPapers = ['Bangla', 'English', 'Mathematics', 'Physics', 'Chemistry', 'Biology'];
    
    if (subjectsWithPapers.includes(subject.name)) {
        return [
            { name: 'First Paper', code: subject.code + '1' },
            { name: 'Second Paper', code: subject.code + '2' }
        ];
    }
    
    // Subjects without papers
    return [];
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