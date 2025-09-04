<!-- Announcement View Modal -->
<div class="modal fade" id="announcementViewModal" tabindex="-1" role="dialog" aria-labelledby="announcementViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="announcementViewModalLabel">
          <i class="fas fa-bullhorn"></i> Announcement Details
        </h5>
        <input type="text" class="form-control" id="announcementId" name="id" hidden>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <th style="width: 20%;">Title</th>
              <td id="viewTitle"></td>
            </tr>
            <tr>
              <th>Category</th>
              <td id="viewCategory"></td>
            </tr>
            <tr>
              <th>Priority</th>
              <td id="viewPriority"></td>
            </tr>
            <tr>
              <th>Audience</th>
              <td id="viewAudience"></td>
            </tr>
            <tr>
              <th>Valid Until</th>
              <td id="viewValidUntil"></td>
            </tr>
            <tr>
              <th>Description</th>
              <td id="viewDescription"></td>
            </tr>
            <tr>
              <th>Attachment</th>
              <td id="viewAttachment"></td>
            </tr>
            <tr>
              <th>Link</th>
              <td id="viewLink"></td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>


<script>
    async function announcementViewModal(id) {
        let token = localStorage.getItem('token');
        if(!token && !id){
            Swal.fire('Error', 'Invalid Request', 'error');
            return;
        }

        document.querySelector('#announcementId').value = id;

        try {
            let res = await axios.post('/announcement/view', {id}, {
                headers:{
                    Authorization: `Bearer ${token}` 
                }
            });

            if(res.data.status !== 'success'){
                Swal.fire('Error', res.data.message || 'Could not fetch announcement.', 'error');
                return;
            }

            if(res.data.status === 'success'){
                let data = res.data.data;

                // Title
                document.querySelector('#viewTitle').innerHTML = data.title;

                // Category & Priority (badge style priority)
                document.querySelector('#viewCategory').innerHTML = data.category;
                let priorityBadge = `<span class="badge badge-${data.priority === 'High' ? 'danger' : (data.priority === 'Medium' ? 'warning' : 'secondary')}">${data.priority}</span>`;
                document.querySelector('#viewPriority').innerHTML = priorityBadge;

                // Audience & Valid Until
                document.querySelector('#viewAudience').innerHTML = data.audience ?? '-';
                document.querySelector('#viewValidUntil').innerHTML = data.valid_until ?? '-';

                // Description (with Summernote formatting intact)
                document.querySelector('#viewDescription').innerHTML = data.description ?? '-';
                document.querySelector('#viewLink').innerHTML = data.link ?? '-';

                // Attachment preview
                let attachmentHtml = '';
                if(data.attachment){
                    let fileUrl = `${window.location.origin}/${data.attachment}`;
                    let fileExt = data.attachment.split('.').pop().toLowerCase();

                    if(fileExt === 'pdf'){
                        attachmentHtml = `
                            <div class="mt-3">
                                <strong>Attachment:</strong>
                                <embed src="${fileUrl}" type="application/pdf" width="100%" height="400px" />
                                <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-download"></i> Download PDF
                                </a></p>
                            </div>`;
                    } 
                    else if(['jpg','jpeg','png'].includes(fileExt)){
                        attachmentHtml = `
                            <div class="mt-3">
                                <strong>Attachment:</strong><br>
                                <img src="${fileUrl}" class="img-fluid rounded shadow-sm mt-2" alt="Attachment" />
                                <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-download"></i> Download Image
                                </a></p>
                            </div>`;
                    } 
                    else if(['doc','docx'].includes(fileExt)){
                        attachmentHtml = `
                            <div class="mt-3">
                                <strong>Attachment:</strong>
                                <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-file-word"></i> View / Download Word File
                                </a></p>
                            </div>`;
                    } 
                //     else if(['doc','docx'].includes(fileExt)){
                //     attachmentHtml = `
                //         <div class="mt-3">
                //             <strong>Attachment:</strong>
                //             <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(fileUrl)}" 
                //                     width="100%" height="500px" frameborder="0"></iframe>
                //             <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-success mt-2">
                //                 <i class="fas fa-file-word"></i> Download Word File
                //             </a></p>
                //         </div>`;
                // }


                    else {
                        attachmentHtml = `
                            <div class="mt-3">
                                <strong>Attachment:</strong>
                                <p><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download"></i> Download File
                                </a></p>
                            </div>`;
                    }
                } else {
                    attachmentHtml = `<em>No attachment</em>`;
                }
                document.querySelector('#viewAttachment').innerHTML = attachmentHtml;
            }
        } catch(error) {
            console.error(error);
            Swal.fire('Error', 'Something went wrong while fetching announcement.', 'error');
        }
    }
</script>

