@if ($item->isDropDown() && $item->hasLinks())
    <li class="dropdown {{ $item->active ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
        <ul class="dropdown-menu">
            @each('layouts.menus.foundation.item', $item->links, 'item')
        </ul>
    </li>
@else
    <a class="item {!! $item->active ? 'active' : '' !!}" href="{{ $item->url }}">
        <i class="{{ $item->getOption('icon') }}"></i>
        <label>{{ $item->name }}</label>
    </a>
@endif