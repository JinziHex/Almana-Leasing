@extends('admin.layouts.app')
@section('content')
<style>
   /* #bukingtable{
        width: 100%;
        border-collapse: collapse !important;
        background: #eee;
        border-radius: 5px;
        overflow: hidden;
    }
     #bukingtable th{
             border-top: none;
            border-bottom-color: #fff;
            background: rgba(0,0,0,.1);
            border-right: 1px solid #fff;
     }
     #bukingtable th:last-child{
         border-right:none;
         
     }
     .bookpaginate ul.pagination{
         justify-content: flex-end;
     }
     .bookpaginate .page-item:first-child .page-link{
         text-decoration:underline;
         font-size: 0;
     }
     .bookpaginate .page-link{
         border: none;
        color: #5A738E!important;
     }
     .bookpaginate .page-item:last-child .page-link{
         text-decoration:underline;
         font-size: 0;
     }
     .bookpaginate .page-item.active .page-link{
         background-color:transparent;
         border-color:transparent;
     }
     .bookpaginate .page-link:hover{color:#0056b3!important; background:transparent;}
     .bookpaginate .page-link:focus{box-shadow:none;}
     .bookpaginate .page-item:first-child .page-link::after{content:'Previous'; font-size: 13px;}
     .bookpaginate .page-item:last-child .page-link::after{content:'Next'; font-size: 13px;}
     li.page-item.active span {color: #007bff !important;}*/
</style>

@php
use App\Models\Mode_rate;
use App\Models\Modal;
@endphp
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <!-- Filter -->
            <form method="GET" action="">
               @csrf
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>{{ __('Models')}}</label>
                        <select class="form-control" name="book_models">
                           <option value="">--All models --</option>
                           @foreach($bookModel as$bookModels)
                           <option value="{{$bookModels->modal_id}}" {{ $bookModels->modal_id == $modelss ? 'selected' : '' }}>
                                {{$bookModels->modal_name}}
                                @if(isset($bookModels->category))
                                    - {{$bookModels->category->model_cat_name}}
                                @endif
                            </option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="col-md-12 col-sm-12">
                           <input type="submit" class="btn btn-block btn-primary" value="Filter">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="col-md-12 col-sm-12">
                           <a href="{{route('admin.modelrate.report')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            <!--filter ends-->
            <div class="table-responsive">
               <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ __('Sl No.') }}</th>
                         <th class="wd-15p">{{ __('Year') }}</th>
                        <th class="wd-15p">{{ __('Model') }}</th>
                        <th class="wd-15p">{{ __('Rate type') }}</th>
                        <th class="wd-15p">{{ __('Rate') }}</th>
                        <!--<th class="wd-15p">{{ __('Min Rate') }}</th>-->
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @isset($result)
                     @foreach($result as $results)
                     @php
                     $getModelId = $results->modal_id;
                     $getMakerId = $results->makers;
                     
                     $rateDetail = Mode_rate::where('model_id','=',$getModelId)->where('maker_id','=',$getMakerId)->orderBy('model_rate_id','DESC')->get();
                     
                     @endphp
                     @foreach($rateDetail as $rateDetails)
                     @php $i++; @endphp
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $rateDetails->model_year }} </td>
                        <td>{{ $rateDetails->models->modal_name ?? 'N/A' }}-{{ $rateDetails->models->category->model_cat_name ?? 'N/A' }}</td>
                        <td>{{ $rateDetails->rates->rate_type_name ?? 'N/A' }}</td>
                        <td>{{ $rateDetails->rate }}</td>
                        <!--<td>{{ $rateDetails->rate}}</td>-->
                       
                     </tr>
                     @endforeach
                     @endforeach
                     @endif
                  </tbody>
               </table>
               
            </div>
            
            
         </div>
      </div>
   </div>
</div>
</div>
<script>

$('#example').DataTable({
 
 dom: 'Bflrtip',
 buttons: [
    { extend: 'copy',title:"booking", className: 'btn btn-info glyphicon glyphicon-duplicate' },
  { extend: 'csv',title:"booking", className: 'btn btn-success glyphicon glyphicon-save-file' },
  { extend: 'excel',title:"booking", className: 'btn btn-success glyphicon glyphicon-list-alt' },
  { extend: 'pdf',title:"booking",className: 'btn btn-danger glyphicon glyphicon-file' },
  { extend: 'print',title:"booking", className: 'btn btn-warning glyphicon glyphicon-print' }
 ]
});

</script>
@endsection