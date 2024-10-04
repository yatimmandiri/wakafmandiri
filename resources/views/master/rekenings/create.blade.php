<div class="modal fade" id="modalCreateRekening" tabindex="-1" role="dialog" aria-labelledby="modalCreateRekeningLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formRekeningCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateRekeningLabel">Create Data</h5>
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
                        <label for="bank" class="mb-1">Bank</label>
                        <input type="text" name="bank" placeholder="Bank" class="form-control" id="bank">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="number" class="mb-1">Number</label>
                        <input type="number" name="number" placeholder="Number" class="form-control" id="number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="provider" class="mb-1">Provider</label>
                        <select name="provider" id="provider" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="group" class="mb-1">Group</label>
                        <select name="group" id="group" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="token" class="mb-1">Channel</label>
                        <select name="token" id="token" class="form-control select2" disabled>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="icon" class="mb-1">Icon</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="icon" id="icon">
                            <label class="custom-file-label" for="icon">Choose file</label>
                        </div>
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
        $('#modalCreateRekening').on('show.bs.modal', function() {
            bsCustomFileInput.init();

            setDataSelect({
                tagid: '#provider',
                data: [{
                    id: 'Midtrans',
                    text: 'Midtrans',
                }, {
                    id: 'Moota',
                    text: 'Moota',
                }],
                placeholder: 'Select Provider',
                modalid: '#modalCreateRekening'
            })

            setDataSelect({
                tagid: '#group',
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
                placeholder: 'Select Group',
                modalid: '#modalCreateRekening'
            })

            $('#provider').on('change', function(e) {
                let val = $(this).val()

                let channel = [];

                $('#token').removeAttr('disabled')

                switch (val) {
                    case 'Moota':
                        ajaxRequest({
                            url: `/moota/rekenings`,
                        }).done((rekenings) => {
                            $('#token').empty().select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Channel',
                                data: rekenings.data.map((item) => {
                                    return {
                                        id: item.bank_id,
                                        text: item.bank_type,
                                    }
                                }),
                            })
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
                                'id': 'mandiri',
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

                        $('#token').empty().select2({
                            theme: 'bootstrap-5',
                            placeholder: 'Select Channel',
                            data: channel,
                        })

                        break;
                }
            })

            $('#formRekeningCreate').ajaxForm({
                url: '/master/rekenings',
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
                    $('#modalCreateRekening').modal('toggle')
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