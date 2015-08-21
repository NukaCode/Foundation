<?php namespace NukaCode\Bootstrap\Controllers\Admin;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use NukaCode\Bootstrap\Http\Requests\Admin\BowerTheme;
use NukaCode\Bootstrap\Http\Requests\Admin\Theme;
use NukaCode\Admin\Controllers\AdminController;
use NukaCode\Core\Remote\SSH;
use NukaCode\Bootstrap\Remote\Theme as ConsoleTheme;
use NukaCode\Bootstrap\Filesystem\Config\Theme as ConfigTheme;
use NukaCode\Bootstrap\Filesystem\Theme as MainTheme;
use NukaCode\Bootstrap\Filesystem\Less\Colors;
use NukaCode\Core\Ajax\Ajax;

class StyleController extends AdminController {

    private $ssh;

    private $theme;

    private $configTheme;

    private $colors;

    private $ajax;

    private $config;

    private $mainTheme;

    public function __construct(SSH $ssh, ConsoleTheme $theme, ConfigTheme $configTheme, Colors $colors, Ajax $ajax,
                                Repository $config, MainTheme $mainTheme)
    {
        parent::__construct();

        $this->ssh         = $ssh;
        $this->theme       = $theme;
        $this->configTheme = $configTheme;
        $this->colors      = $colors;
        $this->ajax        = $ajax;
        $this->config      = $config;
        $this->mainTheme   = $mainTheme;
    }

    public function index(Repository $config)
    {
        $laravelVersion = Application::VERSION;
        $packages       = $this->config->get('packages.nukacode');
        $currentTheme   = $this->config->get('nukacode-frontend.theme');

        $bower        = json_decode(\File::get(base_path('/bower.json')));
        $themeVersion = $bower->dependencies->$currentTheme;
        $colors       = $config->get('nukacode-frontend.colors');

        $this->setViewData(compact('laravelVersion', 'packages', 'currentTheme', 'themeVersion', 'colors'));
    }

    public function configRefresh()
    {
        $this->configTheme->refreshConfig();

        return redirect()->route('admin.style.index')->with('message', 'Config refreshed.');
    }

    public function getThemeColors()
    {
        $colors = $this->colors->getEntry();

        $availableThemes = $this->config->get('theme.themes');
        $currentTheme    = $this->config->get('theme.theme');

        $this->setViewData(compact('colors', 'availableThemes', 'currentTheme'));
    }

    public function postThemeColors(Theme $request)
    {
        // Update the colors less file
        $this->colors->updateEntry($request->except('_token'));

        // Update the config file
        $this->configTheme->refreshConfig();

        // Generate the new theme css file
        exec('node ' . base_path('node_modules/.bin/gulp'));

        return redirect()->route('admin.style.index')->with('message', 'Theme updated.');
    }

    public function getThemeChange()
    {
        $availableThemes = [];

        exec('node ' . base_path() . '/node_modules/bower/bin/bower search nukacode-bootstrap', $availableThemes);
        unset($availableThemes[0]);
        unset($availableThemes[1]);

        foreach ($availableThemes as $key => $availableTheme) {
            if (strpos($availableTheme, 'admin') !== false) {
                unset($availableThemes[$key]);
            } else {
                $availableThemes[$key] = explode(' ', trim($availableTheme))[0];
            }
        }

        $availableThemes = array_combine(array_values($availableThemes), array_values($availableThemes));

        $currentTheme = $this->config->get('theme.theme');

        $this->setViewData(compact('colors', 'availableThemes', 'currentTheme'));
    }

    public function postThemeChange(BowerTheme $request)
    {
        $currentTheme = $this->config->get('theme.theme');
        $newTheme     = $request->get('theme');

        if ($currentTheme != $newTheme) {
            // Remove the current theme
            exec('node ' . base_path('node_modules/bower/bin/bower uninstall -S ' . $currentTheme));

            // Add the new theme
            exec('node ' . base_path('node_modules/bower/bin/bower install -S ' . $newTheme));

            // Generate the new theme css file
            exec('node ' . base_path('node_modules/gulp/bin/gulp.js'));
        }

        return \Redirect::route('admin.style.index')->with('message', 'Theme updated.');
    }

    public function getBowerThemeVersions($themeName)
    {
        $versions      = false;
        $themeVersions = [];
        $themeInfo     = [];

        exec('export PATH="$PATH:/usr/bin";node ' . base_path('/node_modules/bower/bin/bower') . ' info ' . $themeName, $themeInfo);

        foreach ($themeInfo as $key => $infoPiece) {
            if (stripos($infoPiece, 'Available versions:') !== false) {
                $versions = true;
                continue;
            } elseif ($versions == false) {
                unset($themeInfo[$key]);
            } elseif ($versions == true) {
                $version = substr(explode('.', trim($infoPiece))[0], 2);

                if (is_numeric($version)) {
                    $themeVersions[$version] = $version;
                }
            }
        }

        return $themeVersions;
    }
}