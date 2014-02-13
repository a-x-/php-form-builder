<?php
/**
 * @file php-form-builder / index.php
 * Created: 12.02.14 / 23:44
 */
require_once('Json2Form.php');
echo specify_template('<qwee AA="">', ['AA' => '123']);
echo Json2Form::_specify_template_default('option', ['value' => 'asdf', 'option' => 'jlk;']);
