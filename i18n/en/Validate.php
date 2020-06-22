<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'ADMINUSER_CHECK_LOGIN_EXIST_ERROR' => 'The administrator ID has already been registered.',
    'PASSWORD_COMMON_ERROR_01'  => 'Please set a password that contains only upper case letters, lower case letters, numbers, special characters (! @ # $% ^ & * () <> [] {} | _ + - =).',
    'PASSWORD_COMMON_ERROR_02'  => 'Please set a password that includes uppercase letters, lower case letters, numbers, special characters (! @ # $% ^ & * () <> [] {} | _ + - =).',
    'PASSWORD_WRONG_ERROR'      => 'The password is in correct.',
    'PASSWORD_GENERATION_ERROR' => 'It is not possible to set it because it used past password.',

    'LOGIN_ATTEMPT_ERROR'       => 'Locked due to login failure, please log in again after a while.',
    'LOGIN_SIMULTANEOUS_ERROR'  => 'You are already logged in.',
    'LOGIN_COMMON_ERROR_01'     => 'Please set a member ID which contains alphanumeric characters and special characters (@.).',
    'CHECK_ROLE_EXIST_ERROR'    => 'Role name already exists',
    'CUSTOMER_CHECK_EMAIL_EXIST_ERROR'  => 'The mail address has already been registered.',
    'CUSTOMER_CHECK_LOGIN_EXIST_ERROR' => 'The member ID has already been registered.',
    'CUSTOMER_CHECK_CUSTOMER_EXIST_ERROR' => 'User does not exist.',
    'CUSTOMER_BIRTHDATE_INVALIID_ERROR' => 'Birth date is incorrect.',
    'CUSTOMER_PHONE_INVALIID_ERROR' => 'The phone number is incorrect.',
    'CUSTOMER_BIRTHDAY_ERROR' => 'Birth date is incorrect.',
    'ADMIN_CHECK_LOGIN_PASSWORD_ERROR'  => 'The login ID or password is incorrect.',

    'CUSTOMERREMINDER_CHECK_VERIFYHASHKEY_ERROR' => 'Authentication key difference',

    'VOCABULARYHEADER_CHECK_MACHINENAME_EXIST_ERROR' => 'The group code has already been registered.',
    'VOCABULARYHEADER_MACHINENAME_ERROR' => 'Please set a group code that contains only upper case letters, lower case letters, numbers, special characters (_ -).',
    'VOCABULARYDETAIL_CHECK_MACHINENAME_EXIST_ERROR' => 'The code has already been registered.',
    'VOCABULARYDETAIL_MACHINENAME_ERROR' => 'Please set a code that contains only upper case letters, lower case letters, numbers, special characters (_ -).',

    'CHARACTERS_IS_TOO_LONG_ERROR' => 'Please enter% number% digits or less.',
    'CHARACTERS_MIN_MAX_ERROR' => 'Please enter% range% digits.',

    'ENTITY_PERMISSION_DENIED_MESSAGE' => 'Lack of content authority',

    /* Zend 上書き */
    "Value is required and can't be empty" => "Value is required.",
    "The input was not found in the haystack" => " The input value is invalid.",
    'FRONT_LOGIN_ATTEMPT_ERROR' => 'I accidentally locked my account because it was illegally entered.',
    "The input is less than %min% characters long" => "The input is less than %min% characters long",
    "The input is more than %max% characters long" => "The input is more than %max% characters long",
];
