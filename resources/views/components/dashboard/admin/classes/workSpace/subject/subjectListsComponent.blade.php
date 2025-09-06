<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject and Papers List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
{{-- <style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container-fluid {
        padding: 20px;
    }
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background: #fff;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }
    .card-header {
        background: linear-gradient(135deg, #0062ff, #00c6ff);
        color: #fff;
        font-weight: 600;
        font-size: 1.2rem;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        letter-spacing: 0.5px;
    }
    .divider {
        border-top: 3px solid #0062ff;
        margin: 20px 0;
        border-radius: 2px;
    }
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0 6px;
    }
    .table thead th {
        background-color: #f1f3f6;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 14px 12px;
        border: none;
        letter-spacing: 0.3px;
        color: #495057;
    }
    .table tbody tr {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        border-top: none;
        font-size: 0.95rem;
        color: #333;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #fafbfc;
    }
    .table-hover tbody tr:hover {
        background-color: #eef7ff !important;
        transform: scale(1.01);
        transition: 0.2s;
    }
    .badge {
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 500;
        border-radius: 30px;
    }
    .badge.bg-primary {
        background-color: #0069d9 !important;
    }
    .badge.bg-warning {
        background-color: #ffb700 !important;
        color: #212529 !important;
    }
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    .badge.bg-danger {
        background-color: #dc3545 !important;
    }
</style> --}}

</head>
<body>
<div class="container-fluid mt-4">
    <!-- Heading -->
    <div class="mb-4">
        <h3 class="text-primary text-uppercase">
            Subject of Class <span class="text-danger">{{ $classId->name }}</span>
            <input type="text" name="class_id" value="{{ $classId->id }}" class="admin_subject_list_view_class_id" readonly hidden>
        </h3>
        <hr>
    </div>

    <!-- Card with Table -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list mr-2"></i> Subjects and Papers List</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="subjectsPapersTable" class="table table-striped table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Sl No</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Code</th>
                            <th scope="col">Type</th>
                            {{-- <th scope="col">Status</th> --}}
                            <th scope="col">Paper Name</th>
                            <th scope="col">Paper Code</th>
                        </tr>
                    </thead>
                    <tbody id="subjectsPapersTableBody">
                        <!-- Data will load dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let token = localStorage.getItem('token');
        let classId = document.querySelector('.admin_subject_list_view_class_id').value;

        if (!token || !classId) {
            Swal.fire({
                icon: 'warning',
                title: 'Unauthorized',
                text: 'Please login first.',
                confirmButtonText: 'Go to Login'
            }).then(() => {
                window.location.href = '/admin/login';
            });
            //return;
        }

        // Initialize DataTable
        $(document).ready(function() {
            $('#subjectsPapersTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50],
                responsive: true,
                autoWidth: false,
                ordering: true,
                searching: true
            });

            loadSubjectDetailsByClass(classId);
        });

        // Function to load subject details
        async function loadSubjectDetailsByClass(classId) {
            try {
                const response = await axios.post('/subject/get-subject-details', {
                    class_id: classId
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.data.status === 'success') {
                    displaySubjectsAndPapers(response.data.data);
                } else {
                    displayError('No data found for this class');
                }
            } catch (error) {
                console.error('Error fetching subject details:', error);
                displayError('Failed to load subject details: ' + (error.response?.data?.message || error.message));
            }
        }

        // Function to display subjects and papers in a single table with rowspan
        function displaySubjectsAndPapers(subjects) {
            const tbody = document.getElementById('subjectsPapersTableBody');
            tbody.innerHTML = ''; // Clear existing content

            if (subjects.length === 0) {
                displayError('No subjects found.');
                return;
            }

            let serialNo = 1;
            subjects.forEach(subject => {
                const papers = subject.papers && subject.papers.length > 0 ? subject.papers : [{ name: '-', code: '-' }];
                const rowspan = papers.length;

                papers.forEach((paper, index) => {
                    const row = document.createElement('tr');
                    if (index === 0) {
                        // First row for the subject, include subject details with rowspan
                        row.innerHTML = `
                            <td rowspan="${rowspan}">${serialNo}</td>
                            <td rowspan="${rowspan}">${subject.name}</td>
                            <td rowspan="${rowspan}">${subject.code || '-'}</td>
                            <td rowspan="${rowspan}">
                                <span class="badge ${subject.type === 'compulsory' ? 'bg-primary' : 'bg-warning'}">
                                    ${subject.type.charAt(0).toUpperCase() + subject.type.slice(1)}
                                </span>
                            </td>
                 
                            <td>${paper.name}</td>
                            <td>${paper.code || '-'}</td>
                        `;
                    } else {
                        // Subsequent rows for additional papers
                        row.innerHTML = `
                            <td>${paper.name}</td>
                            <td>${paper.code || '-'}</td>
                        `;
                    }
                    tbody.appendChild(row);
                });
                serialNo++;
            });
        }

        // Function to display error messages with colspan
        function displayError(message) {
            const tbody = document.getElementById('subjectsPapersTableBody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">${message}</td>
                </tr>
            `;
        }
    </script>
</body>
</html>