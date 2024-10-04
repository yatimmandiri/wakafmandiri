<div class="modal fade" id="modalInfoRekening" tabindex="-1" role="dialog" aria-labelledby="modalInfoRekeningLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoRekeningLabel">Info Data</h5>
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
                        <td>Bank</td>
                        <td id="info_bank"></td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td id="info_number"></td>
                    </tr>
                    <tr>
                        <td>Provider</td>
                        <td id="info_provider"></td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td id="info_group"></td>
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
        $('#modalInfoRekening').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/master/rekenings/${id}`,
            }).done((rekenings) => {
                $('#info_name').text(rekenings.data.name)
                $('#info_bank').text(rekenings.data.bank)
                $('#info_number').text(rekenings.data.number)
                $('#info_provider').text(rekenings.data.provider)
                $('#info_group').text(rekenings.data.group)
            })
        })
    })
</script>