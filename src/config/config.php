<?php

return [

    'type' => 'foundation',
    /*
    |--------------------------------------------------------------------------
    | Site Theme
    |--------------------------------------------------------------------------
    |
    | The site theme is used to overload the coreOld changes to foundation.
    | The available themes are located in nukacode/coreOld/assets/less/themes.
    | You can also make your own in app/assets/less/themes.  Dark is provided
    | as an example.  Use 'default' if you want to use the base style.  Set
    | src to local to use files in app or vendor to use the files from core.
    |
    */
    'theme' => 'nukacode-foundation-base',

    /*
    |--------------------------------------------------------------------------
    | Theme colors
    |--------------------------------------------------------------------------
    |
    | These are the colors that will be used throughout your theme.
    |
    */
    'colors' => [
        'bg'      => '#ffffff',
        'gray'    => '#343838',
        'primary' => '#5097b5',
        'info'    => '#3b81ba',
        'success' => '#62c462',
        'warning' => '#e38928',
        'danger'  => '#ba403b',
        'menu'    => '#76c6e8',
    ],

    /*
    |--------------------------------------------------------------------------
    | Site Details
    |--------------------------------------------------------------------------
    |
    | The name of your site and the icon it should use.  This will show up when
    | twitter is selected as the menu.  Set the siteIcon to null for no icon.
    |
    */

    'siteName' => 'YOUR_SITE',
    'siteIcon' => null,

    /*
    |--------------------------------------------------------------------------
    | Application Menu
    |--------------------------------------------------------------------------
    |
    | This variable is used to determine if the site uses the default twitter nav
    | bar or any form of custom menu.  Set this value to the name of the blade
    | located in views/layouts/menus that you wish to use.
    | Included Options: twitter, utopian
    |
    */
    'menu' => 'foundation',

    /*
    |--------------------------------------------------------------------------
    | Alias Exclusion
    |--------------------------------------------------------------------------
    |
    | Use the following array to stop foundation from setting certain classes and keep
    | the Laravel defaults.  This is less likely to be used since Laravel 5+ but
    | it has been left in should it ever be needed.
    |
    */
    'excludeAliases' => [],
];