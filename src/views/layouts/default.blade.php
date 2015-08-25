<!doctype html>
<html>
    <head>
        @include('layouts.partials.header')
    </head>
    <body>
        <div class="medium-1 columns" style="padding:0; height: 100%;">
            @include('layouts.partials.menu')
        </div>

        <div class="small-11 columns" style="padding:0; margin-top: 5px;">
            @if (isset($content))
                {!! $content !!}
            @else
                @yield('content')
            @endif
        </div>

        @include('layouts.partials.modals')

        @include('layouts.partials.javascript')

    </body>
</html>