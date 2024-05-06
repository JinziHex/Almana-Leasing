@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 card-title">{{ $pageTitle }}</h3>
            </div>
            @if (count($errors) > 0)
            <div class="alert alert-danger" id="err_msg">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(session('status'))
            <div class="alert alert-success" id="err_msg">
                <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <form action="{{route('admin.albums.update',[$album->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{method_field('PATCH')}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Title') }}</label>
                                <input type="text" name="title" required="required" value="{{$album->title}}" class="form-control">
                            </div>
                        </div>

                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group">-->
                        <!--        <label class="form-label">{{ __('Photo') }} (Supported Formats: .png,.jpg,.jpeg)</label>-->
                        <!--        <input type="file" name="photo" class="form-control" accept=".png,.jpg,.jpeg">-->
                        <!--        @if($album->photo)-->
                        <!--        <img src="{{url('/assets/uploads/album/'.$album->photo)}}" width="50" height="50">-->
                        <!--        @endif-->
                        <!--    </div>-->
                        <!--</div>-->

                        <div class="col-md-12">
                            <div class="form-group">
                                <center>
                                    <input type="submit" class="btn btn-success" value="Update">
                                    <a class="btn btn-danger" href="{{ route('admin.albums.index') }}">Cancel</a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection