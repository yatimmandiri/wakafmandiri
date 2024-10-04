@extends('layouts.app')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img id="logo" class="img-fluid" alt="User profile picture">
                        </div>
                        <button data-toggle="modal" data-target="#modalChangeLogo" class="btn btn-outline-primary btn-block mt-2"><b>Ganti Logo</b></button>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img id="favicon" class="img-fluid" alt="User profile picture">
                        </div>
                        <button href="#" data-toggle="modal" data-target="#modalChangeFavicon" class="btn btn-outline-primary btn-block mt-2"><b>Ganti Favicon</b></button>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img id="logoWhite" class="img-fluid" alt="User profile picture">
                        </div>
                        <button href="#" data-toggle="modal" data-target="#modalChangeLogoWhite" class="btn btn-outline-primary btn-block mt-2"><b>Ganti Logo White</b></button>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img id="sertifikat" class="img-fluid" alt="User profile picture">
                        </div>
                        <button href="#" data-toggle="modal" data-target="#modalChangeSertifikat" class="btn btn-outline-primary btn-block mt-2"><b>Ganti Sertifikat</b></button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Info Website</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <form id="formSettingUpdate">
                                @csrf
                                @method('PUT')
                                <div class="active tab-pane table-responsive" id="info">
                                    <table class="table table-hover table-bordered" width="100%">
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="name" id="name" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="address" id="address" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="phone" id="phone" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Handphone</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="handphone" id="handphone" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>
                                                <input type="email" name="email" id="email" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account Facebook</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="facebook" id="facebook" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account Twitter</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="twitter" id="twitter" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account Instagram</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="instagram" id="instagram" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account Youtube</td>
                                            <td>:</td>
                                            <td><input type=" text" name="youtube" id="youtube" class="form-control" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>:</td>
                                            <td>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control">

                                                </textarea>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-warning" id="submitData" onclick="$(this).submit()">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalChangeLogo" tabindex="-1" role="dialog" aria-labelledby="modalChangeLogoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" id="formLogoChange" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalChangeLogoLabel">Change Logo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control" id="logo" name="logo">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
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

        <div class="modal fade" id="modalChangeFavicon" tabindex="-1" role="dialog" aria-labelledby="modalChangeFaviconLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" id="formFaviconChange" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalChangeFaviconLabel">Change Favicon</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control" id="favicon" name="favicon">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
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

        <div class="modal fade" id="modalChangeLogoWhite" tabindex="-1" role="dialog" aria-labelledby="modalChangeLogoWhiteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" id="formLogoWhiteChange" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalChangeLogoWhiteLabel">Change Logo White</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control" id="logoWhite" name="logoWhite">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
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

        <div class="modal fade" id="modalChangeSertifikat" tabindex="-1" role="dialog" aria-labelledby="modalChangeSertifikatLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" id="formSertifikatChange" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalChangeSertifikatLabel">Change Sertifikat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control" id="sertifikat" name="sertifikat">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
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
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        bsCustomFileInput.init();

        getData()

        $('#formSettingUpdate').ajaxForm({
            url: `{{ route('website.update', 1) }}`,
            type: 'POST',
            resetForm: true,
            beforeSubmit: function(formData) {
                var formSerialize = $.param(formData);
                formData[11]['value'] = myEditor.getData();
                return true;
            },
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                })

                $('#name').val(response.data.name);
                $('#address').val(response.data.address);
                $('#email').val(response.data.email);
                $('#phone').val(response.data.phone);
                $('#handphone').val(response.data.handphone);
                $('#facebook').val(response.data.facebook);
                $('#twitter').val(response.data.twitter);
                $('#instagram').val(response.data.instagram);
                $('#youtube').val(response.data.youtube);
            },
            error: function(errors) {
                Toast.fire({
                    icon: 'error',
                    title: errors.responseJSON.message,
                })
            }
        });

        $('#formLogoChange').ajaxForm({
            url: `{{ route('website.logo') }}`,
            type: 'POST',
            resetForm: true,
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                let url = "{{ env('APP_URL'). '/storage/' }}" + result.data.logo;

                $('#logo').attr('src', url)
                $('#modalChangeLogo').modal('toggle')
            },
            error: function(errors) {
                Toast.fire({
                    icon: 'error',
                    title: errors.responseJSON.message,
                })
            }
        });

        $('#formLogoWhiteChange').ajaxForm({
            url: `{{ route('website.logo') }}`,
            type: 'POST',
            resetForm: true,
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                let url = "{{ env('APP_URL'). '/storage/' }}" + result.data.logoWhite;

                $('#logoWhite').attr('src', url)
                $('#modalChangeLogoWhite').modal('toggle')
            },
            error: function(errors) {
                Toast.fire({
                    icon: 'error',
                    title: errors.responseJSON.message,
                })
            }
        });

        $('#formFaviconChange').ajaxForm({
            url: `{{ route('website.logo') }}`,
            type: 'POST',
            resetForm: true,
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                let url = "{{ env('APP_URL'). '/storage/' }}" + result.data.favicon;

                $('#favicon').attr('src', url)
                $('#modalChangeFavicon').modal('toggle')
            },
            error: function(errors) {
                Toast.fire({
                    icon: 'error',
                    title: errors.responseJSON.message,
                })
            }
        });

        $('#formSertifikatChange').ajaxForm({
            url: `{{ route('website.logo') }}`,
            type: 'POST',
            resetForm: true,
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                let url = "{{ env('APP_URL'). '/storage/' }}" + result.data.sertifikat;

                $('#sertifikat').attr('src', url)
                $('#modalChangeSertifikat').modal('toggle')
            },
            error: function(errors) {
                Toast.fire({
                    icon: 'error',
                    title: errors.responseJSON.message,
                })
            }
        });

        function getData() {
            $.ajax({
                url: "{{ route('website.show', 1) }}",
                type: "GET",
                success: function(response) {
                    $('#name').val(response.data.name);
                    $('#address').val(response.data.address);
                    $('#email').val(response.data.email);
                    $('#phone').val(response.data.phone);
                    $('#handphone').val(response.data.handphone);
                    $('#facebook').val(response.data.facebook);
                    $('#twitter').val(response.data.twitter);
                    $('#instagram').val(response.data.instagram);
                    $('#youtube').val(response.data.youtube);

                    setDataEditors({
                        tagid: '#description',
                        value: response.data.description,
                    })

                    let logo = "http://picsum.photos/500/500";
                    let favicon = "http://picsum.photos/500/500";
                    let logoWhite = "http://picsum.photos/500/500";
                    let sertifikat = "http://picsum.photos/512/725";

                    if (response.data.logo != 'logo.png') {
                        logo = "{{ asset('storage') }}" + "/" + response.data.logo;
                    }

                    if (response.data.favicon != 'favicon.png') {
                        favicon = "{{ asset('storage') }}" + "/" + response.data.favicon;
                    }

                    if (response.data.logoWhite != 'logoWhite.png') {
                        logoWhite = "{{ asset('storage') }}" + "/" + response.data.logoWhite;
                    }

                    if (response.data.sertifikat != 'sertifikat.png') {
                        sertifikat = "{{ asset('storage') }}" + "/" + response.data.sertifikat;
                    }

                    $('#logo').attr('src', logo)
                    $('#favicon').attr('src', favicon)
                    $('#logoWhite').attr('src', logoWhite)
                    $('#sertifikat').attr('src', sertifikat)
                }
            })
        }


    })
</script>

@endsection