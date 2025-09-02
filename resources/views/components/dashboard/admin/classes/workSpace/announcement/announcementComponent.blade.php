<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">

<div class="container-fluid">

    <!-- Class Workspace Heading -->
    <div class="mb-4">
        <input type="text" class="workPaceClassId" readonly>
        <h3 class="text-primary" style="text-transform: uppercase">
            Announcements Of Class <span class="text-danger">{{ $classId->name }}</span>
        </h3>
        <hr class="mb-4">
    </div>

    <!-- Create Announcement Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Create New Announcement</span>
            <i class="fas fa-bullhorn"></i>
        </div>
        <div class="card-body">
            <form id="announcementForm" onsubmit="createAnnouncement(event)" enctype="multipart/form-data">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Upcoming Math Exam">
                        <span class="text-danger error-message" data-field="title"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Priority</label>
                        <select name="priority" class="form-control">
                            <option value="">-- Select Priority --</option>
                            <option value="High">High</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="Low">Low</option>
                        </select>
                        <span class="text-danger error-message" data-field="priority"></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Description</label>
                    <textarea id="summernote" name="description" class="form-control"></textarea>
                    <span class="text-danger error-message" data-field="description"></span>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold">Audience</label>
                        <select name="audience" class="form-control">
                            <option value="">-- Select Audience --</option>
                            <option value="Students">Students</option>
                            <option value="Teachers">Teachers</option>
                            <option value="All">All</option>
                        </select>
                        <span class="text-danger error-message" data-field="audience"></span>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold">Category</label>
                        <select name="category" class="form-control">
                            <option value="">-- Select Category --</option>
                            <option value="Exam">Exam</option>
                            <option value="Event">Event</option>
                            <option value="Homework">Homework</option>
                            <option value="General" selected>General</option>
                        </select>
                        <span class="text-danger error-message" data-field="category"></span>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold">Recurring</label>
                        <select name="recurring" class="form-control">
                            <option value="">-- Select Recurring --</option>
                            <option value="None" selected>None</option>
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                        <span class="text-danger error-message" data-field="recurring"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Attachment</label>
                        <input type="file" name="attachment" class="form-control" id="attachmentInput">
                        <span class="text-danger error-message" data-field="attachment"></span>
                        <div id="attachmentPreview" class="mt-2"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Link (Optional)</label>
                        <input type="url" name="link" class="form-control" placeholder="https://example.com">
                        <span class="text-danger error-message" data-field="link"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Valid Until</label>
                        <input type="date" name="valid_until" class="form-control">
                        <span class="text-danger error-message" data-field="valid_until"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-danger error-message" data-field="is_active"></span>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-plus-circle"></i> Create Announcement
                </button>
            </form>
        </div>
    </div>

    <!-- List Announcements -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span>All Announcements</span>
            <i class="fas fa-list"></i>
        </div>
        <div class="card-body table-responsive">
            <table id="announcementsTable" class="table table-bordered table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Audience</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="announcementsTableBody">
                    <!-- Axios data load হবে -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Trash Announcements Card -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>Trashed Announcements</span>
            <i class="fas fa-trash-alt"></i>
        </div>
        <div class="card-body table-responsive">
            <table id="trashedAnnouncementsTable" class="table table-bordered table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Audience</th>
                        <th>Deleted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="trashedAnnouncementsTableBody">
                    <!-- Axios data load হবে -->
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        transition: 0.3s;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

 <script>
    $(document).ready(function() {
        // loadAnnouncements();
        // loadTrashedAnnouncements();
        $('#summernote').summernote({
            placeholder: 'Write announcement details here...',
            tabsize: 2,
            height: 150
        });
        //image pdf and docs preview
        document.getElementById("attachmentInput").addEventListener("change", function(e) {
            let file = e.target.files[0];
            let preview = document.getElementById("attachmentPreview");
            preview.innerHTML = "";

            if (file) {
                let fileType = file.type;

                if (fileType.startsWith("image/")) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML =
                            `<img src="${e.target.result}" class="img-fluid rounded" style="max-height:150px;">`;
                    }
                    reader.readAsDataURL(file);
                } else if (fileType === "application/pdf") {
                    preview.innerHTML =
                        `<i class="fas fa-file-pdf text-danger fa-2x"></i> ${file.name}`;
                } else if (fileType.includes("word") || fileType.includes("doc")) {
                    preview.innerHTML =
                        `<i class="fas fa-file-word text-primary fa-2x"></i> ${file.name}`;
                } else {
                    preview.innerHTML = `<i class="fas fa-file text-muted fa-2x"></i> ${file.name}`;
                }
            }
        });
    });

    let token = localStorage.getItem('token');
    let classId = {{ $classId->id }};
    document.querySelector('.workPaceClassId').value = classId;



    //load loadAnnouncements 
    loadAnnouncements();
    async function loadAnnouncements() {
        try {
            let res = await axios.post('/announcement/lists-by-class', {
                class_id: classId
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                let announcementLists = res.data.data;

                // পুরনো DataTable destroy
                if ($.fn.DataTable.isDataTable('#announcementsTable')) {
                    $('#announcementsTable').DataTable().clear().destroy();
                }

                // নতুন data insert
                let rows = "";
                if (announcementLists.length > 0) {
                    announcementLists.forEach((item, index) => {
                        rows += `
                        <tr>
                            <td>${index+1}</td>
                            <td>
                                <strong>${item.title}</strong><br>
                                <small class="text-muted">${item.description.substring(0, 50)}...</small>
                            </td>
                            <td><span class="badge badge-info">${item.category}</span></td>
                            <td><span class="badge badge-${item.priority === 'High' ? 'danger' : (item.priority === 'Medium' ? 'warning' : 'secondary')}">${item.priority}</span></td>
                            <td>${item.audience}</td>
                            <td>${item.valid_until ?? '-'}</td>
                            <td><span class="badge badge-${item.is_active ? 'success' : 'danger'}">${item.is_active ? 'Active' : 'Inactive'}</span></td>
                            <td>
                                <button class="btn btn-sm btn-info viewAnnouncement"  data-id="${item.id}"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning editAnnouncement" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger trashAnnouncement" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="8" class="text-center">No announcements found.</td></tr>`;
                }

                document.querySelector("#announcementsTableBody").innerHTML = rows;

                // DataTable initialize
                $('#announcementsTable').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 20, 50],
                    responsive: true,
                    autoWidth: false
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: res.data.message || "Failed to fetch announcements!"
                });
            }

            //trash announchment
            $(document).on('click', '.trashAnnouncement', async function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: "This announcement will be trash!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, trash it!'
                });

                if (result.isConfirmed) {
                    try {
                        let res = await axios.post('/announcement/trash', {
                            id: id
                        }, {
                            headers: {
                                Authorization: `Bearer ${token}`
                            }
                        });

                        if (res.data.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                res.data.message,
                                'success'
                            );
                            await loadAnnouncements(); // Refresh table
                            await loadTrashedAnnouncements(); // Refresh trashed table
                        } else {
                            Swal.fire(
                                'Failed!',
                                res.data.message || 'Could not delete.',
                                'error'
                            );
                        }

                    } catch (err) {
                        console.error("🚨 Trash Error:", err);
                        Swal.fire(
                            'Error!',
                            'Server error. Check console.',
                            'error'
                        );
                    }
                }
            });




        } catch (error) {
            console.error("🚨 Error fetching announcements:", error);

            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Could not load announcements. Check console for details.'
            });
        }
    }


    //Announchment Create 
    async function createAnnouncement(event) {
        event.preventDefault();

        let token = localStorage.getItem("token");
        if (!token) {
            Swal.fire({
                icon: 'warning',
                title: 'Unauthorized',
                text: 'Please login first!'
            });
            window.location.href = "/admin/login";
            return;
        }

        let form = event.target;
        let formData = new FormData(form);
        formData.append("class_id", classId);

        try {
            let res = await axios.post('/announcement/store', formData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "multipart/form-data"
                }
            });

            if (res.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                form.reset();
                $('#summernote').summernote('reset');
                loadAnnouncements();
            }

        } catch (error) {
            // 🔹 Emergency / Server error -> শুধু console এ log হবে
            console.error("🚨 Server Error:", error);

            if (error.response) {
                if (error.response.status === 422) {
                    // 🔹 Validation error
                    let errors = error.response.data.errors;
                    let errorHtml = "<ul>";
                    Object.keys(errors).forEach(key => {
                        errorHtml += `<li>${errors[key][0]}</li>`;
                    });
                    errorHtml += "</ul>";

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorHtml
                    });
                } else {
                    // 🔹 Server / Other error
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: "Something went wrong! Please check console."
                    });
                }
            } else {
                // 🔹 Axios বা Network Error
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Please check your internet connection.'
                });
            }
        }
    }




    // Load Trashed Announcements
    loadTrashedAnnouncements();
    async function loadTrashedAnnouncements() {
        try {
            let res = await axios.post('/announcement/trashed-lists', {
                class_id: classId
            }, {
                headers: { Authorization: `Bearer ${token}` }
            });

            if (res.data.status === 'success') {
                let list = res.data.data;

                // DataTable instance চেক
                if ($.fn.DataTable.isDataTable('#trashedAnnouncementsTable')) {
                    let table = $('#trashedAnnouncementsTable').DataTable();
                    table.clear(); // পুরনো ডাটা clear করো

                    // নতুন ডাটা যোগ করো
                    if (list.length > 0) {
                        list.forEach((item, index) => {
                            table.row.add([
                                index + 1,
                                `<strong>${item.title}</strong>`,
                                item.category,
                                item.priority,
                                item.audience,
                                item.deleted_at,
                                `
                                    <button class="btn btn-sm btn-success restoreAnnouncement" data-id="${item.id}">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                    <button class="btn btn-sm btn-danger permDeleteAnnouncement" data-id="${item.id}">
                                        <i class="fas fa-trash-alt"></i> Delete Permanently
                                    </button>
                                `
                            ]);
                        });
                    } else {
                        table.row.add([
                            '-', '-', '-', '-', '-', '-',
                            `<span class="text-muted">No trashed announcements found.</span>`
                        ]);
                    }

                    table.draw(); 
                } else {
                    
                    let rows = "";
                    if (list.length > 0) {
                        list.forEach((item, index) => {
                            rows += `
                                <tr>
                                    <td>${index+1}</td>
                                    <td><strong>${item.title}</strong></td>
                                    <td>${item.category}</td>
                                    <td>${item.priority}</td>
                                    <td>${item.audience}</td>
                                    <td>${item.deleted_at}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success restoreAnnouncement" data-id="${item.id}">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                        <button class="btn btn-sm btn-danger permDeleteAnnouncement" data-id="${item.id}">
                                            <i class="fas fa-trash-alt"></i> Delete Permanently
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    document.querySelector("#trashedAnnouncementsTableBody").innerHTML = rows;

                    $('#trashedAnnouncementsTable').DataTable({
                        pageLength: 5,
                        lengthMenu: [5,10,20,50],
                        responsive: true,
                        autoWidth: false
                    });
                }
            }
        } catch (err) {
            console.error("🚨 Error fetching trashed announcements:", err);
            Swal.fire('Error', 'Could not load trashed announcements.', 'error');
        }
    }


    // Restore Announcement
    $(document).on('click', '.restoreAnnouncement', async function(){
        const id = $(this).data('id');
        const { isConfirmed } = await Swal.fire({
            title: 'Restore Announcement?',
            text: "This announcement will be restored.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Restore'
        });

        if(!isConfirmed) return;

        try {
            let res = await axios.post('/announcement/restore', {id}, {
                headers: { Authorization: `Bearer ${token}` }
            });
            if(res.data.status === 'success'){
                Swal.fire('Restored!', res.data.message, 'success');
                loadTrashedAnnouncements();
                loadAnnouncements(); // Optional: refresh main list
            } else {
                Swal.fire('Failed!', res.data.message || 'Could not restore.', 'error');
            }
        } catch(err){
            console.error(err);
            Swal.fire('Error!', 'Server error. Check console.', 'error');
        }
    });

    // Permanent Delete
    $(document).on('click', '.permDeleteAnnouncement', async function(){
        const id = $(this).data('id');
        const { isConfirmed } = await Swal.fire({
            title: 'Delete Permanently?',
            text: "This cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete Permanently'
        });

        if(!isConfirmed) return;

        try {
            let res = await axios.post('/announcement/delete-permanent', {id}, {
                headers: { Authorization: `Bearer ${token}` }
            });
            if(res.data.status === 'success'){
                Swal.fire('Deleted!', res.data.message, 'success');
                loadTrashedAnnouncements();
            } else {
                Swal.fire('Failed!', res.data.message || 'Could not delete.', 'error');
            }
        } catch(err){
            console.error(err);
            Swal.fire('Error!', 'Server error. Check console.', 'error');
        }
    });

</script>


{{-- <script>
    $(document).ready(function() {
        let token = localStorage.getItem('token');
        let classId = {{ $classId->id }};
        $('.workPaceClassId').val(classId);

        // Initialize Summernote
        $('#summernote').summernote({
            placeholder: 'Write announcement details here...',
            tabsize: 2,
            height: 150
        });

        // Preview attachment
        $('#attachmentInput').on('change', function(e) {
            let file = e.target.files[0];
            let preview = $("#attachmentPreview");
            preview.html('');

            if (!file) return;

            const fileType = file.type;
            if (fileType.startsWith('image/')) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    preview.html(
                        `<img src="${e.target.result}" class="img-fluid rounded" style="max-height:150px;">`
                        );
                }
                reader.readAsDataURL(file);
            } else if (fileType === 'application/pdf') {
                preview.html(`<i class="fas fa-file-pdf text-danger fa-2x"></i> ${file.name}`);
            } else if (fileType.includes('word') || fileType.includes('doc')) {
                preview.html(`<i class="fas fa-file-word text-primary fa-2x"></i> ${file.name}`);
            } else {
                preview.html(`<i class="fas fa-file text-muted fa-2x"></i> ${file.name}`);
            }
        });

        // Load both tables initially
        // loadAnnouncements();
        // loadTrashedAnnouncements();
    });

    // ===================== Load Announcements =====================
    loadAnnouncements();
    async function loadAnnouncements() {
        let token = localStorage.getItem('token');
        let classId = $('.workPaceClassId').val();
        if (!token && !classId) {
            alert('Please login first. Unauthorized Access');
            window.location.href = '/admin/login'
        }

        try {
            let res = await axios.post('/announcement/lists-by-class', {
                class_id: classId
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            if (res.data.status !== 'success') {
                Swal.fire('Error', 'Failed to fetch announcements', 'error');
                return;
            }

            let list = res.data.data;
            let rows = '';

            if (list.length > 0) {
                list.forEach((item, index) => {
                    rows += `<tr>
                    <td>${index+1}</td>
                    <td><strong>${item.title}</strong><br><small class="text-muted">${item.description.substring(0,50)}...</small></td>
                    <td><span class="badge badge-info">${item.category}</span></td>
                    <td><span class="badge badge-${item.priority === 'High' ? 'danger' : (item.priority === 'Medium' ? 'warning' : 'secondary')}">${item.priority}</span></td>
                    <td>${item.audience}</td>
                    <td>${item.valid_until ?? '-'}</td>
                    <td><span class="badge badge-${item.is_active ? 'success' : 'danger'}">${item.is_active ? 'Active' : 'Inactive'}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info viewAnnouncement"  data-id="${item.id}"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-sm btn-warning editAnnouncement" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger trashAnnouncement" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
                });
            } else {
                rows = `<tr><td colspan="8" class="text-center">No announcements found.</td></tr>`;
            }

            $('#announcementsTableBody').html(rows);

            // Destroy previous DataTable if exists
            if ($.fn.DataTable.isDataTable('#announcementsTable')) {
                $('#announcementsTable').DataTable().clear().destroy();
            }

            $('#announcementsTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50],
                responsive: true,
                autoWidth: false
            });
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Could not load announcements', 'error');
        }
    }

    // ===================== Load Trashed Announcements =====================
    loadTrashedAnnouncements();
    async function loadTrashedAnnouncements() {
        let token = localStorage.getItem('token');
        let classId = $('.workPaceClassId').val();
        try {
            let res = await axios.post('/announcement/trashed-lists', {
                class_id: classId
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            if (res.data.status !== 'success') {
                Swal.fire('Error', 'Failed to fetch trashed announcements', 'error');
                return;
            }

            let list = res.data.data;
            let rows = '';

            if (list.length > 0) {
                list.forEach((item, index) => {
                    rows += `<tr>
                    <td>${index+1}</td>
                    <td><strong>${item.title ?? '-'}</strong></td>
                    <td>${item.category ?? '-'}</td>
                    <td>${item.priority ?? '-'}</td>
                    <td>${item.audience ?? '-'}</td>
                    <td>${item.deleted_at ?? '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-success restoreAnnouncement" data-id="${item.id}">
                            <i class="fas fa-undo"></i> Restore
                        </button>
                        <button class="btn btn-sm btn-danger permDeleteAnnouncement" data-id="${item.id}">
                            <i class="fas fa-trash-alt"></i> Delete Permanently
                        </button>
                    </td>
                </tr>`;
                });
            } else {
                rows = `<tr><td colspan="7" class="text-center">No trashed announcements found.</td></tr>`;
            }

            $('#trashedAnnouncementsTableBody').html(rows);

            if ($.fn.DataTable.isDataTable('#trashedAnnouncementsTable')) {
                $('#trashedAnnouncementsTable').DataTable().clear().destroy();
            }

            $('#trashedAnnouncementsTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50],
                responsive: true,
                autoWidth: false
            });
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Could not load trashed announcements', 'error');
        }
    }


    // ===================== Create Announcement =====================
    async function createAnnouncement(event) {
        let token = localStorage.getItem('token');
        let classId = $('.workPaceClassId').val();
        if (!token && !classId) {
            return window.location.href = '/admin/login';
        }
        event.preventDefault();
        let form = event.target;
        let formData = new FormData(form);
        formData.append('class_id', classId);

        try {
            let res = await axios.post('/announcement/store', formData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "multipart/form-data"
                }
            });

            if (res.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Created!',
                    text: res.data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                form.reset();
                $('#summernote').summernote('reset');
                loadAnnouncements();
            }
        } catch (err) {
            console.error(err);
            if (err.response?.status === 422) {
                let errors = err.response.data.errors;
                let html = "<ul>";
                Object.keys(errors).forEach(key => {
                    html += `<li>${errors[key][0]}</li>`;
                });
                html += "</ul>";
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html
                });
            } else {
                Swal.fire('Error', 'Something went wrong. Check console', 'error');
            }
        }
    }

    // ===================== Trash Announcement =====================
    $(document).on('click', '.trashAnnouncement', async function() {
        const id = $(this).data('id');
        let token = localStorage.getItem('token');
        let classId = $('.workPaceClassId').val();
        if (!token && !classId) {
            return window.location.href = '/admin/login';
        }

        const {
            isConfirmed
        } = await Swal.fire({
            title: 'Trash Announcement?',
            text: "This announcement will be moved to trash.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Trash it'
        });

        if (!isConfirmed) return;

        try {
            let res = await axios.post('/announcement/trash', {
                id
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            if (res.data.status === 'success') {
                Swal.fire('Trashed!', res.data.message, 'success');
                loadAnnouncements();
                loadTrashedAnnouncements();
            } else {
                Swal.fire('Failed!', res.data.message || 'Could not trash.', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Server error. Check console.', 'error');
        }
    });

    // ===================== Restore Announcement =====================
    $(document).on('click', '.restoreAnnouncement', async function() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Please login first.');
            window.location.href = '/admin/login';
        }
        const id = $(this).data('id');
        const {
            isConfirmed
        } = await Swal.fire({
            title: 'Restore Announcement?',
            text: "This announcement will be restored.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Restore'
        });

        if (!isConfirmed) return;

        try {
            let res = await axios.post('/announcement/restore', {
                id
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            if (res.data.status === 'success') {
                Swal.fire('Restored!', res.data.message, 'success');
                loadTrashedAnnouncements();
                loadAnnouncements();
            } else {
                Swal.fire('Failed!', res.data.message || 'Could not restore.', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Server error. Check console.', 'error');
        }
    });

    // ===================== Permanent Delete =====================
    $(document).on('click', '.permDeleteAnnouncement', async function() {
        const id = $(this).data('id');
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Please login first.');
            window.location.href = '/admin/login';
        }
        const {
            isConfirmed
        } = await Swal.fire({
            title: 'Delete Permanently?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete'
        });

        if (!isConfirmed) return;

        try {
            let res = await axios.post('/announcement/delete-permanent', {
                id
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            if (res.data.status === 'success') {
                Swal.fire('Deleted!', res.data.message, 'success');
                loadTrashedAnnouncements();
            } else {
                Swal.fire('Failed!', res.data.message || 'Could not delete.', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Server error. Check console.', 'error');
        }
    });
</script> --}}
