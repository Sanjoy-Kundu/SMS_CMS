<div class="modal fade" id="gradingEditScaleModal" tabindex="-1" role="dialog" aria-labelledby="gradingEditScaleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0 rounded-lg">

            <!-- Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="gradingEditScaleModalLabel">
                    <i class="fas fa-graduation-cap mr-2"></i> Update Grading Scale
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form -->
            <form id="gradingEditScaleForm">
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
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button class="btn btn-primary" onclick="updateGradingScale(event)">
                        <i class="fas fa-save"></i> Update Grading Scale
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // function fillGradingInfoDetails(id){
    //     console.log('Grading Detils By ID: ' + id);
    // }
    // Fill grading modal with data
async function fillGradingInfoDetails(id){
    let token = localStorage.getItem('token');
    if(!token){
        Swal.fire({icon:'error',title:'Unauthorized',text:'You are not logged in!'});
        return;
    }

    try{
        let res = await axios.post('/classes/grading/get-by-id',{id:id},{
            headers: { Authorization: `Bearer ${token}` }
        });

        if(res.data.status === 'success'){
            let g = res.data.data;
            $('#gradingEditScaleModal .grading_class_id').val(g.class_id);
            $('#gradingEditScaleModal #grade').val(g.grade);
            $('#gradingEditScaleModal #gpa').val(g.gpa);
            $('#gradingEditScaleModal #min_range').val(g.min_range);
            $('#gradingEditScaleModal #max_range').val(g.max_range);
            $('#gradingEditScaleModal').data('grading-id', g.id);
        } else {
            Swal.fire({icon:'error',title:'Error',text:res.data.message});
        }
    } catch(err){
        Swal.fire({icon:'error',title:'Error',text:'Failed to load grading details.'});
    }
}

// Update grading scale
async function updateGradingScale(e){
    e.preventDefault();
    let token = localStorage.getItem('token');
    if(!token){
        Swal.fire({icon:'error',title:'Unauthorized',text:'You are not logged in!'});
        return;
    }

    let modal = $('#gradingEditScaleModal');
    let id = modal.data('grading-id');

    if(!id){
        Swal.fire({icon:'error',title:'Error',text:'Grading ID is missing'});
        return;
    }

    let grade = modal.find('#grade').val();
    let gpa = modal.find('#gpa').val();
    let min_range = modal.find('#min_range').val();
    let max_range = modal.find('#max_range').val();

    try{
        let res = await axios.post('/classes/grading/update',{
            id, grade, gpa, min_range, max_range
        },{
            headers: { Authorization: `Bearer ${token}` }
        });

        if(res.data.status==='success'){
            Swal.fire({icon:'success',title:'Updated',text:res.data.message, timer:1500, showConfirmButton:false});
            modal.modal('hide');
            gradingListsByClass(); // Refresh table
        } else {
            Swal.fire({icon:'error',title:'Error',text:res.data.message});
        }
    } catch(err){
        Swal.fire({icon:'error',title:'Error',text:'Failed to update grading.'});
    }
}



</script>