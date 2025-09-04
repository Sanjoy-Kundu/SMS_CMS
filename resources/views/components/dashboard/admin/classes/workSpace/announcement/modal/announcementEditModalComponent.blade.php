<!-- Announcement Edit Modal -->
<div class="modal fade" id="announcementEditModal" tabindex="-1" role="dialog" aria-labelledby="announcementEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="announcementEditModalLabel">
                    <i class="fas fa-bullhorn"></i> Update Announcement
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="announcementEditForm" onsubmit="updateAnnouncement(event)" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="announcementId">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Title</label>
                            <input type="text" name="title" id="editTitle" class="form-control"
                                placeholder="e.g. Upcoming Math Exam">
                            <span class="text-danger error-message" data-field="title"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Priority</label>
                            <select name="priority" id="editPriority" class="form-control">
                                <option value="">-- Select Priority --</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                            <span class="text-danger error-message" data-field="priority"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Description</label>
                        <textarea id="editSummernote" name="description" class="form-control"></textarea>
                        <span class="text-danger error-message" data-field="description"></span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Audience</label>
                            <select name="audience" id="editAudience" class="form-control">
                                <option value="">-- Select Audience --</option>
                                <option value="Students">Students</option>
                                <option value="Teachers">Teachers</option>
                                <option value="All">All</option>
                            </select>
                            <span class="text-danger error-message" data-field="audience"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Category</label>
                            <select name="category" id="editCategory" class="form-control">
                                <option value="">-- Select Category --</option>
                                <option value="Exam">Exam</option>
                                <option value="Event">Event</option>
                                <option value="Homework">Homework</option>
                                <option value="General">General</option>
                            </select>
                            <span class="text-danger error-message" data-field="category"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Recurring</label>
                            <select name="recurring" id="editRecurring" class="form-control">
                                <option value="">-- Select Recurring --</option>
                                <option value="None">None</option>
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
                            <input type="file" name="attachment" id="editAttachmentInput" class="form-control">
                            <span class="text-danger error-message" data-field="attachment"></span>
                            <div id="editAttachmentPreview" class="mt-2"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Link (Optional)</label>
                            <input type="url" name="link" id="editLink" class="form-control"
                                placeholder="https://example.com">
                            <span class="text-danger error-message" data-field="link"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Valid Until</label>
                            <input type="date" name="valid_until" id="editValidUntil" class="form-control">
                            <span class="text-danger error-message" data-field="valid_until"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Status</label>
                            <select name="is_active" id="editIsActive" class="form-control">
                                <option value="">-- Select Status --</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger error-message" data-field="is_active"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save"></i> Update Announcement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://unpkg.com/mammoth@1.4.2/mammoth.browser.min.js"></script>

