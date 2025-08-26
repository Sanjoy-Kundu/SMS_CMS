<!-- Designation Modal -->
<div class="modal fade" id="controlPanelTeacherDesignationsModal" tabindex="-1" role="dialog" aria-labelledby="controlPanelTeacherDesignationsModallLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold" id="controlPanelTeacherDesignationsModalLabel">
                   + Add New Designation
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body position-relative">
                <div class="row">
                    <!-- Left Column: Create Designation Form -->
                    <div class="col-md-4">
                        <form id="designationCreateForm">
                            <input type="hidden" name="institution_id" id="institution_id">
                            <div class="form-group">
                                <label for="title">Designation Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Headmaster, Assistant Teacher">
                                <span class="title_error text-danger"></span>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm mt-2" onclick="createDesignation(event)">Add Designation</button>
                        </form>

                        <!-- Optional Trash List -->
                        {{-- <div class="mt-4">
                            <h6 class="text-danger font-weight-bold">Deleted Designations</h6>
                            <ul class="list-group" id="deletedDesignationsList">
                                <!-- Deleted items will appear here -->
                            </ul>
                        </div> --}}
                    </div>

                    <!-- Right Column: Designation List Table -->
                    <div class="col-md-8 position-relative">
                        <!-- Loader -->
                        <div class="table-loader-overlay" id="designationTableLoader" style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:5;">
                            <div class="loader-bar"></div>
                        </div>

                        <!-- Total Designations -->
                        <p class="m-0 text-info font-weight-bold mb-2">
                            Total Designations: <span class="totalDesignationsCount">0</span>
                        </p>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="designation_control_panel_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="designation_control_panel_table_body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
function createDesignation(event){
    event.preventDefault();

    // Clear previous error
    document.querySelector('.title_error').textContent = '';

    let title = document.getElementById('title').value.trim();
    let isError = false;

    if(!title){
        document.querySelector('.title_error').textContent = 'Title is required';
        isError = true;
    }

    if(isError) return;

    // Proceed with form submission (AJAX or normal)
    //console.log("Form valid, submit title:", title);
}
</script>
