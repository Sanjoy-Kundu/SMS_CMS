<!-- Page Background -->
<style>
    body {
        background-color: #e9ecef;
        /* govt style halka grey-green tone */
    }
</style>

<!-- Grading Scale Modal -->
<div class="modal fade" id="gradingScaleModal" tabindex="-1" role="dialog" aria-labelledby="gradingScaleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0 rounded-lg">

            <!-- Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="gradingScaleModalLabel">
                    <i class="fas fa-graduation-cap mr-2"></i> Add Grading Scale
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form -->
            <form id="gradingScaleForm">
                <div class="modal-body">
                    <input type="hidden" name="class_id" class="form-control grading_class_id">
                    <div class="row">
                        <!-- Grade -->
                        <div class="form-group col-md-3">
                            <label for="grade" class="font-weight-bold">Grade</label>
                            <input type="text" class="form-control" name="grade" id="grade"
                                placeholder="e.g. A+, A">
                            <span class="grade_error text-danger"></span>
                        </div>

                        <!-- GPA -->
                        <div class="form-group col-md-3">
                            <label for="gpa" class="font-weight-bold">GPA</label>
                            <input type="number" step="0.01" class="form-control" name="gpa" id="gpa"
                                placeholder="e.g. 5.00">
                            <span class="gpa_error text-danger"></span>
                        </div>

                        <!-- Min Range -->
                        <div class="form-group col-md-3">
                            <label for="min_range" class="font-weight-bold">Min Range</label>
                            <input type="number" class="form-control" name="min_range" id="min_range"
                                placeholder="e.g. 80">
                            <span class="min_range_error text-danger"></span>
                        </div>

                        <!-- Max Range -->
                        <div class="form-group col-md-3">
                            <label for="max_range" class="font-weight-bold">Max Range</label>
                            <input type="number" class="form-control" name="max_range" id="max_range"
                                placeholder="e.g. 100">
                            <span class="max_range_error text-danger"></span>
                        </div>
                    </div>

                    <!-- Table: Live Data -->
                    <hr>
                    <h6 class="text-success font-weight-bold mb-3">Grading Scales (Live)</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="gradingScaleTable">
                            <thead class="thead-success">
                                <tr>
                                    <th>Grade</th>
                                    <th>GPA</th>
                                    <th>Min Range</th>
                                    <th>Max Range</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be appended dynamically -->
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button class="btn btn-primary" onclick="onSubmitGradingScale(event)">
                        <i class="fas fa-save"></i> Submit Grading Scale
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ========================
    // Fetch grading list
    // ========================
    async function gradingListsByClass() {
        let token = localStorage.getItem('token');
        if (!token) {
            Swal.fire({
                icon: 'error',
                title: 'Unauthorized',
                text: 'You are not logged in!'
            });
            return;
        }

        let class_id = document.querySelector('.grading_class_id').value;
        try {
            let res = await axios.post('/class/grading/lists/by-class', {
                class_id: class_id
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            if (res.data.status === 'success') {
                let data = res.data.data;
                let tbody = document.querySelector("#gradingScaleTable tbody");
                tbody.innerHTML = "";

                data.forEach(element => {
                    let row = `
                        <tr>
                            <td>${element.grade}</td>
                            <td>${element.gpa}</td>
                            <td>${element.min_range}</td>
                            <td>${element.max_range}</td>
                            <td>
                                <button class="btn btn-sm btn-warning editGradingScale" data-id="${element.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger deleteGradingScale" data-id="${element.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML("beforeend", row);
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to load grading scales.'
            });
        }
    }

    // ========================
    // Fillup grading scale by class
    // ========================
    function fillupGradingScaleByClass(id) {
        document.querySelector('.grading_class_id').value = id;
        gradingListsByClass();
    }

    // ========================
    // Submit grading scale
    // ========================
    async function onSubmitGradingScale(event) {
        event.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            Swal.fire({
                icon: 'error',
                title: 'Unauthorized',
                text: 'You are not logged in!'
            });
            return;
        }

        // clear errors
        document.querySelector('.grade_error').textContent = '';
        document.querySelector('.gpa_error').textContent = '';
        document.querySelector('.min_range_error').textContent = '';
        document.querySelector('.max_range_error').textContent = '';

        // inputs
        let class_id = document.querySelector('.grading_class_id').value;
        let grade = document.querySelector('#grade').value;
        let gpa = document.querySelector('#gpa').value;
        let min_range = document.querySelector('#min_range').value;
        let max_range = document.querySelector('#max_range').value;

        let isError = false;
        if (grade === '') {
            document.querySelector('.grade_error').textContent = 'Grade is required';
            isError = true;
        }
        if (gpa === '') {
            document.querySelector('.gpa_error').textContent = 'GPA is required';
            isError = true;
        }
        if (min_range === '') {
            document.querySelector('.min_range_error').textContent = 'Minimum range is required';
            isError = true;
        }
        if (max_range === '') {
            document.querySelector('.max_range_error').textContent = 'Maximum range is required';
            isError = true;
        }
        if (isError) return;

        let data = {
            class_id,
            grade,
            gpa,
            min_range,
            max_range
        };

        try {
            let response = await axios.post('/classes/grading', data, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: response.data.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                // ✅ Reset + Refresh
                document.querySelector("#gradingScaleForm").reset();
                document.querySelector("#grade").focus();
                gradingListsByClass();
            }

        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                if (errors.grade) document.querySelector('.grade_error').textContent = errors.grade[0];
                if (errors.gpa) document.querySelector('.gpa_error').textContent = errors.gpa[0];
                if (errors.min_range) document.querySelector('.min_range_error').textContent = errors.min_range[0];
                if (errors.max_range) document.querySelector('.max_range_error').textContent = errors.max_range[0];

                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error',
                    text: 'Please fix the highlighted fields'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.response?.data?.message || 'Something went wrong!'
                });
            }
        }
    }

    // ========================
    // Delete grading scale (Event Delegation)
    // ========================
    $(document).on('click', '.deleteGradingScale', async function(e) {
        e.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            Swal.fire({
                icon: 'error',
                title: 'Unauthorized',
                text: 'You are not logged in!'
            });
            return;
        }
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This grading scale will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    let res = await axios.post('/classes/grading/delete-by-id', {
                        id: id
                    }, {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });

                    if (res.data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        await gradingListsByClass();
                    } else {
                        console.error('Delete Error:', res.data.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: res.data.message
                        });
                    }

                } catch (error) {
                    console.error('Delete Exception:', error.response?.data || error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.response?.data?.message ||
                            'Failed to delete grading scale.'
                    });
                }

            }
        });
    });



    // =========================
    // edit Grading Scale (Event Delegation)
    //==========================
    $(document).on('click', '.editGradingScale', async function (e) {
        e.preventDefault();
        let token = localStorage.getItem('token');
        if (!token) {
            Swal.fire({
                icon: 'error',
                title: 'Unauthorized',
                text: 'You are not logged in!'
            });
            return;
        }
        let id = $(this).data('id');
        if(id){
            await fillGradingInfoDetails(id);
           $('#gradingEditScaleModal').modal('show'); 
        }

    })
</script>
