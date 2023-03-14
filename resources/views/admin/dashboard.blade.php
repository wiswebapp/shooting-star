@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>

    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-fw fa-inbox"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Exhibitions</span>
                    <span class="info-box-number">{{ $data['active_exhibition'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-fw fa-inbox"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">InActive Exhibitions</span>
                    <span class="info-box-number">{{ $data['inactive_exhibition'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="far fa-file"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Content Pages</span>
                    <span class="info-box-number">{{ $data['content_page'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Active Exhibitions</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Exhibition Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['exhibition_list'] as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->category->name }}</td>
                            <td>{{ $page['title'] }}</td>
                            <td>{{ $page['start_date'] }}</td>
                            <td>{{ $page['end_date'] }}</td>
                            <td>
                                <a href="{{ route('admin.exhibition.show', $page['id']) }}" class="btn btn-sm btn-default">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No Active Exhibition !</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.exhibition.index') }}" type="button" class="btn btn-sm btn-default float-right">View All</a>
            </div>
        </div>
        </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

