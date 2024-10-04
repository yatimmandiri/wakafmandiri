<div class="modal fade" id="modalInfoMenu" tabindex="-1" role="dialog" aria-labelledby="modalInfoMenuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoMenuLabel">Info Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tr>
                        <td>Name</td>
                        <td id="info_name"></td>
                    </tr>
                    <tr>
                        <td>Link</td>
                        <td id="info_link"></td>
                    </tr>
                    <tr>
                        <td>Icon</td>
                        <td id="info_icon"></td>
                    </tr>
                    <tr>
                        <td>Parent</td>
                        <td id="info_parent"></td>
                    </tr>
                    <tr>
                        <td>Roles</td>
                        <td id="info_roles"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalInfoMenu').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/core/menus/${id}`,
            }).done((response) => {
                $('#info_name').text(response.data.name)
                $('#info_link').text(response.data.link)
                $('#info_icon').text(response.data.icon)

                ajaxRequest({
                    url: `/core/menus/${response.data.parent}`,
                }).done((response) => {
                    $('#info_parent').text(response.data.name)
                }).fail((response) => {
                    $('#info_parent').text(null)
                })

                var appendRole = response.data.relationship.roles.map((item) => {
                    return '<span class="badge badge-success mx-1">' + item.name + '</span>'
                })

                $('#info_roles').html(appendRole)
            })

        })
    })
</script>