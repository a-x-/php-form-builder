<?php
/**
 * @file php-form-builder / lib.php
 * Created: 07.02.14 / 7:56
 */

/**
 * Substitution available variables in placeholders in $template
 * Absolutely none global now (tanks to lambdas)!
 * @param $template                  string                         Aim text
 * @param $vars                      array of mixed                 Variables' array
 * @param $specialValuesForKeyValues array of tuple<string,string>  Example: array('img' => array('', '../media/none.png'))
 *                                   ,                              {needleKey => [needleValue, replacementValue],,,}
 * @return                           string                         Result
 * @todo critical - add html attr replace
 */
function substVars($template, $vars, $specialValuesForKeyValues = array())
{
    return preg_replace_callback('/%%([a-z_-]+?)%%/i',
        function ($matches) use ($vars, $specialValuesForKeyValues) {
            if (
                $specialValuesForKeyValues &&
                array_key_exists($matches[1] /*needle var`s Name*/, $specialValuesForKeyValues) &&
                $vars[$matches[1]] /*needle var`s Value*/ == $specialValuesForKeyValues[$matches[1]][0] /*replacement Value*/
            )
                return $specialValuesForKeyValues[$matches[1]][1];
            if (!isset($vars[$matches[1]])) errorHandle("substVarsSafety(): placeholder '$matches[1]' haven't value");
            return $vars[$matches[1]];
        },
        $template
    );
}


/**
 * @param $template_name string
 * @param $variables array of string - Placeholder replacements
 * @return string - Specified html template
 */
function specify_template($template_name, $variables)
{
    return substVars(json_decode(file_get_contents('defaultTemplatesCollection.json'), true)[$template_name],
        $variables);
}

/**
 * @param string $message
 * @return bool
 */
function errorHandle($message)
{
    $date = date('H: d-m-y');
    $message = preg_replace('!\s+|\n|\r\n!', ' ', $message);
    return fs('errorHandle.log', 'a', "\r\n$date « $message » (ip:$_SERVER[REMOTE_ADDR])");
}

/**
 * Операции с файлами
 * **note** for reading full file to string you can uses the file_get_contents($name)
 * @version 2
 *
 * @param $patch
 * @param $mode
 * @param $size_data
 *
 * @return bool|string
 */
function fs($patch, $mode = false, $size_data = false)
{
    /*
        r – для чтения. r+ - на чтение и запись (?).
        w – для записи (удаляющий). w+ - на чтение и запись (удаляющий).
        a – для записи (конец файла). a+ - на чтение и запись (конец файла).
    */
    if (!$mode) $mode = 'r';
    if (!($hdl = fopen($patch, $mode))) return false;
    if (!$size_data && $mode == 'r') return file_get_contents($patch);
    switch ($mode) {
        case('r'):
            @flock($hdl, LOCK_EX);
            $sr = fread($hdl, $size_data);
            @flock($hdl, LOCK_UN);
            @fclose($hdl);
            return $sr;
        case('a'):
        case('w'):
            $hdl = fopen($patch, $mode);
            fwrite($hdl, $size_data);
            fclose($hdl);
            return true;
    }
    return false;
}