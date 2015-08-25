<?php namespace NukaCode\Foundation\Html;

use NukaCode\Html\FormBuilder as BaseFormBuilder;

class FormBuilder extends BaseFormBuilder
{

    public $labelSize = 2;

    public $inputSize = 10;

    public $iconSize = 0;

    public $type;

    protected $requiredClasses = [];

    public function open(array $options = [], $type = null)
    {
        if (! is_null($type)) {
            $this->type = $type;
        }

        return parent::open($options);
    }

    public function setSizes($labelSize, $inputSize = null, $iconSize = 0)
    {
        $this->labelSize = $labelSize;

        if ($inputSize == null) {
            $inputSize = 12 - $labelSize;
        }
        $this->inputSize = $inputSize;
        $this->iconSize  = $iconSize;

        return $this;
    }

    public function label($name, $value = null, $options = [])
    {

        if ($this->type == 'inline') {
            $options = $this->verifyHasOption($options, 'class', 'right');
            $options = $this->verifyHasOption($options, 'class', 'inline');

            $label = parent::label($name, $value, $options);
            $size  = $this->labelSize;

            return <<<HTML
    <div class="row">
      <div class="small-$size columns">
        $label
      </div>
HTML;
        }

        return parent::label($name, $value, $options);
    }

    public function hidden($name, $value = null, $options = [])
    {
        // Set up the attributes
        $options = $this->verifyAttributes('text', $options);

        return parent::hidden($name, $value, $options);
    }

    public function date($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('date', $options);

        // Create the default input
        $input = $this->input('date', $name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function text($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('text', $options);

        // Create the default input
        $input = parent::text($name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function staticInput($value = null, $options = [], $label = null)
    {
        // Create the default input
        $input = '<p class="form-control-static">' . $value . '</p>';

        return $this->createOutput(null, $label, $input);
    }

    public function textarea($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('textarea', $options);

        // Create the default input
        $input = parent::textarea($name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function email($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('email', $options);

        // Create the default input
        $input = parent::email($name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function password($name, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('password', $options);

        // Create the default input
        $input = parent::password($name, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function select($name, $list = [], $selected = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('select', $options);

        // Create the default input
        $input = parent::select($name, $list, $selected, $options);

        return $this->createOutput($name, $label, $input);
    }

    protected function createOutput($name, $label, $input)
    {
        // Set up the label
        $label = $label != null ? $this->label($name, $label) : null;

        $inputOpen  = $this->getInputWrapperOpen();
        $inputClose = $this->getInputWrapperClose();

        $this->requiredClasses = [];

        return <<<HTML
			$label
			$inputOpen
			$input
			$inputClose
HTML;
    }

    protected function createSelectable($type, $name, $value, $checked, $options, $label, $inline)
    {
        $class = $inline ? $type . '-inline' : $type;

        return '
		<div class="' . $class . '">
			<label>' .
               parent::$type($name, $value, $checked, $options) . ' ' . $label . '
            </label>
		</div>
		';
    }

    public function checkbox($name, $value = null, $checked = false, $options = [], $label = null, $inline = false)
    {
        $input = $this->createSelectable('checkbox', $name, $value, $checked, $options, $label, $inline);

        return $this->createSmallOutput($name, $label, $input);
    }

    public function radio($name, $value = null, $checked = false, $options = [], $label = null, $inline = false)
    {
        $input = $this->createSelectable('radio', $name, $value, $checked, $options, $label, $inline);

        return $this->createSmallOutput($name, $label, $input);
    }

    protected function createSmallOutput($name, $label, $input)
    {
        $this->requiredClasses = [];

        return <<<HTML
			$input
HTML;
    }

    public function verifyAttributes($input, $options)
    {
        if (! empty($this->requiredClasses)) {
            foreach ($this->requiredClasses as $class) {
                $options = $this->verifyHasOption($options, 'class', $class);
            }
        }

        return $options;
    }

    protected function getInputWrapperOpen()
    {
        switch ($this->type) {
            case 'inline':
                return '<div class="small-' . $this->inputSize . ' columns">';
                break;
        }

        return null;
    }

    protected function getIconWrapperOpen()
    {
        switch ($this->type) {
            case 'inline':
                return '<div class="small-' . $this->iconSize . '" columns>';
                break;
        }

        return null;
    }

    protected function getInputWrapperClose()
    {
        switch ($this->type) {
            case 'inline':
                return '</div></div>';
                break;
        }

        return null;
    }

    public function __call($name, $arguments)
    {
        $name = $this->checkForSizes($name, $arguments);
        $name = $this->checkForStates($name, $arguments);
        $name = $this->checkForOptionals($name, $arguments);

        return call_user_func_array([$this, $name], $arguments);
    }

    private function checkForSizes($name, $arguments)
    {
        $sizes = ['lg', 'sm', 'Lg', 'Sm'];

        if ($this->strpos_array($name, $sizes) !== false) {
            preg_match('/(' . implode('|', $sizes) . ')/', $name, $result);

            $class = strtolower($result[1]);

            switch ($this->type) {
                case 'horizontal':
                    $this->requiredClasses[] = 'form-group-' . $class;
                    break;
                default:
                    $this->requiredClasses[] = 'input-' . $class;
                    break;
            }
            $method = lcfirst(str_replace($sizes, '', $name));

            return $method;
        }

        return $name;
    }

    private function checkForStates($name, $arguments)
    {
        $states = ['success', 'warning', 'error', 'Success', 'Warning', 'Error'];

        if ($this->strpos_array($name, $states) !== false) {
            preg_match('/(' . implode('|', $states) . ')/', $name, $result);

            $class = strtolower($result[1]);

            $this->requiredClasses[] = 'has-' . $class;

            $method = lcfirst(str_replace($states, '', $name));

            return $method;
        }

        return $name;
    }

    private function checkForOptionals($name, $arguments)
    {
        $optionals = ['feedback', 'Feedback'];

        if ($this->strpos_array($name, $optionals) !== false) {
            preg_match('/(' . implode('|', $optionals) . ')/', $name, $result);

            $class = strtolower($result[1]);

            $this->requiredClasses[] = 'has-' . $class;

            $method = lcfirst(str_replace($optionals, '', $name));

            return $method;
        }

        return $name;
    }

    private function strpos_array($haystack, $needles, $offset = 0)
    {
        if (is_array($needles)) {
            pp($needles);
            foreach ($needles as $needle) {
                $pos = $this->strpos_array($haystack, $needle);
                if ($pos !== false) {
                    return $pos;
                }
            }

            return false;
        } else {
            return strpos($haystack, $needles, $offset);
        }
    }
}
