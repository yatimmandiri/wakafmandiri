<div class="modal fade" id="modalCreateCategory" tabindex="-1" role="dialog" aria-labelledby="modalCreateCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formCategoryCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateCategoryLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="images" class="mb-1">Feature Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input form-control" id="images" name="images">
                                <label class="custom-file-label" for="images">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitData" onclick="$(this).submit()">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalCreateCategory').on('show.bs.modal', function() {
            bsCustomFileInput.init();

            $('#formCategoryCreate').ajaxForm({
                url: '/master/categories',
                type: 'POST',
                resetForm: true,
                beforeSubmit: function(formData) {
                    var formSerialize = $.param(formData);
                    return true;
                },
                success: function(result) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })

                    $('#category-table').DataTable().ajax.reload()
                    $('#modalCreateCategory').modal('toggle')
                },
                error: function(errors) {
                    Toast.fire({
                        icon: 'error',
                        title: errors.responseJSON.message,
                    })
                }
            });
        })
    })
</script>