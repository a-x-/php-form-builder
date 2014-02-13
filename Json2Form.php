<?php
require_once('lib.php');

class Json2Form
{
    /*const*/ // fucked php!
    public static $Enctype = ['text' => 'application/x-www-form-urlencoded', 'file' => 'multipart/form-data'];

    /*const*/ // fucked php!
    public static $HttpType = ['get', 'post', 'put', 'delete'];

    // Stores all form _form_controls
    private $_form_controls = array();

    // Stores all form attributes
    private $_form_attr = array();

    private $_has_file = false;

    /**
     * Constructor to set basic form attributes
     * @param string $action
     * @param array $form_attr
     */
    function __construct($action = '', $form_attr = array())
    {
        $defaults = array(
            'action' => $action,
            'method' => 'post',
            'class' => '', // string - class list
            'id' => '',
        );
        foreach ($form_attr as $attr => $val) {
            // Try setting with user-passed setting
            // If not, try the default with the same attr name
            $this->_form_attr[$attr] = ($this->_is_form_attr_valid($attr, $val)) ? $val : $defaults[$attr];
        }
    }

    /**
     * Parse the _form_controls and build the form HTML
     * @return string
     * @todo Make general refactoring
     */
    function build_form()
    {
        if ($this->_form_attr['add_honeypot'])
            $this->add_input('Leave blank to submit', array(
                'name' => 'honeypot',
                'slug' => 'honeypot',
                'id' => 'form_honeypot',
            ));

        if ($this->_has_file)
            $this->_form_attr['enctype'] = Json2Form::$Enctype['file'];

        foreach ($this->_form_controls as $form_control) {
//            $min_max_range = $element = $end = $attr = $field = $label_html = '';
            $this->_build_input($form_control['type']);

        }

        $values = array();
        $values += $this->_form_attr;
        specify_template(eval_array(file_get_contents('defaultTemplatesCollection.json.php')), $values);
    }

    /**
     * Add an input to the queue
     * @param $label
     * @param string $args
     * @param string $slug
     */
    function add_input($label, $args = '', $slug = '')
    {

        if (empty($args)) $args = array();
        // Create slug
        if (empty($slug)) $slug = Json2Form::_make_slug($label);

        $defaults = array(
            'type' => 'text',
            'name' => $slug,
            'id' => $slug,
            'label' => $label,
            'value' => '',
            'placeholder' => '',
            'class' => '',
            'min' => '',
            'max' => '',
            'step' => '',
            'autofocus' => false,
            'checked' => false,
            'required' => false,
            'add_label' => true,
            'options' => array(),
//            'wrap_tag' => 'div',
//            'wrap_class' => array('form_field_wrap'),
//            'wrap_id' => '',
//            'wrap_style' => ''
        );

        // Combined defaults and arguments
        // Arguments override defaults
        $args = array_merge($defaults, $args);

        $this->_form_controls[$slug] = $args;

    }


    /**
     * @param $type - input (form control) type
     * @return string - input (form control) html
     * @todo WRITE _build_input()
     */
    private static function _build_input($type)
    {


        switch ($type) {
//            case 'title':
//                $element = '';
//                $end = '
//                <h3>' . $form_control['label'] . '</h3>';
//                break;

        case 'textarea':
//                $element = 'textarea';
//                $end = '>' . $form_control['value'] . '</textarea>';
            break;

        case 'select':
//                $element = 'select';
//                $end = '>' . $this->_build_select_options($form_control['options']) . '
//                </select>';
            break;

//            case 'checkbox': //TODO check possible mistake
//                if (count($form_control['options']) > 0) :
//                    $element = '';
//                    $end = $this->_output_options_checkbox($form_control['options'], $form_control['name']);
//                    $label_html = '<p class="checkbox_header">' . $form_control['label'] . '</p>';
//                    break;
//                endif;
//
//            case 'radio':
//                if (count($form_control['options']) > 0) :
//                    $element = '';
//                    $end = $this->_output_options_radios($form_control['options'], $form_control['name']);
//                    $label_html = '<p class="checkbox_header">' . $form_control['label'] . '</p>';
//                    break;
//                endif;
//
//            case 'range':
//            case 'number':
//                $min_max_range .= !empty($form_control['min']) ? ' min="' . $form_control['min'] . '"' : '';
//                $min_max_range .= !empty($form_control['max']) ? ' max="' . $form_control['max'] . '"' : '';
//                $min_max_range .= !empty($form_control['step']) ? ' step="' . $form_control['step'] . '"' : '';

        case 'submit':
//                $this->has_submit = true;
            break;

        default :
//                    $element = 'input';
//                    $end .= ' type="' . $form_control['type'] . '" value="' . $form_control['value'] . '"';
//                    $end .= $form_control['checked'] ? ' selected' : '';
//                    $end .= $this->_get_field_close();
//                    break;

        }
//        $field = '';
        $output = '';
//        $id = !empty($form_control['id']) ? ' id="' . $form_control['id'] . '"' : '';
//        $class = count($form_control['class']) ? ' class="' . Json2Form::_output_classes($form_control['class']) . '"' : '';
//        $attr = $form_control['autofocus'] ? ' autofocus' : '';
//        $attr = $form_control['checked'] ? ' checked' : '';
//        $attr = $form_control['required'] ? ' required' : '';
//
//        // Build the label
//        if (!empty($label_html)) :
//            $field .= $label_html;
//        elseif ($form_control['add_label'] && $form_control['type'] != 'hidden' && $form_control['type'] != 'submit') :
//            $form_control['label'] .= $form_control['required'] ? ' <strong>*</strong>' : '';
//            $field .= '
//					<label for="' . $form_control['id'] . '">' . $form_control['label'] . '</label>';
//        endif;
//
//        if (!empty($element))
//            $field .= '
//					<' . $element . $id . ' name="' . $form_control['name'] . '"' . $min_max_range . $attr . $end;
//        else
//            $field .= $end;
//
//        // Parse and create wrap, if needed
//        if ($form_control['type'] != 'hidden' && !empty($form_control['wrap_tag'])) :
//
//            $wrap_before = '
//				<' . $form_control['wrap_tag'];
//            $wrap_before .= count($form_control['wrap_class']) > 0 ? Json2Form::_output_classes($form_control['wrap_class']) : '';
//            $wrap_before .= !empty($form_control['wrap_style']) ? ' style="' . $form_control['wrap_style'] . '"' : '';
//            $wrap_before .= !empty($form_control['wrap_id']) ? ' id="' . $form_control['wrap_id'] . '"' : '';
//            $wrap_before .= '>';
//
//            $wrap_after = '
//				</' . $form_control['wrap_tag'] . '>';
//
//            $output .= $wrap_before . $field . $wrap_after;
//        else :
//            $output .= $field;
//        endif;

        return $output;
    }

