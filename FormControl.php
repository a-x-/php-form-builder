<?php

/**
 * @file php-form-builder / FormControl.php
 * Created: 14.02.14 / 12:35
 */
class FormControl
{
    private $_templates_collection_file;

    function __construct($templates_collection_file)
    {
        $this->_templates_collection_file = $templates_collection_file;

    }

    function build()
    {
    }
}

class TextFormControl extends FormControl
{

}

;

class ButtonFormControl extends FormControl
{

}

;

class TextareaFormControl extends FormControl
{

}

;