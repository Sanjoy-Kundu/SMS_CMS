 <style>
     /* Loader overlay just for the form card */
     .loader-overlay {
         display: none;
         /* hidden initially */
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(255, 255, 255, 0.7);
         /* semi-transparent white */
         z-index: 10;
         /* above card content */
         border-radius: 0.35rem;
         /* match card border radius */
     }

     /* Loader bar animation */
     .loader-bar {
         height: 4px;
         width: 100%;
         --c: no-repeat linear-gradient(#6100ee 0 0);
         background: var(--c), var(--c), #d7b8fc;
         background-size: 60% 100%;
         animation: l16 3s infinite;
         position: absolute;
         top: 0;
         left: 0;
     }

     @keyframes l16 {
         0% {
             background-position: -150% 0, -150% 0
         }

         66% {
             background-position: 250% 0, -150% 0
         }

         100% {
             background-position: 250% 0, 250% 0
         }
     }
 </style>

 <div class="container-fluid mt-4">

     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800">Editor Profile</h1>

     <div class="row">

         <div class="col-xl-5 col-md-6 mb-4">
             <div class="card border-left-primary shadow h-100 position-relative">
                 <!-- Loader overlay -->
                 <div class="loader-overlay" id="editorLoader">
                     <div class="loader-bar"></div>
                 </div>
                 <div class="card-header bg-white py-3">
                     <h5 class="m-0 text-primary font-weight-bold">Create A New Teacher</h5>
                 </div>
                 <div class="card-body">
                     <form id="EditorTeacherForm">
                         <div class="form-group" hidden>
                             <label for="name">Institution Id</label>
                             <input type="hidden" id="editor_teacher_institution_id" name="institution_id">
                             <span id="editor_teacher_institution_id_error" class="text-danger small"></span>
                         </div>
                         <div class="form-group">
                             <label for="editor_teacher_name">Teacher Name</label>
                             <input type="text" class="form-control" id="editor_teacher_name" name="name"
                                 placeholder="Enter teacher name">
                             <span id="editor_teacher_name_error" class="text-danger small"></span>
                         </div>

                         <div class="form-group">
                             <label for="editor_teacher_email">Teacher Email</label>
                             <input type="email" class="form-control" id="editor_teacher_email" name="email"
                                 placeholder="Enter teacher Email">
                             <span id="editor_teacher_email_error" class="text-danger small"></span>
                         </div>

                         <button type="submit" class="btn btn-primary btn-block" id="submitBtn"
                             onclick="teacherCreateByEditor(event)">Add
                             teacher</button>
                     </form>
                 </div>
             </div>
         </div>






         <!-- Profile Edit Form -->
         <!-- Right Column: teacher Tables -->
         <div class="col-xl-7 col-md-6 mb-4">

             <!-- Active teachers -->
             <div class="card border-left-success shadow mb-4 position-relative">
                 <!-- Loader overlay -->
                 <div class="loader-overlay" id="editorTableLoader">
                     <div class="loader-bar"></div>
                 </div>
                 <div class="card-header bg-white py-3">
                     <h5 class="m-0 text-success font-weight-bold">Teachers List</h5>
                     <p class="m-0 text-info font-weight-bold">Total Teachers:
                         <span class="editorTotalTeachersCount">0</span>
                     </p>
                 </div>
                 <div class="card-body">
                     <div class="table-responsive">
                         <table class="table table-bordered table-hover table-sm" id="editor_teachers_table">
                             <thead class="thead-light">
                                 <tr>
                                     <th>#</th>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody id="editor_teachers_table_body"></tbody>
                         </table>
                     </div>
                 </div>
             </div>

             <!-- Trash teachers -->
             <div class="card border-left-danger shadow mb-4 position-relative">
                   <!-- Loader overlay -->
                         <div class="loader-overlay" id="editorTrashTableLoader">
                             <div class="loader-bar"></div>
                         </div>
                 <div class="card-header bg-white py-3">
                     <h5 class="m-0 text-danger font-weight-bold">Teachers Trash List</h5>
                     <p class="m-0 text-info font-weight-bold">Total Teachers:
                         <span class="editorTotalTrashTeachersCount">0</span>
                     </p>
                 </div>
                 <div class="card-body">
                     <div class="table-responsive">
                         <table class="table table-bordered table-hover table-sm" id="editor_trash_teachers_table">
                             <thead class="thead-light">
                                 <tr>
                                     <th>#</th>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Added By</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody id="editor_trash_teachers_table_body"></tbody>
                         </table>
                     </div>
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
         let token = localStorage.getItem('token');

         if (!token) {
             alert('Unauthorized Access');
         } else {
             loadInstitutions();
             getEditorSelfTeacherLists();
             getEditorTrashTeacherLists();
         }

         // Load Institutions
         async function loadInstitutions() {
             let token = localStorage.getItem('token');
             if (!token) {
                 alert('Unauthorized Access');
                 return;
             }
             try {
                 const response = await axios.post('/institution/details/for/admin/editor', {}, {
                     headers: {
                         'Authorization': 'Bearer ' + token
                     }
                 });

                 if (response.data.status === 'success') {
                     const institutions = response.data.data;
                     if (institutions.length > 0) {
                         document.getElementById('editor_teacher_institution_id').value = institutions[0].id;
                     } else {
                         alert('No institution found');
                     }
                 }
             } catch (error) {
                 console.error('Error fetching institutions:', error);
             }
         }

         // Teacher Create by Editor
         async function teacherCreateByEditor(event) {
             event.preventDefault();

             let token = localStorage.getItem('token');
             if (!token) {
                 alert('Unauthorized Access');
                 return;
             }

             // Clear previous errors
             document.getElementById('editor_teacher_name_error').innerText = '';
             document.getElementById('editor_teacher_email_error').innerText = '';
             document.getElementById('editor_teacher_institution_id_error').innerText = '';

             let name = document.getElementById('editor_teacher_name').value.trim();
             let email = document.getElementById('editor_teacher_email').value.trim();
             let institution_id = document.getElementById('editor_teacher_institution_id').value.trim();

             let isError = false;
             if (!name) {
                 document.getElementById('editor_teacher_name_error').innerText = 'Name is required';
                 isError = true;
             }
             if (!email) {
                 document.getElementById('editor_teacher_email_error').innerText = 'Email is required';
                 isError = true;
             }
             if (!institution_id) {
                 document.getElementById('editor_teacher_institution_id_error').innerText = 'Institution is required';
                 isError = true;
             }
             if (isError) return;

             let data = {
                 name,
                 email,
                 institution_id
             };

             document.getElementById('editorLoader').style.display = 'block';
             const formElements = document.getElementById('EditorTeacherForm').elements;
             for (let el of formElements) el.disabled = true;

             try {
                 const res = await axios.post('/teacher/store', data, {
                     headers: {
                         'Authorization': `Bearer ${token}`
                     }
                 });

                 if (res.data.status === 'success') {
                     await getEditorSelfTeacherLists();
                     Swal.fire('Success', res.data.message, 'success');
                     document.getElementById('EditorTeacherForm').reset();
                 }
             } catch (error) {
                 if (error.response) {
                     if (error.response.status === 422) {
                         const errors = error.response.data.errors || {};
                         document.getElementById('editor_teacher_name_error').innerText = errors.name ? errors.name[0] :
                             '';
                         document.getElementById('editor_teacher_email_error').innerText = errors.email ? errors.email[
                             0] : '';
                         document.getElementById('editor_teacher_institution_id_error').innerText = errors
                             .institution_id ? errors.institution_id[0] : '';
                     } else {
                         Swal.fire('Error', 'Something went wrong', 'error');
                     }
                 } else {
                     Swal.fire('Error', 'Network or server error', 'error');
                 }
             } finally {
                 document.getElementById('editorLoader').style.display = 'none';
                 for (let el of formElements) el.disabled = false;
             }
         }

         // Active Teacher List
         async function getEditorSelfTeacherLists() {
             try {
                 const res = await axios.post('/all/teacher/lists', {}, {
                     headers: {
                         Authorization: 'Bearer ' + token
                     }
                 });

                 if (res.data.status === 'success') {
                     const teachers = res.data.editorTeachers;
                     document.querySelector('.editorTotalTeachersCount').innerText = teachers.length;

                     if ($.fn.DataTable.isDataTable('#editor_teachers_table')) {
                         $('#editor_teachers_table').DataTable().destroy();
                     }
                     $('#editor_teachers_table_body').html('');

                     teachers.forEach((teacher, index) => {
                         const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${teacher.user.name}</td>
                            <td>${teacher.user.email || ''}</td>
                            <td>
                                <button class="btn btn-sm btn-primary EditorEditTeacher" data-id="${teacher.id}">Edit</button>
                                <button class="btn btn-sm btn-danger editorTrashTeacher" data-id="${teacher.id}">Trash</button>
                            </td>
                        </tr>`;
                         $('#editor_teachers_table_body').append(row);
                     });

                     $('#editor_teachers_table').DataTable({
                         "pageLength": 10,
                         "lengthChange": false,
                         "ordering": true,
                         "info": true,
                         "autoWidth": false
                     });
                 }

                 // Trash Teacher
                 $(document).off('click', '.editorTrashTeacher').on('click', '.editorTrashTeacher', async function() {
                     const id = $(this).data('id');
                     const confirm = await Swal.fire({
                         title: 'Are you sure?',
                         text: "This teacher will be trashed!",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonText: 'Yes, trash'
                     });

                     if (!confirm.isConfirmed) return;
                        // Show loader on table
                        $('#editorTableLoader').show();

                     try {
                         const res = await axios.post('/admin/teacher/trash-by-id', {
                             id
                         }, {
                             headers: {
                                 Authorization: 'Bearer ' + token
                             }
                         });

                         if (res.data.status === 'success') {
                             Swal.fire('Trashed!', res.data.message, 'success');
                             await getEditorSelfTeacherLists();
                             await getEditorTrashTeacherLists();
                         } else {
                             Swal.fire('Error', res.data.message || 'Trash failed', 'error');
                         }
                     } catch {
                         Swal.fire('Error', 'Server or network error', 'error');
                     }
                 });

             } catch (error) {
                 console.error('Error fetching teachers:', error);
             }finally{
                $('#editorTableLoader').hide();
            }
         }

         // Trash Teacher List
         async function getEditorTrashTeacherLists() {
             try {
                 const res = await axios.post('/all/teacher/trash/lists', {}, {
                     headers: {
                         Authorization: 'Bearer ' + token
                     }
                 });

                 if (res.data.status === 'success') {
                     let trashTeacherLists = res.data.EditortrashedTeachers;
                     document.querySelector('.editorTotalTrashTeachersCount').innerText = trashTeacherLists.length;

                     if ($.fn.DataTable.isDataTable('#editor_trash_teachers_table')) {
                         $('#editor_trash_teachers_table').DataTable().destroy();
                     }
                     $('#editor_trash_teachers_table_body').html('');

                     trashTeacherLists.forEach((teacher, index) => {
                         const addedBy = teacher.added_by.role === 'editor' ? 'Editor' : 'Admin';
                         const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${teacher.user.name}</td>
                            <td>${teacher.user.email || ''}</td>
                            <td>${teacher.added_by.name} (${addedBy})</td>
                            <td>
                                <button class="btn btn-sm btn-info EditorRestoreTeacher" data-id="${teacher.id}">Restore</button>
                                <button class="btn btn-sm btn-danger EditorPermanentDeleteTeacher" data-id="${teacher.id}">Delete</button>
                            </td>
                        </tr>`;
                         $('#editor_trash_teachers_table_body').append(row);
                     });

                     $('#editor_trash_teachers_table').DataTable({
                         "pageLength": 10,
                         "lengthChange": false,
                         "ordering": true,
                         "info": true,
                         "autoWidth": false
                     });
                 }

                 // Restore Teacher
                 $(document).off('click', '.EditorRestoreTeacher').on('click', '.EditorRestoreTeacher',async function() {
                     const id = $(this).data('id');
                     const confirm = await Swal.fire({
                         title: 'Restore Teacher?',
                         text: "This teacher will be restored to active list.",
                         icon: 'question',
                         showCancelButton: true,
                         confirmButtonText: 'Yes, Restore'
                     });
                     if (!confirm.isConfirmed) return;
                       $('#editorTrashTableLoader').show();

                     try {
                         const res = await axios.post('/admin/teacher/restore-by-id', {
                             id
                         }, {
                             headers: {
                                 Authorization: 'Bearer ' + token
                             }
                         });
                         if (res.data.status === 'success') {
                             Swal.fire('Restored!', res.data.message, 'success');
                             await getEditorTrashTeacherLists();
                             await getEditorSelfTeacherLists();
                         } else {
                             Swal.fire('Error', res.data.message || 'Restore failed', 'error');
                         }
                     } catch {
                         Swal.fire('Error', 'Server or network error', 'error');
                     }finally{
                        $('#editorTrashTableLoader').hide();
                     }
                 });

                 // Permanent Delete
                 $(document).off('click', '.EditorPermanentDeleteTeacher').on('click', '.EditorPermanentDeleteTeacher',
                     async function() {
                         const id = $(this).data('id');
                         const confirm = await Swal.fire({
                            title: '⚠️ Are you sure?',
                            text: "This teacher will be permanently deleted!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Delete Permanently',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true, // confirm & cancel position swap
                            buttonsStyling: true,
                            customClass: {
                                confirmButton: 'btn btn-danger',   // লাল button
                                cancelButton: 'btn btn-secondary'  // ধূসর button
                            }
                        });
                         if (!confirm.isConfirmed) return;
                         $('#editorTrashTableLoader').show();

                         try {
                             const res = await axios.post('/admin/teacher/delete-by-id', {
                                 id
                             }, {
                                 headers: {
                                     Authorization: 'Bearer ' + token
                                 }
                             });
                             if (res.data.status === 'success') {
                                 Swal.fire('Deleted!', res.data.message, 'success');
                                 await getEditorTrashTeacherLists();
                             } else {
                                 Swal.fire('Error', res.data.message || 'Delete failed', 'error');
                             }
                         } catch {
                             Swal.fire('Error', 'Server or network error', 'error');
                         }
                     });

             } catch (error) {
                 console.error('Error fetching trash teachers:', error);
             }finally{
                $('#editorTrashTableLoader').hide();
             }
         }
     </script>
