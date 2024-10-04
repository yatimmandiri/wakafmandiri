<div class="modal fade" id="modalUpdateSlider" tabindex="-1" role="dialog" aria-labelledby="modalUpdateSliderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formSliderUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateSliderLabel">Update Data</h5>
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
                        <label for="link" class="mb-1">Link</label>
                        <input type="text" name="link" placeholder="Link" class="form-control" id="e_link">
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
        $('#modalUpdateSlider').on('show.bs.modal', function(e) {
            bsCustomFileInput.init();

            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/master/sliders/${id}`,
            }).done((sliders) => {
                $('#e_name').val(sliders.data.name)
                $('#e_link').val(sliders.data.link)

            })

            $('#formSliderUpdate').ajaxForm({
                url: `/master/sliders/${id}`,
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

                    $('#slider-table').DataTable().ajax.reload()
                    $('#modalUpdateSlider').modal('toggle')
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