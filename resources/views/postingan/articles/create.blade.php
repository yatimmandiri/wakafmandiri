@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <form method="POST" id="formArticleCreate" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="card-header">
                    <h3 class="card-title">{{$pageTitle}}</h3>
                </div>
                <div class="card-body row">
                    <div class="form-group col-md-6">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="feature_image" class="mb-1">Feature Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="feature_image" id="feature_image">
                            <label class="custom-file-label" for="featureimage">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description" class="mb-1">Description</label>
                        <textarea name="description" placeholder="Description" class="form-control editors" id="description">
                            </textarea>
                    </div>
                    <div class="form-group col-md-12 text-right">
                        <a href="{{ route('articles.index') }}">
                            <button type="button" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</button>
                        </a>
                        <button type="button" class="btn btn-primary" id="submitData" onclick="$(this).submit()"><i class="fas fa-save"></i>
                            Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        bsCustomFileInput.init();

        setDataEditors({
            tagid: '#description',
            value: ''
        })

        $('#formArticleCreate').ajaxForm({
            url: `{{ route('articles.store') }}`,
            type: 'POST',
            resetForm: true,
            beforeSubmit: function(formData) {
                var formSerialize = $.param(formData);
                formData[4]['value'] = myEditor.getData();
                return true;
            },
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                window.location.href = `{{ route('articles.index') }}`
            },
            error: function(errors) {
                Toast.fire({
                    icon: 'error',
                    title: errors.responseJSON.message,
                })
            }
        });
    })
</script>

@endsection