<div class="modal fade" id="modalUpdateRekening" tabindex="-1" role="dialog" aria-labelledby="modalUpdateRekeningLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formRekeningUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateRekeningLabel">Update Data</h5>
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
                        <label for="bank" class="mb-1">Bank</label>
                        <input type="text" name="bank" placeholder="Bank" class="form-control" id="e_bank">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="number" class="mb-1">Number</label>
                        <input type="number" name="number" placeholder="Number" class="form-control" id="e_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="provider" class="mb-1">Provider</label>
                        <select name="provider" id="e_provider" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="group" class="mb-1">Group</label>
                        <select name="group" id="e_group" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="token" class="mb-1">Channel</label>
                        <select name="token" id="e_token" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="icon" class="mb-1">Icon</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="icon" id="e_icon">
                            <label class="custom-file-label" for="icon">Choose file</label>
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
        $('#modalUpdateRekening').on('show.bs.modal', function(e) {
            bsCustomFileInput.init();

            let channel = [];

            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/master/rekenings/${id}`,
            }).done((rekenings) => {
                $('#e_name').val(rekenings.data.name)
                $('#e_bank').val(rekenings.data.bank)
                $('#e_number').val(rekenings.data.number)

                setDataSelect({
                    tagid: '#e_provider',
                    data: [{
                        id: 'Midtrans',
                        text: 'Midtrans',
                    }, {
                        id: 'Moota',
                        text: 'Moota',
                    }],
                    dataSelected: rekenings.data.provider,
                    placeholder: 'Select Provider',
                    modalid: '#modalUpdateRekening'
                })

                setDataSelect({
                    tagid: '#e_group',
                    data: [{
                            id: 'bank_transfer',
                            text: 'Bank Transfer',
                        }, {
                            id: 'e_money',
                            text: 'E-Money',
                        },
                        {
                            id: 'convenience_store',
                            text: 'Convenience Store',
                        },
                        {
                            id: 'cardless_credit',
                            text: 'Cardless Credit',
                        }
                    ],
                    dataSelected: rekenings.data.group,
                    placeholder: 'Select Group',
                    modalid: '#modalUpdateRekening'
                })

                switch (rekenings.data.provider) {
                    case 'Moota':
                        ajaxRequest({
                            url: `/moota/rekenings`,
                        }).done((response) => {
                            $('#e_token').empty().select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Channel',
                                data: response.data.map((item) => {
                                    return {
                                        id: item.bank_id,
                                        text: item.bank_type,
                                    }
                                }),
                            }).val(rekenings.data.token).trigger('change')
                        })
                        break;
                    default:
                        channel = [{
                                'id': 'bca',
                                'text': 'BCA Virtual Account'
                            },
                            {
                                'id': 'bni',
                                'text': 'BNI Virtual Account'
                            },
                            {
                                'id': 'bri',
                                'text': 'BRI Virtual Account'
                            },
                            {
                                'id': 'echannel',
                                'text': 'Mandiri Bill Payment'
                            },
                            {
                                'id': 'permata',
                                'text': 'Permata Virtual Account'
                            },
                            {
                                'id': 'gopay',
                                'text': 'Gopay'
                            },
                            {
                                'id': 'shopeepay',
                                'text': 'ShopeePay'
                            },
                        ]

                        $('#e_token').empty().select2({
                            theme: 'bootstrap-5',
                            placeholder: 'Select Channel',
                            data: channel,
                        }).val(rekenings.data.token).trigger('change')

                        break;
                }

                $('#e_provider').on('change', function(e) {
                    let val = $(this).val()

                    switch (val) {
                        case 'Moota':
                            ajaxRequest({
                                url: `/moota/rekenings`,
                            }).done((rekenings) => {
                                $('#e_token').empty().select2({
                                    theme: 'bootstrap-5',
                                    placeholder: 'Select Channel',
                                    data: rekenings.data.map((item) => {
                                        return {
                                            id: item.bank_id,
                                            text: item.bank_type,
                                        }
                                    }),
                                }).val(rekenings.data.token).trigger('change')
                            })

                            break;
                        default:
                            channel = [{
                                    'id': 'bca',
                                    'text': 'BCA Virtual Account'
                                },
                                {
                                    'id': 'bni',
                                    'text': 'BNI Virtual Account'
                                },
                                {
                                    'id': 'bri',
                                    'text': 'BRI Virtual Account'
                                },
                                {
                                    'id': 'echannel',
                                    'text': 'Mandiri Bill Payment'
                                },
                                {
                                    'id': 'permata',
                                    'text': 'Permata Virtual Account'
                                },
                                {
                                    'id': 'gopay',
                                    'text': 'Gopay'
                                },
                                {
                                    'id': 'shopeepay',
                                    'text': 'ShopeePay'
                                },
                            ]

                            $('#e_token').empty().select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Channel',
                                data: channel,
                            }).val(rekenings.data.token).trigger('change')

                            break;
                    }
                })
            })

            $('#formRekeningUpdate').ajaxForm({
                url: `/master/rekenings/${id}`,
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

                    $('#rekening-table').DataTable().ajax.reload()
                    $('#modalUpdateRekening').modal('toggle')
                },
                error: function(errors) {
                    Toast.fire({
                        icon: 'error',
                        title: errors.responseJSON.message,
                    })
                }
            })
        })
    })
</script>