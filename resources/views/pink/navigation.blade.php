
@if($menu)
    <div class="menu classic">
        <ul id="nav" class="menu">
            @include(env('THEME').'.custemMenuItems',['items'=>$menu->roots()])
        </ul>

    </div>
    @endif