    /**
     * Create a slug from a label name
     * @param $string
     * @return mixed|string
     * @todo  Add validation for classes and ids
     * Reviewed
     */
    private static function _make_slug($string)
    {
        $result = preg_replace('!"|\'|_!', '', $string);
        $result = preg_replace('~[\W\s]~', '-', $result);
        $result = strtolower($result);
        return $result;
    }

//    /**
//     * Easy way to auto-close fields, if necessary
//     */
//    function _get_field_close()
//    {
//        return $this->_form_attr['markup'] === 'xhtml' ? ' />' : '>';
//    }

//
//    /**
//     * Builds the multiple checkbox output
//     * @param $arr
//     * @param $name
//     * @return string
//     */
//    private function _output_options_checkbox($arr, $name)
//    {
//        $output = '';
//        foreach ($arr as $val => $opt) :
//            $slug = Json2Form::_make_slug($opt);
//            $output .= '
//						<input type="checkbox" name="' . $name . '[]" value="' . $val . '" id="' . $slug . '"';
//            $output .= $this->_form_attr['markup'] === 'xhtml' ? ' />' : '>';
//            $output .= '
//						<label for="' . $slug . '">' . $opt . '</label>';
//        endforeach;
//        return $output;
//    }
//
//    /**
//     * Builds the radio button output
//     * @param $arr
//     * @param $name
//     * @return string
//     */
//    private function _output_options_radios($arr, $name)
//    {
//        $output = '';
//        foreach ($arr as $val => $opt) :
//            $slug = Json2Form::_make_slug($opt);
//            $output .= '
//						<input type="radio" name="' . $name . '[]" value="' . $val . '" id="' . $slug . '"';
//            $output .= $this->_form_attr['markup'] === 'xhtml' ? ' />' : '>';
//            $output .= '
//						<label for="' . $slug . '">' . $opt . '</label>';
//        endforeach;
//        return $output;
//    }


    /**
     * Set attributes for the form and special fields
     * @param $key
     * @param $val
     * @return bool
     */
    private function _is_form_attr_valid($key, $val)
    {
        switch ($key) {
        case 'method':
            if (!in_array($val, Json2Form::$HttpType)) return false;
            break;
        case 'enctype':
            if (!isset(Json2Form::$Enctype[$val])) return false;
            break;
        case 'class':
        case 'id':
            if (!$this->_is_valid_attr_val($val)) return false;
            break;
        default:
            return false;
        }
        return true;
    }

    /**
     * Check html element's id or class candidate for correct characters.
     *
     * ID and NAME tokens must begin with a letter ([A-Za-z])
     * and may be followed by any number of
     * letters, digits ([0-9]), hyphens ("-"), underscores ("_"), colons (":"), and periods (".").
     * [[http://www.w3.org/TR/html401/types.html#type-name]]
     *
     * @param $string
     * @return bool
     * Reviewed
     */
    private static function _is_valid_attr_val($string)
    {
        return (bool)preg_match('/^[a-z][a-z0-9_-:.]*$/i', $string);
    }


    /**
     * @param $template_name string
     * @param $variables array of string - Placeholder replacements
     * @test echo Json2Form::_specify_template_default('option', ['value' => 'asdf', 'option' => 'jlk;']);
     * @return string - Specified html template
     */
    public static function _specify_template_default($template_name, $variables)
    {
        return specify_template(eval_array(file_get_contents('defaultTemplatesCollection.json.php'))[$template_name],
            $variables);
    }


//    /**
//     * Builds the select input output
//     * @param $arr
//     * @return string
//     * Reviewed
//     */
//    private static function _build_select_options($arr)
//    {
//        $output = '';
//        foreach ($arr as $val => $opt) :
//            $output .= _specify_template_default('option', ['value' => $val, 'option' => $opt]);
//        endforeach;
//        return $output;
//    }

//    /**
//     * Parses and builds the classes in multiple places
//     * @param $arr
//     * @return string
//     */
//    private static function _output_classes($arr)
//    {
//        $output = implode(' ', $arr);
//        return "class='$output'";
//    }

//    /**
//     * Add multiple _form_controls to the queue
//     * @param $arr
//     * @return bool
//     */
//    function add_inputs($arr)
//    {
//
//        if (!is_array($arr)) return false;
//
//        foreach ($arr as $field) :
//            $this->add_input($field[0], isset($field[1]) ? $field[1] : '', isset($field[2]) ? $field[2] : '');
//        endforeach;
//        return true;
//    }
}