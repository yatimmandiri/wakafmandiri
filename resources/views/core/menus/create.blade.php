<div class="modal fade" id="modalCreateMenu" tabindex="-1" role="dialog" aria-labelledby="modalCreateMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formMenuCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateMenuLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="link" class="mb-1">Link</label>
                        <input type="text" name="link" placeholder="Link" class="form-control" id="link">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="icon" class="mb-1">Icon</label>
                        <input type="text" name="icon" placeholder="Icon" class="form-control" id="icon">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="parent" class="mb-1">Parent</label>
                        <select name="parent" id="parent" class="form-control select2">
                            <option value="0">Parent</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="roles" class="mb-1">Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple></select>
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
        $('#modalCreateMenu').on('show.bs.modal', function() {

            ajaxRequest({
                url: `/core/roles`,
            }).done((response) => {
                setDataSelect({
                    tagid: '#roles',
                    modalid: '#modalCreateMenu',
                    data: response.data.map((item) => {
                        return {
                            id: item.id,
                            text: item.name,
                        }
                    }),
                    placeholder: 'Select Role',
                })
            })

            ajaxRequest({
                url: `/core/menus`,
            }).done((menus) => {
                setDataSelect({
                    tagid: '#parent',
                    modalid: '#modalCreateMenu',
                    data: menus.data.map((item) => {
                        return {
                            id: item.id,
                            text: item.name,
                        }
                    }),
                    placeholder: 'Select Menus',
                })
            })

            $('#formMenuCreate').ajaxForm({
                url: '/core/menus',
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

                    $('#menu-table').DataTable().ajax.reload()
                    $('#modalCreateMenu').modal('toggle')
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