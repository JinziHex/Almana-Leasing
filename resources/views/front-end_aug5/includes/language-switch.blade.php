<div class="flex justify-center pt-8 sm:justify-start sm:pt-0 flag">
    @php
    $available_locales=['English'=>'en','Arabic'=>'ar'];
    $current_locale=session()->get('locale');
    @endphp
  
   
         @if($current_locale=='ar')
            <a class="ml-1 underline ml-2 mr-2" href="{{route('change.language','en')}}">
                <span><img src="{{URL::to('assets/front/themes/rental/images/eng.png')}}"></span>
            </a>  
         @else
          <a class="ml-1 underline ml-2 mr-2" href="{{route('change.language','ar')}}">
                <span><img src="{{URL::to('assets/front/themes/rental/images/arb.png')}}"></span>
            </a>  
         @endif
     
  
</div>