<!-- Teachers List Modal -->
<div class="modal fade" id="controlPanelTeachersListModal" tabindex="-1" role="dialog" aria-labelledby="controlPanelTeachersListModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold" id="controlPanelTeachersListModalLabel">
                    Teachers Lists
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body position-relative">
                <p class="m-0 text-info font-weight-bold mb-3">
                    Total Teachers: <span class="totalTeachersCount">0</span>
                </p>

                <!-- Loader -->
                <div class="table-loader-overlay" id="tableLoader"
                    style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:5;">
                    <div class="loader-bar"></div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm" id="teacher_control_panel_table">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Added By</th>
                                <th>Designation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="teacher_control_panel_table_body"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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




        //all teacher lists admin and editor
    async function controlPanelAllTeacherLists() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert('Unauthorized Access');
            return;
        }
        try {
            const res = await axios.post('/all/teacher/lists', {}, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                const teachers = res.data.allTeachers;
                //console.log(teachers);
                //console.log(teachers);
                document.querySelector('.totalTeachersCount').innerText = teachers.length;

                // Destroy old DataTable if exists
                if ($.fn.DataTable.isDataTable('#teacher_control_panel_table')) {
                    $('#teacher_control_panel_table').DataTable().destroy();
                }

                // Clear table body
                $('#teacher_control_panel_table_body').html('');

                // Append rows
                teachers.forEach((teacher, index) => {
                    //const designation = teacher.designation.title ? teacher.designation.title : 'N/A';
                    const designation = teacher.designation?.title || 'N/A';
                    const addedBy = teacher.added_by.role === 'editor' ? 'Editor' : 'Admin';
                    const addedName = teacher.added_by.name?teacher.added_by.name:'N/A';
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                        <td>${teacher.user && teacher.user.name ? teacher.user.name : 'N/A'}</td>
                        <td>${teacher.user && teacher.user.email ? teacher.user.email : 'N/A'}</td>
                        <td>${addedName} (${addedBy})</td>
                        <td>${designation}</td>
                            <td>
                                <button class="btn btn-sm btn-primary viewControlPanelTeacher" data-email="${teacher.user.email}">View</button>
                                <button class="btn btn-sm btn-info addTeacherDesignation" data-name="${teacher.user.name}" data-email="${teacher.user.email}" data-id="${teacher.id}" data-designation_id="${teacher.designation_id ?? ''}">Add Designation</button>
                            </td>
                        </tr>
                    `;
                    $('#teacher_control_panel_table_body').append(row);
                });

                // View  handlers
                $(document).on('click', '.viewControlPanelTeacher', async function() {
                    const teacherEmail = $(this).data('email');
                    //console.log('Edit teacher:', teacherEmail);
                    await controlPanelTeacherDetailsCVFormat(teacherEmail);
                    $('#controlPanelTeacherViewCvFormatModal').modal('show');
                });

                // designation  handlers
                $(document).on('click', '.addTeacherDesignation', async function() {
                const teacherEmail = $(this).data('email');
                const teacherId = $(this).data('id');
                const teacherName = $(this).data('name');
                const designation_id = $(this).data('designation_id');

                //console.log('Edit teacher:', teacherEmail, teacherId, teacherName);

                await setTeacherDesignation(teacherId, teacherName, teacherEmail,designation_id);
                $('#controlPanelTeacherDesignationModal').modal('show');
             });


                // Initialize DataTable
                $('#teacher_control_panel_table').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }
        } catch (error) {
            console.error('Error fetching teachers:', error);
        }
    }
</script>



