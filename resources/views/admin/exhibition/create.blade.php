@extends('adminlte::page')
@section('title', 'Create Exhibition')
@section('content_header')
    <h1>{{ $data['action'] }} Exhibition</h1>
@stop

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.19/css/froala_editor.min.css">
<div class="col-md-12">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">{{ $data['action'] . " " . $data['page']['title'] }} Exhibition Data</h3>
        </div>
        <form action="{{ $data['formUrl'] }}" method="POST" enctype="multipart/form-data">
            @if($data['method'] != 'POST')
            <input type="hidden" name="_method" value="PUT" />
            @endif
            <div class="card-body">
                @include('admin.component.alert_msg')
                @csrf
                <div class="form-group">
                    <label>Exhibition Category</label>
                    <select class="form-control" name="category_id">
                        @forelse($data['category'] as $cat)
                        <option {{ $data['exhibition']['category'] == $cat['id'] ? 'selected' : ''}} value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                        @empty
                        <option value="" disabled>No category Found !</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label>Exhibition Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter Exhibition Title" value="{{ old('title', $data['exhibition']['title']) }}" required>
                </div>
                <div class="form-group">
                    <label>Exhibition Desciption (short)</label>
                    <input type="text" name="short_description" class="form-control" placeholder="Exhibition Desciption (short)" value="{{ old('short_description', $data['exhibition']['short_description']) }}" required>
                </div>
                 <div class="form-group">
                    <label>Exhibition Desciption (long)</label>
                    <textarea name="description" id="editor" cols="30" rows="10" class="form-control" placeholder="Exhibition Desciption (long)">{{ old('description', $data['exhibition']['description']) }}</textarea>
                    @error('description')<p class="text-danger">Please Add Desciption</p>@enderror
                </div>
                @if($data['exhibition']['cover_image'])
                <div class="form-group">
                    <label>Preview Image</label>
                    <p><img style="height:100px;width:100px;" class="img-thumbnail" src="{{asset('images/exhibition/cover_images/'. $data['exhibition']['cover_image'])}}"></p>
                </div>
                @endif
                <div class="form-group">
                    <label>Cover Image</label>
                    <input type="file" name="cover_image" class="form-control">
                </div>
                <label>Start-End Date</label>
                <div class="form-group input-group">
                    <input type="text" name="start_date" autocomplete="off" class="form-control datepicker" placeholder="Enter Start Date" value="{{ old('start_date', $data['exhibition']['start_date']) }}" required>
                    <span class="input-group-addon">-</span>
                    <input type="text" name="end_date" autocomplete="off" class="form-control datepicker" placeholder="Enter End Date" value="{{ old('end_date', $data['exhibition']['end_date']) }}" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="Active" {{($data['exhibition']['status'] == 'Active') ? "checked" : ""}} id="status_active">
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="InActive" {{($data['exhibition']['status'] == 'InActive') ? "checked" : ""}} id="status_inactive">
                            <label class="form-check-label" for="status_inactive">InActive</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ $data['action'] }} Page</button>
                <a href="{{ route('admin.exhibition.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    tinymce.init({
        selector: "#editor"
    });
</script>
@stop
