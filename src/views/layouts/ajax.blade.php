@section('ajaxCss')
@show
@section('cssForm')
@show

@if (isset($content))
    {!! $content !!}
@else
    @yield('content')
@endif

        <!-- JS Include -->
@section('jsInclude')
@show

        <!-- JS Include Form -->
@section('jsIncludeForm')
@show

<script>
    $('.ajaxLink').on('click', function () {

        $('.ajaxLink').parent().removeClass('active');
        $(this).parent().addClass('active');

        var link = $(this).attr('data-location');

        $('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
        $('#ajaxContent').load(link);
        $("html, body").animate({scrollTop: 0}, "slow");
    });
    $(document).ready(function () {
        // On Ready Js
        @section('onReadyJs')
        @show
        // On Ready Js Form
        @section('onReadyJsForm')
        @show

    });
</script>

<!-- JS -->
@section('js')
@show

        <!-- JS Form -->
@section('jsForm')
@show
