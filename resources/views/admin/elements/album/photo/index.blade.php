@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $pageTitle }}</h3>
            </div>
            <div class="card-body">
                <a href="{{route('admin.photos.create')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
                @if(session('status'))
                <div class="alert alert-success" id="err_msg">
                    <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                </div>
                @endif
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th class="wd-15p">{{ __('Sl No.') }}</th>
                                <th class="wd-15p">{{ __('Title') }}</th>
                                <th class="wd-15p">{{ __('Album') }}</th>
                                <th class="wd-15p">{{ __('Photo') }}</th>
                                <th class="wd-15p">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($photos as $key=>$photo)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $photo->photo_title }}</td>
                                <td>{{ $photo->album->title ?? '' }}</td>
                                <td style="text-align: left; direction: rtl;"><img src="{{url('/assets/uploads/album/photo/'.$photo->photo_image)}}" width="30" height="30"></td>
                                <td>
                                    <a href="{{route('admin.photos.edit',[$photo->id])}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>&nbsp;
                                    <a href="{{route('admin.photos.destroy',[$photo->id])}}" class="btn btn-sm btn-danger frmsubmit" method="DELETE"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a>
                                </td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on("click", 'a.frmsubmit', function(e) {
        var message = '';
        if (e.currentTarget.attributes.message != undefined) {
            message = e.currentTarget.attributes.message.value;
        } else {
            message = 'Are you sure you want delete ?';
        }
        if (message != 'false') {
            if (confirm(message)) {
                e.preventDefault();
                var myForm = '<form id="hidfrm" action="' + e.currentTarget.attributes.href.value + '" method="post">{{@csrf_field()}}<input type="hidden" name="_method" value="' + e.currentTarget.attributes.method.value + '"></form>';
                $('body').append(myForm);
                myForm = $('#hidfrm');
                myForm.submit();
            }
        } else {
            e.preventDefault();
            var myForm = '<form id="hidfrm" action="' + e.currentTarget.attributes.href.value + '" method="post">{{@csrf_field()}}<input type="hidden" name="_method" value="' + e.currentTarget.attributes.method.value + '"></form>';
            $('body').append(myForm);
            myForm = $('#hidfrm');
            myForm.submit();
        }
        return false;
    });
</script>
@endsection