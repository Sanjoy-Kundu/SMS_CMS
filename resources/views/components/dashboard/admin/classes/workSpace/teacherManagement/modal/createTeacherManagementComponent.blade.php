<style>
    .modal-body .form-select {
    min-height: 38px;   /* Bootstrap default height */
    font-size: 1rem;    /* readable font */
}
</style>

<!-- Modal -->
<div class="modal fade" id="addTeacherByClassModal" tabindex="-1" aria-labelledby="addTeacherByClassModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center w-100">
                <h5 class="modal-title" id="addTeacherByClassModalLabel">
                    Assign Subject Teacher – Class (<span class="assign_class_name">6</span>)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Hidden Class ID -->
            <input type="hidden" name="class_id" id="class_id" class="assignSubjectTeacherClassId">

            <div class="modal-body">
                {{-- choose teacher --}}
                <div class="mb-3">
                    <label for="teacherDropdownByClass" class="form-label">Select Teacher</label>
                    <select name="teacher_id" id="teacherDropdownByClass" class="form-control">
           
                    </select>
                </div>

                {{-- choose subject --}}
                  <div class="mb-3">
                    <label for="subjectDropdownByClass" class="form-label">Select Subject</label>
                    <select name="subject_id" id="subjectDropdownByClass" class="form-control">
                        <option value="">-- Select Subject --</option>
                    </select>
                  </div>

                {{-- choose subject --}}
                  <div class="mb-3">
                    <label for="subjectPaperDropdownByClass" class="form-label">Select Subject Paper</label>
                    <select name="paper_id" id="subjectPaperDropdownByClass" class="form-control">
                        <option value="">-- Select Subject --</option>
                    </select>
                  </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTeacherByClassBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fill modal with class info and load teachers
    async function fillUpClassBySubjectWithTeacher(classId) {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Something is wrong. Please login again');
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/class-model/lists', {}, {
                headers: { 'Authorization': 'Bearer ' + token }
            });

            if (response.data.status === 'success') {
                const classes = response.data.data;
                const selectedClass = classes.find(c => c.id === classId);

                if (selectedClass) {
                    document.querySelector('.assign_class_name').textContent = selectedClass.name.toUpperCase();
                    document.querySelector('.assignSubjectTeacherClassId').value = selectedClass.id;
                    await getAllTeacherLists(selectedClass.name);
                    await getAllSubjectLists(classId);
                }
            }
        } catch (error) {
            console.error('Error fetching class list:', error);
        }
    }

    // Load all teachers dynamically into dropdown
    async function getAllTeacherLists(className) {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Unauthorized Access');
            return;
        }

        try {
            const res = await axios.post('/all/teacher/lists', {}, {
                headers: { Authorization: 'Bearer ' + token }
            });

            if (res.data.status === 'success') {
                const teachers = res.data.allTeachers;
                const dropdown = document.getElementById('teacherDropdownByClass');

                // Clear previous options
                dropdown.innerHTML = `<option value="">Select Teacher for Class ${className}</option>`;

                // Append teachers
                teachers.forEach(teacher => {
                    const name = teacher.user?.name || 'N/A';
                    const option = document.createElement('option');
                    option.value = teacher.id;
                    option.text = name;
                    dropdown.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error fetching teachers:', error);
        }
    }


    // Load all subjects dynamically into dropdown
    async function getAllSubjectLists(classId) {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Something went wrong');
            window.location.href = '/admin/login';
            return;
        }

        try {
            const response = await axios.post('/subject/lists', {}, {
                headers: { 'Authorization': 'Bearer ' + token }
            });

            if (response.data.status === 'success') {
                // Filter subjects by classId
                const subjects = response.data.data.filter(subject => subject.class_id == classId);
                
                const subjectDropdown = document.getElementById('subjectDropdownByClass'); // make sure you have a dropdown
                if(subjectDropdown){
                    subjectDropdown.innerHTML = '<option value=""> --- Choose Your Subject --- </option>';
                    subjects.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.text = subject.name;
                        subjectDropdown.appendChild(option);
                    });
                }
                console.log('Subjects loaded:', subjects);
            }
        } catch (error) {
            console.error('Error fetching subjects:', error);
        }
    }



    const subjectDropdown = document.getElementById('subjectDropdownByClass');
    const paperDropdownWrapper = document.getElementById('subjectPaperDropdownByClass').closest('.mb-3'); // wrapper div
    const paperDropdown = document.getElementById('subjectPaperDropdownByClass');

    // By default hide paper dropdown
    paperDropdownWrapper.style.display = 'none';

    subjectDropdown.addEventListener('change', async function() {
        const subjectId = this.value;

        if(!subjectId){
            paperDropdownWrapper.style.display = 'none';
            paperDropdown.innerHTML = '<option value="">-- Select Paper --</option>';
            return;
        }

        const token = localStorage.getItem('token');
        if(!token) return;

        try {
            const response = await axios.post('/paper/list', 
                { subject_id: subjectId }, 
                { headers: { Authorization: 'Bearer ' + token } }
            );

            if(response.data.success && response.data.data.length > 0){
                const papers = response.data.data;
                paperDropdown.innerHTML = '<option value="">-- Select Paper --</option>';
                papers.forEach(paper => {
                    const option = document.createElement('option');
                    option.value = paper.id;
                    option.text = paper.name + (paper.code ? ` (${paper.code})` : '');
                    paperDropdown.appendChild(option);
                });
                paperDropdownWrapper.style.display = 'block'; // show dropdown if papers exist
            } else {
                paperDropdown.innerHTML = '<option value="">No papers found</option>';
                paperDropdownWrapper.style.display = 'none'; // hide if no papers
            }
        } catch(err){
            console.error('Error loading papers:', err);
            paperDropdown.innerHTML = '<option value="">Error loading papers</option>';
            paperDropdownWrapper.style.display = 'none';
        }
    });


</script>
