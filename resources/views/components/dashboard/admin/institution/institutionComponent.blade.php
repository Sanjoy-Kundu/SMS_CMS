<div class="container-fluid">

    <div class="row">

        <!-- Left Card: Institution Form -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-3 px-4">
                <div class="card-body">
                    <h5 class="card-title text-primary font-weight-bold mb-3">Add Your New Institution</h5>
                    <form id="institutionForm">

                        <div class="form-group">
                            <label for="name">Institution Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter institution name">
                            <span style="display: block" id="institution_name_error" class="text-danger">--</span>
                        </div>
                        <div class="form-group">
                            <label for="type">Institution Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="" disabled selected>--CHOOSE ONE --</option>
                                <option value="school">School</option>
                                <option value="college">College</option>
                                <option value="combined">Combined</option>
                            </select>
                            <span style="display: block" id="institution_type_error" class="text-danger">--</span>
                        </div>
                        <div class="form-group">
                            <label for="eiin">EIIN</label>
                            <input type="text" class="form-control" id="eiin" name="eiin"
                                placeholder="Enter EIIN (optional)">
                            <span style="display: block" id="institution_eiin_error" class="text-danger">--</span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter address (optional)"></textarea>
                            <span style="display: block" id="institution_address_error" class="text-danger">--</span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" onclick="addInstitution(event)">Add
                            Institution</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Card: Institution Table -->
        <div class="col-xl-7 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-3 px-4">
                <div class="card-body">
                    <h5 class="card-title text-success font-weight-bold mb-3">Institutions List</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>EIIN</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>





<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    getInstitutions();

    async function getInstitutions() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/institution/details', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                let institutions = response.data.data;
                let tbody = '';

                if (institutions && !Array.isArray(institutions) && typeof institutions === 'object') {
                    // ফর্মে ডাটা সেট করা
                    $('#name').val(institutions.name || '');
                    $('#eiin').val(institutions.eiin || '');
                    $('#address').val(institutions.address || '');

                    if (institutions.type === 'school' || institutions.type === 'college' || institutions.type === 'combined') {
                        $('#type').val(institutions.type);
                    } else {
                        $('#type').val('');
                    }

                    // ফর্ম disable করা
                    $("#institutionForm :input").prop("disabled", true);

                    tbody += `
                    <tr>
                        <td>1</td>
                        <td>${institutions.name || 'N/A'}</td>
                        <td>${institutions.type ? institutions.type.charAt(0).toUpperCase() + institutions.type.slice(1) : 'N/A'}</td>
                        <td>${institutions.eiin || 'N/A'}</td>
                        <td>${institutions.address || 'N/A'}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary edit_btn" data-id="${institutions.id}">EDIT</button>
                                <button type="button" class="btn btn-info view_btn" data-id="${institutions.id}">VIEW</button>
                                <button type="button" class="btn btn-danger trash_btn" data-id="${institutions.id}">TRASH</button>
                            </div>
                        </td>
                    </tr>`;
                } else if (Array.isArray(institutions)) {
                    if (institutions.length === 0) {
                        tbody = `<tr><td colspan="6" class="text-center">No institutions found.</td></tr>`;
                    } else {
                        $.each(institutions, function(index, inst) {
                            tbody += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${inst.name || 'N/A'}</td>
                                <td>${inst.type ? inst.type.charAt(0).toUpperCase() + inst.type.slice(1) : 'N/A'}</td>
                                <td>${inst.eiin || 'N/A'}</td>
                                <td>${inst.address || 'N/A'}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example" data-id="${inst.id}">
                                        <button type="button" class="btn btn-primary edit_btn" data-id="${inst.id}">EDIT</button>
                                        <button type="button" class="btn btn-info view_btn" data-id="${inst.id}">VIEW</button>
                                        <button type="button" class="btn btn-danger trash_btn" data-id="${inst.id}">TRASH</button>
                                    </div>
                                </td>
                            </tr>`;
                        });
                    }
                    // ফর্ম enable & reset করা
                    $("#institutionForm :input").prop("disabled", false);
                    $("#institutionForm")[0].reset();
                } else {
                    tbody = `<tr><td colspan="6" class="text-center">No institutions found.</td></tr>`;
                    $("#institutionForm :input").prop("disabled", false);
                    $("#institutionForm")[0].reset();
                }

                $('table tbody').html(tbody);

                // TODO: এখানে button event listener লাগাও (EDIT, VIEW, DELETE)
                $('table').on('click', '.edit_btn', function() {
                        let id = $(this).data('id');
                        console.log('edit',id)
                        // তোমার modal open করা বা edit ফাংশন কল করা
                    });
                $('table').on('click', '.view_btn', function() {
                        let id = $(this).data('id');
                        console.log('view',id)
                        // তোমার modal open করা বা edit ফাংশন কল করা
                    });
                $('table').on('click', '.trash_btn', function() {
                        let id = $(this).data('id');
                        console.log('trash',id)
                        // তোমার modal open করা বা edit ফাংশন কল করা
                    });
            } else {
                console.log(response.data);
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong fetching institutions.'
            });
        }
    }

    $('#institutionForm').on('submit', async function(e) {
        e.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "/admin/login";
            return;
        }

        let name = $.trim($('#name').val());
        let type = $('#type').val();
        let eiin = $.trim($('#eiin').val());
        let address = $.trim($('#address').val());

        // Reset errors
        $('#institution_name_error').text('');
        $('#institution_type_error').text('');
        $('#institution_eiin_error').text('');
        $('#institution_address_error').text('');

        if (!name) {
            $('#institution_name_error').text('Please enter institution name');
            return;
        }
        if (!type) {
            $('#institution_type_error').text('Please select institution type');
            return;
        }

        let data = { name, type, eiin, address };

        try {
            let res = await axios.post('/institution/create', data, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (res.data.status === 'success') {
                await getInstitutions();
                Swal.fire({
                    icon: 'success',
                    title: 'Institution Added!',
                    text: res.data.message
                });

                $("#institutionForm :input").prop("disabled", true);
                $("button[type='submit']")
                    .text("Institution Added")
                    .removeClass("btn-primary")
                    .addClass("btn-success");
            } else {
                console.log(res.data);
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                if (errors.name) {
                    $('#institution_name_error').text(errors.name[0]);
                }
                if (errors.type) {
                    $('#institution_type_error').text(errors.type[0]);
                }
                if (errors.eiin) {
                    $('#institution_eiin_error').text(errors.eiin[0]);
                }
                if (errors.address) {
                    $('#institution_address_error').text(errors.address[0]);
                }
                let allErrors = Object.values(errors).flat().join("\n");
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: allErrors
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!'
                });
                console.error(error);
            }
        }
    });

});
</script>


