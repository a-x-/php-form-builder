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
 * @param $pattern                   string                         regexp pattern
 * @param $prefix                    string                         replacement prefix
 * @param $postfix                   string                         replacement postfix
 * @return                           string                         Result
 */
function specify_template_abstract($template, $vars, $specialValuesForKeyValues = array(), $pattern, $prefix = '', $postfix = '')
{
    return preg_replace_callback(
        $pattern,
        function ($matches) use ($vars, $specialValuesForKeyValues, $prefix, $postfix) {
            if (
                $specialValuesForKeyValues &&
                array_key_exists($matches[1] /*needle var`s Name*/, $specialValuesForKeyValues) &&
                $vars[$matches[1]] /*needle var`s Value*/ == $specialValuesForKeyValues[$matches[1]][0] /*replacement Value*/
            )
                $output = $specialValuesForKeyValues[$matches[1]][1];
            elseif (!isset($vars[$matches[1]])) {
                errorHandle("substVarsSafety(): placeholder '$matches[1]' haven't value");
                $output = '';
            } else
                $output = $vars[$matches[1]];

            $prefix = replace_escape_indexes_with_matches($prefix, $matches);
            $postfix = replace_escape_indexes_with_matches($postfix, $matches);
            return $prefix . $output . $postfix;
        },
        $template
    );
}

/**
 * Replace %%placeholder%% with variable[placeholder] and placeholder='' with placeholder='variable[placeholder]'.
 * @param $template
 * @param $vars
 * @param array $specialValuesForKeyValues
 * @test echo specify_template('<video title="">', ['title' => '123']);
 * @return string
 */
function specify_template($template, $vars, $specialValuesForKeyValues = array())
{
    $output = $template;
    // (?=>...) must have fixed length :-((
    // It isn't correct:   return specify_template_abstract($template, $vars, $specialValuesForKeyValues, '/(?|%%([a-z_-]+?)%%|(?<=([a-z_-]{1,40}?)=(\'|")).*?(?=\2))/i');
    $output = specify_template_abstract($output, $vars, $specialValuesForKeyValues, '/%%([a-z_-]+?)%%/i');
    $output = specify_template_abstract($output, $vars, $specialValuesForKeyValues, '/([a-z_-]+?)=(\'|").*?\2/i', '\1=\2', '\2');
    return $output;
}


/**
 * Replace, for example '\1=\2; ' where $matches=['title','4e110 w021d!'] with 'title=4e110 w021d!; '.
 * @param $escape_sequence
 * @param $matches
 * @return mixed
 */
function replace_escape_indexes_with_matches($escape_sequence, $matches)
{
    if ($escape_sequence)
        return preg_replace_callback('/\\\([0-9]+)/', function ($index_matches) use ($matches) {
            return $matches[$index_matches[1]];
        }, $escape_sequence);
    else return $escape_sequence;
}

function eval_array($array_string)
{
    if (preg_match('/^\s*\[.*?\]\s*$/s', $array_string))
        return eval('return ' . $array_string . ';');
    else
        return [];
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