@if (\Menu::count() > 0)
    @include('layouts.menus.'. config('nukacode/front-end::config.menu'))
@endif
