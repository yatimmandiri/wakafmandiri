<div class="modal fade" id="modalUpdatePartner" tabindex="-1" role="dialog" aria-labelledby="modalUpdatePartnerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formPartnerUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdatePartnerLabel">Update Data</h5>
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
        $('#modalUpdatePartner').on('show.bs.modal', function(e) {
            bsCustomFileInput.init();

            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/master/partners/${id}`,
            }).done((partners) => {
                $('#e_name').val(partners.data.name)
            })

            $('#formPartnerUpdate').ajaxForm({
                url: `/master/partners/${id}`,
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

                    $('#partner-table').DataTable().ajax.reload()
                    $('#modalUpdatePartner').modal('toggle')
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