<?php namespace NukaCode\Foundation\Html;

use NukaCode\Html\HtmlBuilder as BaseHtmlBuilder;

class HtmlBuilder extends BaseHtmlBuilder {

    public function mark($value, $attributes = [])
    {
        return '<mark' . static::attributes($attributes) . '>' . $value . '</mark>';
    }

    public function small($value, $attributes = [])
    {
        return '<small' . static::attributes($attributes) . '>' . $value . '</small>';
    }

    public function code($value, $attributes = [])
    {
        return '<code' . static::attributes($attributes) . '>' . e($value) . '</code>';
    }

    public function lead($value)
    {
        return '<p class="lead">' . $value . '</p>';
    }

    public function description($list, $attributes = [])
    {
        $html = '';

        foreach ($list as $bold => $text) {
            $html .= '<dt>' . $bold . '</dt>';
            $html .= '<dd>' . $text . '</dd>';
        }

        return '<dl' . static::attributes($attributes) . '>' . $html . '</dl>';
    }

    public function kbd($keys)
    {
        if (is_array($keys)) {
            return '<kbd>' . implode(' + ', array_map([$this, 'kbd'], $keys)) . '</kbd>';
        }

        return '<kbd>' . $keys . '</kbd>';
    }

    public function embed($url, $aspect = '16by9')
    {
        $validAspects = ['16by9', '4by3'];

        if (! in_array($aspect, $validAspects)) {
            throw new \InvalidArguementException('Aspect ratio not recognized.');
        }

        return '
            <div class="embed-responsive embed-responsive-' . $aspect . '">
                <iframe class="embed-responsive-item" src="' . $url . '"></iframe>
            </div>';
    }
}