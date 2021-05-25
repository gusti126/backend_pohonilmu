<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="../assets/img/apple-icon.png"
    />
    <link rel="icon" type="image/png" href="{{ url('backend/img/logo.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title')</title>
    <meta
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"
      name="viewport"
    />
    @include('includes.dashboar2.style')
    @stack('style')
    <style>
        .btn{
            margin: unset;
        }
    </style>
  </head>

  <body class="">

    <div class="wrapper">
      {{-- sidebar --}}
      @include('includes.dashboar2.sidebar')
      {{-- end sidebar --}}
      <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        @include('includes.dashboar2.navbar')
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
          @yield('content')
        </div>
        {{-- <footer class="footer">
          <div class="container-fluid">
            <nav>
              <ul>
                <li>
                  <a href="https://www.creative-tim.com"> Creative Tim </a>
                </li>
                <li>
                  <a href="http://presentation.creative-tim.com"> About Us </a>
                </li>
                <li>
                  <a href="http://blog.creative-tim.com"> Blog </a>
                </li>
              </ul>
            </nav>
            <div class="copyright" id="copyright">
              &copy;
              <script>
                document
                  .getElementById("copyright")
                  .appendChild(
                    document.createTextNode(new Date().getFullYear())
                  );
              </script>
              , Designed by
              <a href="https://www.invisionapp.com" target="_blank">Invision</a
              >. Coded by
              <a href="https://www.creative-tim.com" target="_blank"
                >Creative Tim</a
              >.
            </div>
          </div>
        </footer> --}}
      </div>
    </div>
    @include('includes.dashboar2.script')
    @stack('script')
    {{-- switch alert --}}
    @include('sweetalert::alert')
  </body>
</html>
