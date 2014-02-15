<?php

/**
 * @file php-form-builder / FormControl.php
 * Created: 14.02.14 / 12:35
 */
class FormControl extends Json2Form
{
    protected $_abstractHtml;

    function __construct()
    {
    }

    function build()
    {
        return $this->_abstractHtml;
    }
}

class AbstractTextFormControl extends FormControl
{
    function __construct($attr)
    {
        $this->_abstractHtml = Json2Form::_specify_template_default('abstract-text', $attr);
    }

}


class AbstractButtonFormControl extends FormControl
{
    function __construct($attr)
    {
        $this->_abstractHtml = Json2Form::_specify_template_default('abstract-button', $attr);
    }
}


class AbstractTextareaFormControl extends FormControl
{
    function __construct($attr)
    {
        $this->_abstractHtml = Json2Form::_specify_template_default('abstract-textarea', $attr);
    }
}

/**
 * Class AbstractSelectFormControl
 * @todo add caption abstraction: caption as a first option with disable attr
 */
class AbstractSelectFormControl extends FormControl
{
    private $_optionHtml;
    private $_optCollection;

    function __construct($attr, $optCollection)
    {
        $optCollectionHtml = '';
        foreach ($optCollection as $opt) {
            $optCollectionHtml .= $this->_optionHtml = Json2Form::_specify_template_default('option', $opt);
        }
        $attr['opt-collection'] = $optCollectionHtml;

        $this->_abstractHtml = Json2Form::_specify_template_default('abstract-select', $attr);
        $this->_optCollection = $optCollection;
    }
}
