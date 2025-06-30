<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by 
    | the validator class. Some of these rules have multiple versions, such as 
    | size rules. Feel free to adjust each of these messages as needed.
    |
    */

    'required' => 'Please enter :attribute.',
    'email' => 'The email address format is invalid.',
    'unique' => 'The :attribute already exists.',
    'max' => [
        'numeric' => 'Must not be greater than :max.',
        'file' => 'Must not exceed :max kilobytes.',
        'string' => 'Please enter within :max characters.',
        'array' => 'Cannot contain more than :max items.',
    ],
    'in' => 'The selected :attribute is invalid.',
    'password' => [
        'letters' => ':attribute must contain at least one letter' , 
        'mixed' => ':attribute must contain both upper and lower case letters' , 
        'numbers' => ':attribute must contain at least one number' , 
        'symbols' => ':attribute must contain at least one symbol.' ,
    ],
    'phone' => 'The :attribute field must be a valid PH number.',

    /*
    |--------------------------------------------------------------------------
    | Language line of custom validation
    |--------------------------------------------------------------------------
    |
    | Here, name the line using the rule “attribute.rule”,
    | You can specify a custom validation message for an attribute. This allows you to specify a specific attribute rule with
    | You can quickly specify a specific custom language line.
    |
    */

    'custom' => [
        'code' => [
            'exists' => 'The verification code is invalid.',
        ],
        'invalid_credentials' => 'Invalid credentials.',
        'old_verification_code' => 'Entered an old verification code.',
        'old_and_expired_verification_code' => 'Entered an old and expired verification code.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | Use the following language line to replace the attribute placeholder with something more readable, such as “E-Mail Address” instead of “email”.
    | Replace with something more readable. This simply helps make the message more expressive.
    |
    */
    
    'attributes' => [
        'email' => 'email address',
        'password' => 'password',
        'name' => 'name',
        'tel' => 'Contact Number',
    ],
];
