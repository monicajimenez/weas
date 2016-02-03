<!DOCTYPE html>
<html>
    <head>
        <title>EAS - @yield('sitetitle')</title>
        @include("layouts.head")
    </head>
    <body>
      <header>
          @include("layouts.nav")
      </header>
      <main>
        <div class="container">
          @yield("content")
        </div>
      </main>
      <footer class="page-footer">
          @include('layouts.footer')
      </footer>
    </body>
</html>