<script>
    let previousFileUrl = null;

    async function announcementEditDetails(id) {
        let token = localStorage.getItem('token');
        if (!token || !id) {
            Swal.fire('Error', 'Invalid Request', 'error');
            return;
        }

        try {
            let res = await axios.post('/announcement/view', {
                id
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            if (res.data.status !== 'success') {
                Swal.fire('Error', res.data.message || 'Could not fetch announcement.', 'error');
                return;
            }

            if (res.data.status === 'success') {
                let data = res.data.data;

                // Populate form fields
                document.querySelector('#announcementId').value = data.id;
                document.querySelector('#editTitle').value = data.title ? data.title : '';
                document.querySelector('#editPriority').value = data.priority || '';
                document.querySelector('#editAudience').value = data.audience || '';
                document.querySelector('#editCategory').value = data.category || '';
                document.querySelector('#editRecurring').value = data.recurring || '';
                document.querySelector('#editLink').value = data.link || '';
                document.querySelector('#editValidUntil').value = data.valid_until ? data.valid_until.split(' ')[
                    0] : '';
                document.querySelector('#editIsActive').value = data.is_active.toString();

                // Initialize Summernote with description
                $('#editSummernote').summernote('code', data.description || '');

                // Attachment preview
                let attachmentHtml = '';
                if (data.attachment) {
                    let fileUrl = `${window.location.origin}/${data.attachment}`;
                    let fileExt = data.attachment.split('.').pop().toLowerCase();

                    if (fileExt === 'pdf') {
                        attachmentHtml = `
            <div class="mt-3">
              <strong>Current Attachment:</strong>
              <embed src="${fileUrl}" type="application/pdf" width="100%" height="400px" />
              <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                <i class="fas fa-download"></i> Download PDF
              </a></p>
            </div>`;
                    } else if (['jpg', 'jpeg', 'png'].includes(fileExt)) {
                        attachmentHtml = `
            <div class="mt-3">
              <strong>Current Attachment:</strong><br>
              <img src="${fileUrl}" class="img-fluid rounded shadow-sm mt-2" alt="Attachment" />
              <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                <i class="fas fa-download"></i> Download Image
              </a></p>
            </div>`;
                    } else if (['doc', 'docx'].includes(fileExt)) {
                        attachmentHtml = `
            <div class="mt-3">
              <strong>Current Attachment:</strong>
              <p><i class="fas fa-file-word"></i> ${data.attachment.split('/').pop()} (Word file)</p>
              <p>
                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-success mt-2">
                  <i class="fas fa-download"></i> Download Word File
                </a>
                <a href="https://docs.google.com/viewer?url=${encodeURIComponent(fileUrl)}" target="_blank" class="btn btn-sm btn-outline-info mt-2">
                  <i class="fas fa-eye"></i> Preview with Google Docs
                </a>
              </p>
            </div>`;
                    } else {
                        attachmentHtml = `
            <div class="mt-3">
              <strong>Current Attachment:</strong>
              <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download"></i> Download File
              </a></p>
            </div>`;
                    }
                } else {
                    attachmentHtml = `<em>No attachment</em>`;
                }
                document.querySelector('#editAttachmentPreview').innerHTML = attachmentHtml;

                // Show the modal
                $('#announcementEditModal').modal('show');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Something went wrong while fetching announcement.', 'error');
        }

        // Add event listener for real-time attachment preview
        document.querySelector('#editAttachmentInput').removeEventListener('change', handleAttachmentPreview);
        document.querySelector('#editAttachmentInput').addEventListener('change', handleAttachmentPreview);

        function handleAttachmentPreview(event) {
            const file = event.target.files[0];
            const previewDiv = document.querySelector('#editAttachmentPreview');
            let previewHtml = '';

            if (previousFileUrl) {
                URL.revokeObjectURL(previousFileUrl);
            }

            if (file) {
                const fileExt = file.name.split('.').pop().toLowerCase();
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];

                if (!allowedExtensions.includes(fileExt)) {
                    Swal.fire('Error', 'Only JPG, PNG, PDF, or Word files are allowed.', 'error');
                    event.target.value = '';
                    previewHtml = `<em>No attachment selected</em>`;
                    previewDiv.innerHTML = previewHtml;
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire('Error', 'File size exceeds 5MB limit.', 'error');
                    event.target.value = '';
                    previewHtml = `<em>No attachment selected</em>`;
                    previewDiv.innerHTML = previewHtml;
                    return;
                }

                const fileUrl = URL.createObjectURL(file);
                previousFileUrl = fileUrl;

                if (['jpg', 'jpeg', 'png'].includes(fileExt)) {
                    previewHtml = `
          <div class="mt-3">
            <strong>New Attachment Preview:</strong><br>
            <img src="${fileUrl}" class="img-fluid rounded shadow-sm mt-2" alt="New Attachment" />
          </div>`;
                } else if (fileExt === 'pdf') {
                    previewHtml = `
          <div class="mt-3">
            <strong>New Attachment Preview:</strong>
            <embed src="${fileUrl}" type="application/pdf" width="100%" height="400px" />
          </div>`;
                } else if (['doc', 'docx'].includes(fileExt)) {
                    mammoth.convertToHtml({
                            arrayBuffer: file.arrayBuffer()
                        })
                        .then(result => {
                            previewHtml = `
              <div class="mt-3">
                <strong>New Attachment Preview:</strong>
                <div class="docx-preview" style="border: 1px solid #ccc; padding: 10px; max-height: 400px; overflow-y: auto;">
                  ${result.value}
                </div>
              </div>`;
                            previewDiv.innerHTML = previewHtml;
                        })
                        .catch(err => {
                            previewHtml = `
              <div class="mt-3">
                <strong>New Attachment Preview:</strong>
                <p><i class="fas fa-file-word"></i> ${file.name} (Word file selected, preview failed)</p>
              </div>`;
                            previewDiv.innerHTML = previewHtml;
                        });
                    return; // অ্যাসিঙ্ক প্রিভিউর জন্য রিটার্ন করো
                }
            } else {
                previewHtml = `<em>No attachment selected</em>`;
            }

            previewDiv.innerHTML = previewHtml;
        }

        // মডাল ক্লোজ করার সময় ক্লিনআপ
        $('#announcementEditModal').on('hidden.bs.modal', function() {
            document.querySelector('#announcementEditForm').reset();
            $('#editSummernote').summernote('reset');
            document.querySelector('#editAttachmentPreview').innerHTML = `<em>No attachment</em>`;
            if (previousFileUrl) {
                URL.revokeObjectURL(previousFileUrl);
                previousFileUrl = null;
            }
        });
    }

    async function updateAnnouncement(event) {
        event.preventDefault();
        const submitButton = document.querySelector('#announcementEditForm button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        // Client-side validation
        const id = document.querySelector('#announcementId').value;
        const title = document.querySelector('#editTitle').value.trim();
        const priority = document.querySelector('#editPriority').value;
        const description = $('#editSummernote').summernote('code').trim();
        const audience = document.querySelector('#editAudience').value;
        const category = document.querySelector('#editCategory').value;
        const recurring = document.querySelector('#editRecurring').value;
        const validUntil = document.querySelector('#editValidUntil').value;
        const isActive = document.querySelector('#editIsActive').value;
        const link = document.querySelector('#editLink').value;
        const attachment = document.querySelector('#editAttachmentInput').files[0];

        // Check required fields
        if (!id) {
            Swal.fire('Error', 'অ্যানাউন্সমেন্ট আইডি প্রয়োজন।', 'error');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save"></i> Update Announcement';
            return;
        }
        if (!title || !priority || !description || !audience || !category || !recurring || !validUntil || !
            isActive) {
            Swal.fire('Error', 'সব প্রয়োজনীয় ফিল্ড পূরণ করুন।', 'error');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save"></i> Update Announcement';
            return;
        }

        // URL validation
        if (link && !/^(https?:\/\/)/i.test(link)) {
            Swal.fire('Error', 'দয়া করে একটি বৈধ URL লিখুন (যেমন, https://example.com)।', 'error');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save"></i> Update Announcement';
            return;
        }

        // Attachment validation
        if (attachment) {
            const fileExt = attachment.name.split('.').pop().toLowerCase();
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            if (!allowedExtensions.includes(fileExt)) {
                Swal.fire('Error', 'শুধুমাত্র JPG, PNG, PDF, বা Word ফাইল আপলোড করুন।', 'error');
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save"></i> Update Announcement';
                return;
            }
            if (attachment.size > 5 * 1024 * 1024) {
                Swal.fire('Error', 'ফাইলের সাইজ ৫ মেগাবাইটের বেশি হতে পারবে না।', 'error');
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save"></i> Update Announcement';
                return;
            }
        }

        let token = localStorage.getItem('token');
        if (!token) {
            Swal.fire('Error', 'অথেনটিকেশন টোকেন নেই। দয়া করে লগইন করুন।', 'error');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save"></i> Update Announcement';
            return;
        }

        let form = document.querySelector('#announcementEditForm');
        let formData = new FormData(form);
        formData.append('id', id); // Ensure ID is included

        document.querySelectorAll('.error-message').forEach(el => el.innerHTML = '');

        try {
            let res = await axios.post('/announcement/update', formData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (res.data.status === 'success') {
                Swal.fire('Success', 'অ্যানাউন্সমেন্ট সফলভাবে আপডেট হয়েছে!', 'success');
                await loadAnnouncements();
                $('#announcementEditModal').modal('hide');
            } else {
                if (res.data.errors) {
                    // Create a summary message for all errors
                    let errorSummary = 'নিচের ফিল্ডগুলোতে সমস্যা আছে:<br><ul>';
                    const fieldNames = {
                        id: 'অ্যানাউন্সমেন্ট আইডি',
                        title: 'টাইটেল',
                        priority: 'প্রায়োরিটি',
                        description: 'বর্ণনা',
                        audience: 'অডিয়েন্স',
                        category: 'ক্যাটাগরি',
                        recurring: 'রিকারিং',
                        link: 'লিঙ্ক',
                        valid_until: 'বৈধতার সময়সীমা',
                        is_active: 'স্ট্যাটাস',
                        attachment: 'অ্যাটাচমেন্ট'
                    };

                    Object.keys(res.data.errors).forEach(field => {
                        let errorElement = document.querySelector(`.error-message[data-field="${field}"]`);
                        if (errorElement) {
                            errorElement.innerHTML = res.data.errors[field].join(', ');
                        }
                        // Add to summary
                        errorSummary +=
                            `<li><strong>${fieldNames[field] || field}:</strong> ${res.data.errors[field].join(', ')}</li>`;
                    });
                    errorSummary += '</ul>';

                    // Show summary in Swal alert
                    Swal.fire({
                        icon: 'error',
                        title: 'এরর',
                        html: errorSummary
                    });
                } else {
                    Swal.fire('Error', res.data.message || 'অ্যানাউন্সমেন্ট আপডেট করা যায়নি।', 'error');
                }
            }
        } catch (error) {
            console.error(error);
            let errorMessage = 'অ্যানাউন্সমেন্ট আপডেট করার সময় কিছু ভুল হয়েছে।';
            if (error.response) {
                if (error.response.status === 401) {
                    errorMessage = 'আপনার সেশন মেয়াদ শেষ হয়েছে। দয়া করে আবার লগইন করুন।';
                } else if (error.response.status === 413) {
                    errorMessage = 'ফাইলের সাইজ খুব বড়। দয়া করে ছোট ফাইল আপলোড করুন।';
                } else if (error.response.status === 422) {
                    errorMessage = error.response.data.message || 'ভ্যালিডেশন ফেইলড।';
                    if (error.response.data.errors) {
                        let errorSummary = 'নিচের ফিল্ডগুলোতে সমস্যা আছে:<br><ul>';
                        const fieldNames = {
                            id: 'অ্যানাউন্সমেন্ট আইডি',
                            title: 'টাইটেল',
                            priority: 'প্রায়োরিটি',
                            description: 'বর্ণনা',
                            audience: 'অডিয়েন্স',
                            category: 'ক্যাটাগরি',
                            recurring: 'রিকারিং',
                            link: 'লিঙ্ক',
                            valid_until: 'বৈধতার সময়সীমা',
                            is_active: 'স্ট্যাটাস',
                            attachment: 'অ্যাটাচমেন্ট'
                        };

                        Object.keys(error.response.data.errors).forEach(field => {
                            let errorElement = document.querySelector(
                                `.error-message[data-field="${field}"]`);
                            if (errorElement) {
                                errorElement.innerHTML = error.response.data.errors[field].join(', ');
                            }
                            errorSummary +=
                                `<li><strong>${fieldNames[field] || field}:</strong> ${error.response.data.errors[field].join(', ')}</li>`;
                        });
                        errorSummary += '</ul>';

                        Swal.fire({
                            icon: 'error',
                            title: 'এরর',
                            html: errorSummary
                        });
                        return; // Stop further processing
                    }
                } else if (error.response.status >= 500) {
                    errorMessage = 'সার্ভারে সমস্যা। দয়া করে পরে আবার চেষ্টা করুন।';
                }
            } else if (error.request) {
                errorMessage = 'নেটওয়ার্ক সমস্যা। দয়া করে ইন্টারনেট সংযোগ চেক করুন।';
            }
            Swal.fire('Error', errorMessage, 'error');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save"></i> Update Announcement';
        }
    }
</script>
