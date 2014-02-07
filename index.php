<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Document</title>
</head>

<body>


<?php

echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
echo '<pre>';
print_r($_FILES);
echo '</pre>';

require_once('Form.php');

/*
Create a new instance
Pass in a URL to set the action
*/
$form = new Json2Form();

/*
Form attributes are modified with the set_att function.
First argument is the setting
Second argument is the value
*/
/*$form->set_att('method', 'post');
$form->set_att('enctype', 'a_contact_form');
$form->set_att('markup', 'html');
$form->set_att('class', 'class_1');
$form->set_att('class', 'class_2');
$form->set_att('id', 'a_contact_form');
$form->set_att('novalidate', true);
$form->set_att('add_honeypot', false);
$form->set_att('add_nonce', 'a_contact_form');

*/

$form->set_att('enctype', 'multipart/form-data');
$form->set_att('method', 'post');

/*
Uss add_input to create form fields
First argument is the name
Second argument is an array of arguments for the field
Third argument is an alternative name field, if needed
*/
$form->add_input('Name', array(), 'contact_name');

$form->add_input('Email', array(
    'type' => 'email'
), 'contact_email');

$form->add_input('Files', array(
    'type' => 'file'
), 'files_here');

$form->add_input('Reason for contacting', array(
    'type' => 'checkbox',
    'options' => array(
        'say_hi' => 'Just saying hi!',
        'complain' => 'I have a bone to pick',
        'offer_gift' => 'I\'d like to give you something neat',
    )
));

$form->add_input('Bad Headline', array(
    'type' => 'radio',
    'options' => array(
        'say_hi_2' => 'Just saying hi! 2',
        'complain_2' => 'I have a bone to pick 2',
        'offer_gift_2' => 'I\'d like to give you something neat 2',
    )
));

$form->add_input('Reason for contact', array(
    'type' => 'select',
    'options' => array(
        '' => 'Select...',
        'say_hi' => 'Just saying hi!',
        'complain' => 'I have a bone to pick',
        'offer_gift' => 'I\'d like to give you something neat',
    )
));

$form->add_input('Question or comment', array(
    'required' => true,
    'type' => 'textarea',
    'value' => 'Type away!'
));

$form->add_inputs(array(
    array('Field 1'),
    array('Field 2'),
    array('Field 3')
));

/*
Create the form
*/
$form->build_form();
?>
</body>
</html>