<!-- Edit Academic Section Modal -->
<div class="modal fade" id="editAcademicSectionModal" tabindex="-1" role="dialog" aria-labelledby="editAcademicSectionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header border-primary">
        <h5 class="modal-title text-primary font-weight-bold" id="editAcademicSectionModalLabel">Edit Academic Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="editAcademicSectionForm">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_institution_id">Select Institution</label>
            <select class="form-control" id="edit_institution_id" name="institution_id" required>
              <option value="" disabled selected>-- Select Institution --</option>
             
            </select>
            <span id="edit_institution_id_error" class="text-danger small"></span>
          </div>

          <div class="form-group">
            <label for="edit_section_type">Section Type</label>
            <select class="form-control" id="edit_section_type" name="section_type" required>
              <option value="" disabled selected>-- Select Section Type --</option>
              <option value="school">School</option>
              <option value="college">College</option>
            </select>
            <span id="edit_section_type_error" class="text-danger small"></span>
          </div>

          <div class="form-group">
            <label for="edit_approval_letter_no">Approval Letter No (optional)</label>
            <input type="text" class="form-control" id="edit_approval_letter_no" name="approval_letter_no" placeholder="Enter approval letter no">
          </div>

          <div class="form-group">
            <label for="edit_approval_date">Approval Date (optional)</label>
            <input type="date" class="form-control" id="edit_approval_date" name="approval_date">
          </div>

          <div class="form-group">
            <label for="edit_approval_stage">Approval Stage (optional)</label>
            <input type="text" class="form-control" id="edit_approval_stage" name="approval_stage" placeholder="Enter approval stage">
          </div>

          <div class="form-group">
            <label for="edit_level">Level (optional)</label>
            <input type="text" class="form-control" id="edit_level" name="level" placeholder="e.g. নিম্ন মাধ্যমিক, মাধ্যমিক, একাদশ">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Academic Section</button>
        </div>
      </form>

    </div>
  </div>
</div>
