<div class="container-fluid">

    <!-- Class Workspace Heading -->
    <div class="mb-4">
        <input type="text" class="workPaceClassId" readonly hidden>
        <h3 class="text-primary" style="text-transform: uppercase">WELLCOME TO CLASS <span class="text-danger">{{ $classId->name }}</span> CLASSHUB</h3>
        <hr class="mb-4">
    </div>

    <!-- Work Space Cards -->
    <div class="row">

        <!-- Teachers Card -->
        <!-- Class Professionals Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 hover-shadow border-left-success">
                <div class="card-body d-flex flex-column justify-content-between py-4 px-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper-success me-3">
                            <i class="fas fa-users-cog fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-success">Class Professionals</h5>
                            <p class="text-muted small mb-0">
                                Manage class-wise teachers & their subjects
                            </p>
                        </div>
                    </div>
                    <button
                    class="btn btn-primary btn-sm mt-3 w-100 classWiseTeacherBtn" data-id="{{ $classId->id }}">
                    Manage Teachers
                </button>
                </div>
            </div>
        </div>


        <!-- Routine Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 hover-shadow border-left-success">
                <div class="card-body d-flex flex-column justify-content-between py-4 px-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper-success me-3">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-success">Routine</h5>
                            <p class="text-muted small mb-0">View & update class timetable</p>
                        </div>
                    </div>
                    <a href="/class/{{ $classId->id }}/routine" class="btn btn-success btn-sm mt-3 w-100">Manage</a>
                </div>
            </div>
        </div>

        <!-- Exams Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 hover-shadow border-left-warning">
                <div class="card-body d-flex flex-column justify-content-between py-4 px-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper-warning me-3">
                            <i class="fas fa-file-alt fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-warning">Exams</h5>
                            <p class="text-muted small mb-0">Setup & view exam schedule</p>
                        </div>
                    </div>
                    <a href="/class/{{ $classId->id }}/exams" class="btn btn-warning btn-sm mt-3 w-100">Manage</a>
                </div>
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 hover-shadow border-left-info">
                <div class="card-body d-flex flex-column justify-content-between py-4 px-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper-info me-3">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-info">Subjects</h5>
                            <p class="text-muted small mb-0">Subject lists fo Class {{ $classId->name }}</p>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-sm mt-3 w-100 classWiseSbujectListsBtn" data-id="{{ $classId->id }}">View Subject</button>
                </div>
            </div>
        </div>

        <!-- Grades Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 hover-shadow border-left-danger">
                <div class="card-body d-flex flex-column justify-content-between py-4 px-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper-danger me-3">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-danger">Grades</h5>
                            <p class="text-muted small mb-0">View & update grades / GPA</p>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-sm mt-3 w-100 graderManageBtn" data-id="{{ $classId->id }}">Manage</button>
                </div>
            </div>
        </div>

        <!-- Announcements Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 hover-shadow border-left-secondary">
                <div class="card-body d-flex flex-column justify-content-between py-4 px-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper-secondary me-3">
                            <i class="fas fa-bullhorn fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-secondary">Announcements</h5>
                            <p class="text-muted small mb-0">Class notices & messages</p>
                        </div>
                    </div>
                     <button class="btn btn-primary btn-sm mt-3 w-100 announcementManageBtn" data-id="{{ $classId->id }}">Manage</button>
                </div>
            </div>
        </div>

        <!-- Reports / Analytics Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 hover-shadow border-left-dark">
                <div class="card-body d-flex flex-column justify-content-between py-4 px-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper-dark me-3">
                            <i class="fas fa-chart-pie fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">Reports</h5>
                            <p class="text-muted small mb-0">Attendance, performance & exam stats</p>
                        </div>
                    </div>
                    <a href="/class/{{ $classId->id }}/reports" class="btn btn-dark btn-sm mt-3 w-100">View</a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    transition: 0.3s;
}

.icon-wrapper-primary,
.icon-wrapper-success,
.icon-wrapper-warning,
.icon-wrapper-info,
.icon-wrapper-danger,
.icon-wrapper-secondary,
.icon-wrapper-dark {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #f8f9fa;
}

.card-body h5 {
    line-height: 1.3;
    font-size: 1rem;
}

.card-body p {
    line-height: 1.5;
    font-size: 0.85rem;
}
</style>





<!-- JS: Token Check & Class ID -->
<script>
    let token = localStorage.getItem('token');
    if(!token){
       window.location.href = '/admin/login';
    }

    // Inject classId into input
    let classId = {{ $classId->id }};
    if(!classId){
        alert('Class Not Found! Something is wrong.');
        window.location.href = '/admin/login';
    }

    document.querySelector('.workPaceClassId').value = classId;


    //manage grade marks
    $('.graderManageBtn').on('click', async function(event){
        event.preventDefault();
        let id = $(this).data('id');
        await fillupGradingScaleByClass(id);
        $('#gradingScaleModal').modal('show');
        //console.log('class id is',id);
    })

    //manage announchment class
    $('.announcementManageBtn').on('click', async function(event){
        event.preventDefault();
        let id = $(this).data('id');
        window.location.href = `/announchment/${id}`;
        //console.log('class id is',id);
    })

    //manage announchment class
    $('.classWiseSbujectListsBtn').on('click', async function(event){
        event.preventDefault();
        let id = $(this).data('id');
        window.location.href = `/subjects/${id}`;
        //console.log('class id is',id);
    })

    //manage announchment class
    $('.classWiseTeacherBtn').on('click', async function(event){
        event.preventDefault();
        let id = $(this).data('id');
        window.location.href = `/teachers/${id}`;
        //console.log('class id is',id);
    })
</script>
