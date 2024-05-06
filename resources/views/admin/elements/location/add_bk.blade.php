@extends('admin.layouts.app')
@section('content')
    @php
    header('Content-Type: text/html; charset=utf-8');
    @endphp
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
                                <li>{{ $error }}<button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success" id="err_msg">
                        <p>{{ session('status') }}<button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">×</button></p>
                    </div>
                @endif
                <form name="locForm" action="{{ route('admin.location.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="174" name="country_id">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <select required="required" class="form-control" name="city_id">
                                    <option value="">--Select a City--</option>
                                    @foreach ($city as $citys)
                                        <option {{ old('city_id') == $citys->city_id ? 'selected' : '' }}
                                            value="{{ $citys->city_id }}">{{ $citys->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Location Name') }}</label>
                                    <input type="text" id="location_name" name="location_name" required="required"
                                        class="form-control" value="{{ old('location_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Location Name (Arabic)') }}</label>
                                    <input type="text" id="arabic_location_name" name="arabic_location_name" required="required"
                                        class="form-control" dir="rtl" lang="ar" value="{{ old('arabic_location_name') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <center>
                                        <button type="button" onclick="submitForm()" class="btn btn-raised btn-primary">
                                            <i class="fa fa-check-square-o"></i> Add</button>
                                        <button type="reset" class="btn btn-raised btn-success">
                                            Reset</button>
                                        <a class="btn btn-danger" href="{{ route('admin.location') }}">Cancel</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <script>
function submitForm()
{
   
document.locForm.submit();
}

</script>
@endsection
