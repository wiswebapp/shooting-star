@extends('adminlte::page')
@section('title', 'Open call Response | '. $opencallResponse->opencall->title)
@section('content_header')
<h1>View Open Call Response</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @include('admin.component.alert_msg')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">View {{ $opencallResponse->opencall->title }} Response</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.open-call-response.index') }}" class="btn btn-sm btn-info">Back</a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered">
                    <tr class="text-info"><th colspan="4">Open Call Data</th></tr>
                    <tr>
                        <th>Open Call Title</th>
                        <td>{{ $opencallResponse->opencall->title }}</td>
                        <th>Open Call Description</th>
                        <td>{{ $opencallResponse->opencall->short_description }}</td>
                    </tr>
                    <tr>
                        <th>Open Call Start Date</th>
                        <td>{{ $opencallResponse->opencall->start_date }}</td>
                        <th>Open Call End Date</th>
                        <td>{{ $opencallResponse->opencall->end_date }}</td>
                    </tr>
                    <tr class="text-info"><th colspan="4">User Details Who Filled Form</th></tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $opencallResponse->name }}</td>
                        <th>Email</th>
                        <td>{{ $opencallResponse->email }}</td>
                    </tr>
                    <tr>
                        <th>Website Link</th>
                        <td><a href="{{ $opencallResponse->website_link }}" target="_blank">{{ $opencallResponse->website_link }}</a></td>
                        <th>Instagram Link</th>
                        <td><a href="{{ $opencallResponse->instagram_link }}" target="_blank">{{ $opencallResponse->instagram_link }}</a></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td colspan="3">{{ $opencallResponse->phone }}</td>
                    </tr>
                    <tr>
                        <th>Additional Comment</th>
                        <td colspan="3">{{ $opencallResponse->comment }}</td>
                    </tr>

                    <!-- Art Work Images -->
                    @if($opencallResponse->opencall->is_show_artwork == "Yes" && count($opencallResponse->art_work_title))
                    <tr class="text-info"><th colspan="4">Artwork Details</th></tr>
                    @for ($i = 0; $i < count($opencallResponse->art_work_title); $i++)
                    <tr class="text-red"><th colspan="4">Artwork {{$i+1}}</th></tr>
                    <tr>
                        <th>Art Work Title</th>
                        <td>{{ $opencallResponse->art_work_title[$i] }}</td>
                        <th>Art Work Size</th>
                        <td>{{ $opencallResponse->art_work_size[$i] }}</td>
                    </tr>
                    <tr>
                        <th>Art Work Medium</th>
                        <td>{{ $opencallResponse->art_work_medium[$i] }}</td>
                        <th>Art Work(s)</th>
                        <td>
                            <img class="img-thumbnail" style="height: 120px;" src="{{ asset('images/opencall_form/'.$opencallResponse->opencall->id.'/'.Str::slug($opencallResponse->name).'/'.$opencallResponse->art_work_image[$i]) }}" alt="Artwork Image">
                        </td>
                    </tr>
                    @endfor
                    @endif

                    <!-- Other Fields -->
                    @if(count($opencallResponse->other_field))
                     <tr class="text-info"><th colspan="4">Custom Form Details</th></tr>
                     @for ($i = 0; $i < count($opencallResponse->other_field); $i++)
                      @foreach($opencallResponse->other_field[$i] as $key => $value)
                      <tr>
                        <th>{{$key}}</th>
                        <td colspan="3">{{ $value }}</td>
                      </tr>
                      @endforeach
                    @endfor
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop
