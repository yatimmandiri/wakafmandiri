<div class="modal fade" id="modalInfoPartner" tabindex="-1" role="dialog" aria-labelledby="modalInfoPartnerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoPartnerLabel">Info Data</h5>
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
        $('#modalInfoPartner').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/master/partners/${id}`,
            }).done((Partners) => {
                $('#info_name').text(Partners.data.name)
            })
        })
    })
</script>