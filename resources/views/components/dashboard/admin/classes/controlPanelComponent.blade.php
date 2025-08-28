<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Class Control Panel</h1>

    <!-- Dynamic Class Cards -->
    <div class="row classCardsRow">

        <!-- Loader (Optional) -->
        <div class="col-12 text-center py-5" id="classLoader">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Loading Classes...</p>
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
    getClassListsForCards();

    async function getClassListsForCards() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert('Unauthorized Access. Please login first.');
            window.location.href = "/admin/login";
            return;
        }

        try {
            const response = await axios.post('/class-model/lists', {}, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.data.status === 'success') {
                let lists = response.data.data;

                $("#classLoader").remove(); // Remove loader


                if (lists.length === 0) {
                    // Default fallback card
                    $(".classCardsRow").html(`
                        <div class="col-12">
                            <div class="card border-left-danger shadow h-100 py-4 text-center">
                                <div class="card-body">
                                    <i class="fas fa-exclamation-circle fa-2x text-danger mb-3"></i>
                                    <h5 class="text-danger">No Classes Found</h5>
                                    <p class="mb-3">You haven't created any class yet.</p>
                                    <a href="/class/create" class="btn btn-sm btn-danger">
                                        Create Class
                                    </a>
                                </div>
                            </div>
                        </div>
                    `);
                    return;
                }

                let cardsHTML = ``;
                lists.forEach(element => {
                    cardsHTML += `
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Class
                                            </div>
                                            <div class="h5 mb-2 font-weight-bold text-gray-800">
                                                ${element.name}
                                            </div>
                                            <div class="d-flex gap-2 mt-3">
                                                <button class="btn btn-sm btn-primary classHubBtn" data-id="${element.id}">
                                                   Go ClassHub
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-school fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $(".classCardsRow").html(cardsHTML);

            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: response.data.message || 'No data found'
                });
            }
        } catch (error) {
            console.error('Error fetching class models:', error);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fail to load class models. Please try again later'
            });
        }

        //class hub button
        $(".classHubBtn").click(function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            //console.log('button clicked', id);
             window.location.href = `/class/work/space/${id}`;
            //pass id WorkSpace Page How is possible
        })
        
    }
</script>
