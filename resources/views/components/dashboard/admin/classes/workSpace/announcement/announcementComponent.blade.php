<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">

<div class="container-fluid">

    <!-- Class Workspace Heading -->
    <div class="mb-4">
        <input type="text" class="workPaceClassId" readonly hidden>
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
                    <input type="text" name="title" class="form-control" placeholder="e.g. Upcoming Math Exam" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Priority</label>
                    <select name="priority" class="form-control" required>
                        <option value="High">High</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="Low">Low</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Description</label>
                <textarea id="summernote" name="description" class="form-control" placeholder="Write announcement details here..."></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label font-weight-bold">Audience</label>
                    <select name="audience" class="form-control" required>
                        <option value="Students">Students</option>
                        <option value="Teachers">Teachers</option>
                        <option value="All">All</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label font-weight-bold">Category</label>
                    <select name="category" class="form-control" required>
                        <option value="Exam">Exam</option>
                        <option value="Event">Event</option>
                        <option value="Homework">Homework</option>
                        <option value="General" selected>General</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label font-weight-bold">Recurring</label>
                    <select name="recurring" class="form-control" required>
                        <option value="None" selected>None</option>
                        <option value="Daily">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Attachment</label>
                    <input type="file" name="attachment" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Link (Optional)</label>
                    <input type="url" name="link" class="form-control" placeholder="https://example.com">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Valid Until</label>
                    <input type="date" name="valid_until" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Status</label>
                    <select name="is_active" class="form-control" required>
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
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
                    </tr>
                </thead>
                <tbody>
                    <!-- Axios data load হবে -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    transition: 0.3s;
}
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    $(document).ready(function () {
        $('#summernote').summernote({
            placeholder: 'Write announcement details here...',
            tabsize: 2,
            height: 150
        });
    });

    let token = localStorage.getItem('token');
    let classId = {{ $classId->id }};
    document.querySelector('.workPaceClassId').value = classId;

    // 🔹 Fetch Announcements List
    // function loadAnnouncements() {
    //     axios.get(`/api/classes/${classId}/announcements`, {
    //         headers: { Authorization: `Bearer ${token}` }
    //     })
    //     .then(res => {
    //         let rows = "";
    //         res.data.forEach((item, index) => {
    //             rows += `
    //                 <tr>
    //                     <td>${index+1}</td>
    //                     <td>
    //                         <strong>${item.title}</strong>
    //                         <p class="small text-muted">${item.description}</p>
    //                     </td>
    //                     <td><span class="badge badge-info">${item.category}</span></td>
    //                     <td><span class="badge badge-${item.priority === 'High' ? 'danger' : (item.priority === 'Medium' ? 'warning' : 'secondary')}">${item.priority}</span></td>
    //                     <td>${item.audience}</td>
    //                     <td>${item.valid_until ?? '-'}</td>
    //                     <td><span class="badge badge-${item.is_active ? 'success' : 'danger'}">${item.is_active ? 'Active' : 'Inactive'}</span></td>
    //                 </tr>`;
    //         });
    //         document.querySelector("#announcementsTable tbody").innerHTML = rows;
    //     })
    //     .catch(err => console.error(err));
    // }

    // 🔹 Create Announcement
    // document.getElementById("announcementForm").addEventListener("submit", function(e){
    //     e.preventDefault();
    //     let formData = new FormData(this);
    //     formData.append("class_id", classId);

    //     axios.post(`/announcement/store`, formData, {
    //         headers: { Authorization: `Bearer ${token}` }
    //     })
    //     .then(res => {
    //         alert("Announcement Created!");
    //         loadAnnouncements();
    //         this.reset();
    //         $('#summernote').summernote('reset');
    //     })
    //     .catch(err => {
    //         console.error(err);
    //         alert("Something went wrong!");
    //     });
    // });

function createAnnouncement(event){
    event.preventDefault();

    let token = localStorage.getItem("token");
    if(!token){
        alert("Please login first!");
        window.location.href = "/admin/login";
        return;
    }

    let form = event.target; // 🔹 এখানে form element
    let formData = new FormData(form);
    formData.append("class_id", classId);

    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    // এখানে axios POST call করতে পারো
    /*
    axios.post('/announcement/store', formData, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        alert("Announcement Created!");
        form.reset();
        $('#summernote').summernote('reset');
        loadAnnouncements(); // যদি list refresh করতে চাও
    })
    .catch(err => console.error(err));
    */
}


    // Load initial data
    //loadAnnouncements();
</script>
