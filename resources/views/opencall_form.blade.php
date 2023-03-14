@extends('layouts.app')

@section('title', $pageName)
@section('class', 'openCallPage')

@section('internalcss')
.text-uppercase {
    margin-bottom: 1em;
}
.opencall-p {
    margin: 0.75em 0 0.75em 0;
    font-size: 16px;
    text-align: left;
}
.errorMsg {
    color: red;
    font-size: 16px;
    margin: 0px;
}
.form-control {
    display: block;
    width: 100%;
    padding: 12px 13px;
    font-size: 0.875rem;
    font-weight: 300;
    line-height: 1.36;
    color: #000;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(171, 171, 171, 0.5);
    appearance: none;
    border-radius: 0;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
@endsection

@section('content')

<section class="section section-md bg-transparent" style="background-image: url('http://cdn.backgroundhost.com/backgrounds/subtlepatterns/az_subtle.png')">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <h4 class="text-uppercase">{{$opencall->title}} . ({{ $opencall->start_date }} - {{ $opencall->end_date }})</h4>
                <div class="opencall-description">
                    {!! $opencall->description !!}
                </div>

                @if ($errors->any())
                <table style="border:1px solid #b9b7b7;width:100%;">
                    <thead>
                        <tr><th style="text-align:left;color:red;padding: 0.75em;">Form Has Following Errors</th></tr>
                    </thead>
                    <tbody>
                    @foreach ($errors->all() as $error)
                    <tr>
                        <td style="font-size:13px;text-align:left;padding-left: 0.8em;">- {{ $error }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
                <form class="" method="post" action="/opencall/apply" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-gutters-20 row-20 align-items-center">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Open call Selected</label>
                                <select class="form-control" name="open_call_id" readonly>
                                    <option value="">--Select--</option>
                                    @foreach ($opencallList as $call)
                                    <option {{($opencall->id == $call->id) ? 'selected' : ''}} value="{{ $call->id }}">{{ $call->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="open_call_id" value="{{$opencall->id}}">

                        <x-form-element
                            col="6"
                            label="Full Name"
                            type="text"
                            name="name"
                            required="required"
                        ></x-form-element>

                        <x-form-element
                            col="6"
                            label="Email"
                            type="email"
                            name="email"
                            required="required"
                        ></x-form-element>

                        <x-form-element
                            col="12"
                            label="Contact Number"
                            type="number"
                            name="phone"
                            required="required"
                        ></x-form-element>

                        <x-form-element
                            col="12"
                            label="Website Link"
                            type="text"
                            name="website_link"
                            required=""
                        ></x-form-element>

                        <x-form-element
                            col="12"
                            label="Instagram Link"
                            type="text"
                            name="instagram_link"
                            required="required"
                        ></x-form-element>

                        <x-form-element
                            col="12"
                            label="Any Other Comment"
                            type="textarea"
                            name="comment"
                            required=""
                        ></x-form-element>

                        @if($opencall->is_show_artwork == "Yes")
                        <p class="col-md-12 text-start" style="margin-bottom:0px; padding-bottom:0px;">Upload Artwork</p>
                        <div class="artwork-fields row" style="margin-top:0px; padding-top:0px;">
                            <x-form-element
                                col="3"
                                label="Title"
                                type="text"
                                name="art_work_title[]"
                                required="required"
                            ></x-form-element>
                            <x-form-element
                                col="3"
                                label="Size"
                                type="text"
                                name="art_work_size[]"
                                required="required"
                            ></x-form-element>
                            <x-form-element
                                col="3"
                                label="Medium"
                                type="text"
                                name="art_work_medium[]"
                                required="required"
                            ></x-form-element>
                            <x-form-element
                                col="3"
                                label="Art Work"
                                type="file"
                                name="art_work_image[]"
                                required="required"
                            ></x-form-element>
                        </div>
                        <div class="more-artworks row" style="margin-top:0px; padding-top:0px;">
                            <!-- Artwork HTML will append here -->
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <span role="button" class="btn btn-sm float-end addMoreArtWork">+ Add More</span>
                            </div>
                        </div>
                        @endif

                        @if($customField)
                        @foreach ($customField as $input)
                            <x-form-element
                                col="12"
                                label="{{$input->field_label}}"
                                type="{{$input->field_type}}"
                                name="custom_{{$input->field_name}}"
                                options="{{$input->field_multi_value}}"
                                required="{{ ($input->field_is_required === 1) ? 'required' : '' }}"
                            ></x-form-element>
                        @endforeach
                        @endif
                    </div>

                    <div class="rd-form-btn text-start">
                        <button class="btn" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<script>
$(document).ready(function() {
    $(".addMoreArtWork").click(function() {
        var html = $(".artwork-fields").html();
        $(".more-artworks").append(html);
    });
});
</script>
@endsection
