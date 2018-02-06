<div class="header-navbar">
    <a href="{{url('/')}}">
        <div class="navbar-img">
            @if(!empty($logo)){{Html::image($logo, 'logo')}}@else{{Html::image('images/transactionlogo.png', 'logo')}}@endif
        </div>
    </a>
    <div class="navbar-links main-nav-header-wrapper">
        <button class="menu-toggle main-color"><i class="fa fa-bars" aria-hidden="true"></i></button>
        <ul class="clearfix main-navigation">
            @if(!empty($pages))
                @foreach($pages as $page)
                    <li><a href="{{url('/'.$page->slug)}}"><li>{{$page->title}}</a></li>
                @endforeach
            @endif
            @if((strpos($faqs, '1') !== false))
                <li><a href="{{url('/faq')}}">FAQ</a></li>
            @endif
        </ul>
    </div>
</div>
