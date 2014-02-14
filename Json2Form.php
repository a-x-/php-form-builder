<?php
require_once('lib.php');

class Json2Form
{
    /**
     * Create a slug from a label name
     * @param $string
     * @return mixed|string
     * @todo  Add validation for classes and ids
     * Reviewed
     */
    public static function _make_slug($string)
    {
        $result = preg_replace('!"|\'|_!', '', $string);
        $result = preg_replace('~[\W\s]~', '-', $result);
        $result = strtolower($result);
        return $result;
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
    public static function _is_valid_attr_val($string)
    {
        return (bool)preg_match('/^[a-z][a-z0-9_-:.]*$/i', $string);
    }


    /**
     * @param $template_name string
     * @param $variables array of string - Placeholder replacements
     * @test echo Json2Form::_specify_template_default('option', ['value' => 'ADA', 'option' => 'jlk;']);
     * @return string - Specified html template
     */
    public static function _specify_template_default($template_name, $variables)
    {
        return trim(specify_template(eval_array(file_get_contents('defaultTemplatesCollection.json.php'))[$template_name],
            $variables));
    }


}