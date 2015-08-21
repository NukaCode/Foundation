<div class="icon-bar vertical fixed five-up" style="width:inherit">
    @if (\Menu::exists('leftMenu') && \Menu::hasLinks('leftMenu'))
        @each('layouts.menus.foundation.item', \Menu::render('leftMenu')->links, 'item')
    @endif
    @if (\Menu::exists('rightMenu') && \Menu::hasLinks('rightMenu'))
        @each('layouts.menus.foundation.item', \Menu::render('rightMenu')->links, 'item')
    @endif
</div>