<?php namespace NukaCode\Foundation\Html;

use NukaCode\Html\FormBuilder as BaseFormBuilder;

class FormBuilder extends BaseFormBuilder
{

    public    $labelSize       = 2;

    public    $inputSize       = 10;

    public    $iconSize        = 0;

    public    $type            = 'horizontal';

    public    $allowedTypes    = [
        'basic'      => null,
        'inline'     => 'form-inline',
        'horizontal' => 'form-horizontal',
    ];

    protected $previousSizes   = null;

    protected $requiredClasses = [];

    private   $view;

    public function open(array $options = [], $type = 'horizontal')
    {
        // Set the form type
        $this->setType($type);

        // Make sure the form has the proper class
        $formClass = $this->allowedTypes[$this->type];
        $options   = $this->verifyHasOption($options, 'class', $formClass);

        return parent::open($options);
    }

    public function setType($type)
    {
        if (! array_key_exists($type, $this->allowedTypes)) {
            throw new \InvalidArgumentException('Form type [' . $type . '] not allowed.');
        }

        $this->type = $type;

        return $this;
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

    public function groupOpen($labelSize = null, $inputSize = null, $iconSize = null)
    {
        if ($labelSize != null) {
            $this->previousSizes = [$this->labelSize, $this->inputSize, $this->iconSize];

            $this->setSizes($labelSize, $inputSize, $iconSize);
        }

        $classes = implode(' ', $this->requiredClasses);

        return <<<HTML
<div class="form-group {$classes}">
HTML;
    }

    public function groupClose()
    {
        if ($this->previousSizes != null) {
            call_user_func_array([$this, 'setSizes'], $this->previousSizes);

            $this->previousSizes = null;
        }

        $inputClose = $this->getInputWrapperClose();

        return <<<HTML
    $inputClose
</div>
HTML;
    }

    public function offsetGroupOpen($labelSize = null, $inputSize = null, $iconSize = null)
    {
        if ($labelSize != null) {
            $this->previousSizes = [$this->labelSize, $this->inputSize, $this->iconSize];

            $this->setSizes($labelSize, $inputSize, $iconSize);
        }

        $classes = implode(' ', $this->requiredClasses);

        if ($this->type == 'horizontal') {
            return <<<HTML
    <div class="form-group {$classes}">
        <div class="col-md-offset-{$this->labelSize} col-md-{$this->inputSize}">
HTML;
        }

        return <<<HTML
    <div class="form-group {$classes}">
HTML;
    }

    public function offsetGroupClose()
    {
        if ($this->previousSizes != null) {
            call_user_func_array([$this, 'setSizes'], $this->previousSizes);

            $this->previousSizes = null;
        }

        $inputClose = $this->getInputWrapperClose();

        if ($this->type == 'horizontal') {
            return <<<HTML
        $inputClose
    </div>
HTML;
        }

        return <<<HTML
    $inputClose
</div>
HTML;
    }

    public function label($name, $value = null, $options = [])
    {
        switch ($this->type) {
            case 'inline':
                $options = $this->verifyHasOption($options, 'class', 'sr-only');
                break;
            case 'horizontal':
                $options = $this->verifyHasOption($options, 'class', 'col-md-' . $this->labelSize);
                $options = $this->verifyHasOption($options, 'class', 'control-label');
                break;
        }

        return parent::label($name, $value, $options);
    }

    public function hidden($name, $value = null, $options = [])
    {
        // Set up the attributes
        $options = $this->verifyAttributes('text', $options);

        return parent::hidden($name, $value, $options);
    }

    public function help($text, $options = [])
    {
        $options = $this->verifyAttributes('help', $options);

        return $this->html->span($text, $options);
    }

    public function icon($class, $options = [])
    {
        $options = $this->verifyHasOption($options, 'class', 'form-control-feedback');
        $options = $this->verifyHasOption($options, 'class', $class);

        if (strpos($class, 'fa fa') !== false) {
            // For font-awesome, increase the offset
            $options = $this->verifyHasOption($options, 'style', 'top: 30px;');
        }

        $options['aria-hidden'] = 'true';

        return $this->html->span(null, $options);
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

    public function select2($name, $optionsArray, $selected, $options = [], $label = null, $placeholder = null)
    {
        // Set up the attributes
        $options  = $this->verifyAttributes('select2', $options);
        $multiple = in_array('multiple', $options);

        // Create the default input
        $input = parent::select($name, $optionsArray, $selected, $options);

        // Add the jquery
        $this->setSelect2Requirements($options['id'], $placeholder, $multiple);

        return $this->createOutput($name, $label, $input);
    }

    public function color($name, $value, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('color', $options);

        $this->setColorRequirements();

        // Create the default input
        $input = parent::text($name, $value, $options);
        $input = <<<HTML
        <div class="input-group">
            <span class="input-group-addon" id="colorPreview{$name}" style="background-color: {$value};">&nbsp;</span>
            $input
        </div>
HTML;

        return $this->createOutput($name, $label, $input);
    }

    protected function createOutput($name, $label, $input)
    {
        // Set up the label
        $label = $label != null ? $this->label($name, $label) : null;

        $inputOpen = $this->getInputWrapperOpen();

        $this->requiredClasses = [];

        return <<<HTML
			$label
			$inputOpen
			$input
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

    protected function setColorRequirements()
    {
        static $exists = false;
        if (! $exists) {
            $this->addToSection('onReadyJs', '
$(\'.colorpicker\').colorpicker().on(\'changeColor\', function(ev){
	$(\'#colorPreview\'+ $(this).attr(\'name\')).css(\'background-color\', ev.color.toHex());
});
			'
            );
            $exists = true;
        }
    }

    protected function setSelect2Requirements($id, $placeholder, $multiple)
    {
        if ($multiple) {
            $script = <<<HTML
@parent
$('#$id').select2({placeholder: '$placeholder',allowClear: true});
HTML;
        } else {
            $script = <<<HTML
@parent
$('#$id')
			 .prepend('<option/>')
			 .val(function(){return $('[selected]',this).val() ;})
			 .select2({
				placeholder: '$placeholder',
				allowClear: true
			 });
HTML;
        }

        return $this->addToSection('onReadyJs', $script);
    }

    public function verifyAttributes($input, $options)
    {
        // Input specific attributes
        if ($input == 'color') {
            $options = $this->verifyHasOption($options, 'class', 'colorpicker');
        }
        if ($input == 'select2') {
            if (! isset($options['id'])) {
                $options['id'] = \Str::random(10);
            }
        }
        if ($input == 'help') {
            return $this->verifyHasOption($options, 'class', 'help-block');
        }

        // All inputs
        $options = $this->verifyHasOption($options, 'class', 'form-control');

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
            case 'horizontal':
                return '<div class="col-md-' . $this->inputSize . '">';
                break;
        }

        return null;
    }

    protected function getIconWrapperOpen()
    {
        switch ($this->type) {
            case 'horizontal':
                return '<div class="col-md-' . $this->iconSize . '">';
                break;
        }

        return null;
    }

    protected function getInputWrapperClose()
    {
        switch ($this->type) {
            case 'horizontal':
                return '</div>';
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
