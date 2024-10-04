<div class="modal fade" id="modalInfoDonation" tabindex="-1" role="dialog" aria-labelledby="modalInfoDonationLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoDonationLabel">Info Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-8">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>No Transaksi</td>
                            <td>:</td>
                            <td id="no_transaksi"></td>
                        </tr>
                        <tr>
                            <td>Donatur</td>
                            <td>:</td>
                            <td id="donatur"></td>
                        </tr>
                        <tr>
                            <td>Shohibul</td>
                            <td>:</td>
                            <td id="shobat"></td>
                        </tr>
                        <tr>
                            <td>Campaign</td>
                            <td>:</td>
                            <td id="campaign"></td>
                        </tr>
                        <tr>
                            <td>Rekening</td>
                            <td>:</td>
                            <td id="rekening"></td>
                        </tr>
                        <tr>
                            <td>Biller Code</td>
                            <td>:</td>
                            <td id="billercode"></td>
                        </tr>
                        <tr>
                            <td>Virtual Account</td>
                            <td>:</td>
                            <td id="va"></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>:</td>
                            <td id="jumlah"></td>
                        </tr>
                        <tr>
                            <td>Nominal</td>
                            <td>:</td>
                            <td id="nominal"></td>
                        </tr>
                        <tr>
                            <td>Unik Nominal</td>
                            <td>:</td>
                            <td id="uniknominal"></td>
                        </tr>
                        <tr>
                            <td>Sub Total</td>
                            <td>:</td>
                            <td id="subtotal"></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td id="statusdonasi"></td>
                        </tr>
                        <tr>
                            <td>Expired</td>
                            <td>:</td>
                            <td id="expired"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <img class="img-thumbnail" id="qrcode" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalInfoDonation').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/transaction/donations/${id}`,
            }).done((donations) => {
                $('#no_transaksi').text(donations.data.no_transaksi)
                $('#donatur').text(donations.data.relationship.users.name)
                $('#jumlah').text(donations.data.quantity)
                $('#nominal').text(formatRupiah(donations.data.nominal_donasi))
                $('#uniknominal').text(donations.data.unik_nominal)
                $('#campaign').text(donations.data.relationship.campaigns.name)
                $('#rekening').text(donations.data.relationship.rekenings.bank)
                $('#statusdonasi').text(donations.data.status)
                $('#expired').text(donations.data.expired)
                $('#subtotal').text(formatRupiah(donations.data.total_donasi))
                $('#billercode').text('')
                $('#va').text('')
                $('#shobat').text('')

                if (donations.data.relationship.rekenings.icon != null) {
                    $('#qrcode').attr('src', "{{env('APP_URL')}}/storage/" + donations.data.relationship.rekenings.icon)
                }

                if (donations.data.relationship.campaigns.categories_id == 2) {
                    $('#shobatqurban').text(donations.data.shohibul)
                }

                var responseDonasi = JSON.parse(donations.data.response_donasi)

                switch (donations.data.relationship.rekenings.provider) {
                    case 'Moota':
                        break;
                    default:
                        switch (donations.data.relationship.rekenings.group) {
                            case 'e_money':
                                $('#qrcode').attr('src', responseDonasi.actions[0].url)
                                break;
                            default:
                                if (donations.data.relationship.rekenings.token == 'echannel') {
                                    $('#billercode').text(responseDonasi.biller_code)
                                    $('#va').text(responseDonasi.bill_key)
                                } else if (donations.data.relationship.rekenings.token == 'permata') {
                                    $('#va').text(responseDonasi.permata_va_number)
                                } else {
                                    $('#va').text(responseDonasi.va_numbers[0].va_number)
                                }
                                break;
                        }
                        break;
                }
            })

        })
    })
</script>