<div class="container-fluid mt-4">
    <!-- Heading -->
    <div class="mb-4">
        <h3 class="text-primary text-uppercase">
            Teacher of Class <span class="text-danger">{{ $classId->name }}</span>
            <input type="text" name="class_id" value="{{ $classId->id }}" class="admin_teacher_list_view_class_id"
                readonly hidden>
        </h3>
        <hr>
    </div>

    <!-- Card with Table -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i> Subject Teacher Lists</span>
            <!-- Add Class By Teacher Button -->
            <button class="btn btn-sm btn-primary addTeacherByClassBtn" data-id="{{ $classId->id }}">
                <i class="fas fa-plus me-1"></i> Add Teacher By Class
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="subjectsTeachersTable" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Sl No</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Code</th>
                            <th scope="col">Paper Name</th>
                            <th scope="col">Paper Code</th>
                            <th scope="col">Type</th>
                        </tr>
                    </thead>
                    <tbody id="subjectsTeachersTableBody">
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

    {{-- <script>
        let token = localStorage.getItem('token');
        let classId = document.querySelector('.admin_teacher_list_view_class_id').value;

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
            $('#subjectsTeachersTable').DataTable({
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
                    displaySubjectsAndTeachers(response.data.data);
                } else {
                    displayError('No data found for this class');
                }
            } catch (error) {
                console.error('Error fetching subject details:', error);
                displayError('Failed to load subject details: ' + (error.response?.data?.message || error.message));
            }
        }

        // Function to display subjects and Teachers in a single table with rowspan
        function displaySubjectsAndTeachers(subjects) {
            const tbody = document.getElementById('subjectsTeachersTableBody');
            tbody.innerHTML = ''; // Clear existing content

            if (subjects.length === 0) {
                displayError('No subjects found.');
                return;
            }

            let serialNo = 1;
            subjects.forEach(subject => {
                const Teachers = subject.Teachers && subject.Teachers.length > 0 ? subject.Teachers : [{ name: '-', code: '-' }];
                const rowspan = Teachers.length;

                Teachers.forEach((paper, index) => {
                    const row = document.createElement('tr');
                    if (index === 0) {
                        // First row for the subject, include subject details with rowspan
                        row.innerHTML = `
                            <td rowspan="${rowspan}">${serialNo}</td>
                            <td rowspan="${rowspan}">${subject.name}</td>
                            <td rowspan="${rowspan}">${subject.code || '-'}</td>
                            <td>${paper.name}</td>
                            <td>${paper.code || '-'}</td>
                            <td rowspan="${rowspan}">
                                <span class="badge ${subject.type === 'compulsory' ? 'bg-primary' : 'bg-warning'}">
                                    ${subject.type.charAt(0).toUpperCase() + subject.type.slice(1)}
                                </span>
                            </td>
                        `;
                    } else {
                        // Subsequent rows for additional Teachers
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
            const tbody = document.getElementById('subjectsTeachersTableBody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">${message}</td>
                </tr>
            `;
        }
    </script> --}}

    <script>
        $('.addTeacherByClassBtn').on('click', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            fillUpClassBySubjectWithTeacher(id);
            $('#addTeacherByClassModal').modal('show');
            //console.log('class id is',id);
        })
    </script>

 
