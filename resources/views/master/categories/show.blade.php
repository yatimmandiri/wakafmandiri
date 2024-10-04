<div class="modal fade" id="modalInfoCategory" tabindex="-1" role="dialog" aria-labelledby="modalInfoCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoCategoryLabel">Info Data</h5>
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
        $('#modalInfoCategory').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/master/categories/${id}`,
            }).done((categories) => {
                $('#info_name').text(categories.data.name)
            })
        })
    })
</script>