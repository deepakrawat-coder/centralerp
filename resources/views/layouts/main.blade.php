@include('panels.header-top')
@yield('styles')
@yield('schema')


@include('panels.header-bottom')
@include('panels.menu')
@include('panels.side-menu')
@yield('content')
@include('panels.footer-top')
@yield('scripts')
@include('panels.footer-bottom')