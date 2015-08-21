<!-- javascript-->
{!! HTML::script('js/all.js') !!}

<!-- JS Include -->
@section('jsInclude')
@show
<!-- JS Include Form -->
@section('jsIncludeForm')
@show

<script>
$(document).ready(function() {
//    bootbox.setDefaults({backdrop: false});
//
//    $("a.confirm-remove").click(function(e) {
//        e.preventDefault();
//        var location = $(this).attr('href');
//        bootbox.dialog({
//            message: "Are you sure you want to remove this item?",
//            buttons: {
//                success: {
//                    label: "Yes",
//                    className: "btn-primary",
//                    callback: function() {
//                        window.location.replace(location);
//                    }
//                },
//                danger: {
//                    label: "No",
//                    className: "btn-primary"
//                }
//            }
//        });
//    });
//    $("a.confirm-continue").click(function(e) {
//        e.preventDefault();
//        var location = $(this).attr('href');
//        bootbox.dialog({
//            message: "Are you sure you want to continue?",
//            buttons: {
//                danger: {
//                    label: "No",
//                    className: "btn-primary"
//                },
//                success: {
//                    label: "Yes",
//                    className: "btn-primary",
//                    callback: function() {
//                        window.location.replace(location);
//                    }
//                },
//            }
//        });
//    });

    Messenger.options = {
        extraClasses: 'messenger-fixed {{ isset($this->activeUser) ? $this->activeUser->alertLocation : "messenger-on-top" }}',
        theme: 'future'
    }

    var mainErrors = {!! (Session::get('errors') != null ? json_encode(implode('<br />', Session::get('errors')->all())) : 0) !!};
    var mainStatus = {!! (Session::get('message') != null ? json_encode(Session::get('message')) : 0) !!};
    var mainLogins = {!! (Session::get('login_errors') != null ? json_encode(Session::get('login_errors')) : 0) !!};

    if (mainLogins == true) {
        Messenger().post({
            message: mainLogins,
            type: 'error',
            showCloseButton: true
        });
    }
    if (mainErrors != 0) {
        Messenger().post({
            message: mainErrors,
            type: 'error',
            showCloseButton: true
        });
    }
    if (mainStatus != 0) {
        Messenger().post({
            message: mainStatus,
            showCloseButton: true
        });
    }

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