@extends('adminlte::page')
@section('title', 'Open Calls Module')
@section('content_header')
<h1>Open Calls List</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @include('admin.component.alert_msg')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Open Calls List</h3>
                <div class="card-tools">
                    {{-- <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div> --}}
                    <a href="{{ route('admin.opencall.create') }}" class="btn btn-sm btn-info">+ Add Open Call</a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Open Call Title</th>
                            <th>Open Call Description</th>
                            <th>Open Call Date</th>
                            <th>Status</th>
                            <th>Custom Fields</th>
                            <th>Is Artwork Enable ?</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page['title'] }}</td>
                            <td>{{ strlen($page['short_description']) > 60 ? substr($page['short_description'], 0, 60)."..." : $page['short_description'] }}</td>
                            <td>{{ $page->start_date }} - {{ $page->end_date }}</td>
                            <td>
                                <span class="badge badge-{{($page['status'] == "Active") ? 'success' : 'danger' }}"> {{ $page['status'] }} </span>
                            </td>
                            <td>{{ $page->formfield->count() }}</td>
                            <td>{{ $page->is_show_artwork }}</td>
                            <td>
                                <a href="{{ route('admin.opencall.opencall-form.index', $page['id']) }}" class="btn btn-sm btn-default">Add Form Fields</a>
                                <a href="{{ route('admin.opencall.show', $page['id']) }}" class="btn btn-sm btn-default">View</a>
                                <a href="{{ route('admin.opencall.edit', $page['id']) }}" class="btn btn-sm btn-default">Edit</a>
                                <a href="{{ route('admin.opencall.destroy', $page['id']) }}" onclick="event.preventDefault();" class="btn btn-sm btn-default delete-item" data-id="{{ $page['id'] }}">Delete</a>

                                <!-- Form For Delete -->
                                <form id="submit-form-{{ $page['id'] }}"
                                    action="{{ route('admin.opencall.destroy',$page['id']) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No Data Found !</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer float-right">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    let text = "Are you sure you want to delete this ?";

    $(".delete-item").click(function() {
        if (confirm(text) == true) {
            var formId = 'submit-form-' + $(this).data("id");
            document.getElementById(formId).submit();
        }
    } );
</script>
@stop
