<div class="modal fade" id="modalUpdateMenu" tabindex="-1" role="dialog" aria-labelledby="modalUpdateMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formMenuUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateMenuLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="e_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="link" class="mb-1">Link</label>
                        <input type="text" name="link" placeholder="Link" class="form-control" id="e_link">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="icon" class="mb-1">Icon</label>
                        <input type="text" name="icon" placeholder="Icon" class="form-control" id="e_icon">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="parent" class="mb-1">Parent</label>
                        <select name="parent" id="e_parent" class="form-control select2">
                            <option value="0">Parent</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="roles" class="mb-1">Roles</label>
                        <select name="roles[]" id="e_roles" class="form-control select2" multiple></select>
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
        $('#modalUpdateMenu').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/core/menus/${id}`,
            }).done((response) => {
                $('#e_name').val(response.data.name)
                $('#e_link').val(response.data.link)
                $('#e_icon').val(response.data.icon)

                ajaxRequest({
                    url: `/core/menus`,
                }).done((menus) => {
                    setDataSelect({
                        tagid: '#e_parent',
                        modalid: '#modalUpdateMenu',
                        data: menus.data.map((item) => {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        }),
                        dataSelected: response.data.parent,
                        placeholder: 'Select Menus',
                    })
                })

                ajaxRequest({
                    url: `/core/roles`,
                }).done((roles) => {
                    setDataSelect({
                        tagid: '#e_roles',
                        modalid: '#modalUpdateMenu',
                        data: roles.data.map((item) => {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        }),
                        dataSelected: response.data.relationship.roles.map((item) => {
                            return item.id
                        }),
                        placeholder: 'Select Role',
                    })
                })
            })

            $('#formMenuUpdate').ajaxForm({
                url: `/core/menus/${id}`,
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
                    $('#modalUpdateMenu').modal('toggle')
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