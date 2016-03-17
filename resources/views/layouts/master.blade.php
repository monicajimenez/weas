<!DOCTYPE html>
<html>
    <head>
        <title>EAS - @yield('sitetitle')</title>
        @include("layouts.head")
    </head>
    <body>
      @if(
        strpos(Request::path(),'/') === 0 ||
        strpos(Request::path(),'login') === 0 ||
        strpos(Request::path(),'logout') === 0
      )
      @else
        <header>
          @include("layouts.nav")
        </header>
      @endif
      <main class="valign-wrapper">
        <div class="container">
          @yield("content")
        </div>
      </main>
      <footer class="page-footer">
          @include('layouts.footer')
      </footer>
    </body>
</html>