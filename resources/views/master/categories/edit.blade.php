<div class="modal fade" id="modalUpdateCategory" tabindex="-1" role="dialog" aria-labelledby="modalUpdateCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formCategoryUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateCategoryLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="e_name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="e_feature_image" class="mb-1">Feature Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input form-control" id="e_featureimage" name="feature_image">
                                <label class="custom-file-label" for="e_feature_image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="updateData" onclick="$(this).submit()">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalUpdateCategory').on('show.bs.modal', function(e) {
            bsCustomFileInput.init();

            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/master/categories/${id}`,
            }).done((categories) => {
                $('#e_name').val(categories.data.name)

            })

            $('#formCategoryUpdate').ajaxForm({
                url: `/master/categories/${id}`,
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
                    $('#modalUpdateCategory').modal('toggle')
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