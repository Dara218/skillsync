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

    'required' => ':attributeを入力してください。',
    'email' => 'メールアドレスの形式が正しくありません。',
    'unique' => 'すでに存在する:attributeです。',
    'min' => [
        'string' => ':attribute は少なくとも :min 文字である必要があります。',
    ],
    'max' => [
        'numeric' => ':maxより大きくてはいけません。',
        'file' => ':maxキロバイトを超えてはいけません。',
        'string' => ':max以内の文字数で入力してください。',
        'array' => ':max個を超えるアイテムを含めることはできません。',
    ],
    'in' => '選択された:attributeは無効です。',
    'password' => [
        'letters' => ':attribute は少なくとも1つの文字を含む必要があります。',
        'mixed' => ':attribute は大文字と小文字の両方を含む必要があります。',
        'numbers' => ':attribute は少なくとも1つの数字を含む必要があります。',
        'symbols' => ':attribute は少なくとも1つの記号を含む必要があります。',
    ],

    /*
    |--------------------------------------------------------------------------
    | language line of custom validation
    |--------------------------------------------------------------------------
    |
    | Here, name the line using the rule “attribute.rule”,
    | You can specify a custom validation message for an attribute. This allows you to specify a specific attribute rule with
    | You can quickly specify a specific custom language line.
    |
    */

    'custom' => [
        'code' => [
            'exists' => '認証コードが無効です。',
        ],
        'invalid_credentials' => '認証情報が無効です。',
        'old_verification_code' => '古い認証コードを入力しました。',
        'old_and_expired_verification_code' => '有効期限が切れた古い認証コードを入力しました。',
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
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'name' => '名前',
    ],
];