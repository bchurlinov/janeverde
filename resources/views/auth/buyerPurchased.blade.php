@if(count($userProducts) > 0)
    @foreach($userProducts as $index => $singleProduct)

        {{$singleProduct['title']}}
    @endforeach
@else
    {{"No purchase history"}}
@endif
