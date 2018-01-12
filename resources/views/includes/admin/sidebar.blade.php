<div class="col-md-2 sidebar">
    <div class="row">
        <ul>
            <a href="{{url('admin/beats')}}"><li class="@if(strpos(Request::path(), 'admin/beats')!== false ) active @endif">BEATS</li></a>
            <a href="{{url('admin/categories')}}"><li class="@if(strpos(Request::path(), 'admin/categories')!== false ) active @endif">CATEGORIES</li></a>
            <a href="{{url('admin/sounds_like')}}"><li class="@if(strpos(Request::path(), 'admin/sounds_like')!== false ) active @endif">SOUNDS LIKE</li></a>
            <a href="{{url('admin/producers')}}"><li class="@if(strpos(Request::path(), 'admin/producers')!== false ) active @endif">PRODUCERS</li></a>
            <a href="{{url('admin/pages')}}"><li class="@if(strpos(Request::path(), 'admin/pages')!== false )active @endif">PAGES</li></a>
            <a href="{{url('admin/embed')}}"><li class="@if(Request::path() == 'admin/embed') active @endif">EMBED</li></a>
            <a href="{{url('admin/banners')}}"><li class="@if(Request::path() == 'admin/banners') active @endif">BANNERS</li></a>
            <a href="{{url('admin/shop_options')}}"><li class="@if(Request::path() == 'admin/shop_options') active @endif">SHOP OPTION</li></a>
            <a href="{{url('admin/stats')}}"><li class="@if(Request::path() == 'admin/stats') active @endif">STATS</li></a>
        </ul>
    </div>
</div>

