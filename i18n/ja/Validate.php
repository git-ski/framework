<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'ADMINUSER_CHECK_LOGIN_EXIST_ERROR' => '管理者IDが既に登録されてます。',
    'PASSWORD_COMMON_ERROR_01'  => '大文字、小文字、数字、特殊文字 (! @ # $ % ^ & * () <> [] {} | _+-=) のみが含まれているパスワードを設定してください。',
    'PASSWORD_COMMON_ERROR_02'  => '大文字、小文字、数字、特殊文字 (! @ # $ % ^ & * () <> [] {} | _+-=) が含まれているパスワードを設定してください。',
    'PASSWORD_WRONG_ERROR'      => 'パスワードが正しくありません。',
    'PASSWORD_GENERATION_ERROR' => '過去利用したパスワードのため設定不可。',

    'LOGIN_ATTEMPT_ERROR'       => '連続して不正な入力がされたためアカウントをロックしました。',
    'LOGIN_SIMULTANEOUS_ERROR'  => 'すでにログイン中です。',
    'LOGIN_COMMON_ERROR_01'     => '英数字、特殊文字 (@ .) が含まれている会員IDを設定してください。',
    'CHECK_ROLE_EXIST_ERROR'    => 'ロール名が既に存在してます',
    'CUSTOMER_CHECK_EMAIL_EXIST_ERROR'  => 'メールアドレスが既に登録されてます。',
    'CUSTOMER_CHECK_LOGIN_EXIST_ERROR' => '会員IDが既に登録されてます。',
    'CUSTOMER_CHECK_CUSTOMER_EXIST_ERROR' => 'ユーザーが存在しません。',
    'CUSTOMER_BIRTHDATE_INVALIID_ERROR' => '生年月日が正しくありません。',
    'CUSTOMER_PHONE_INVALIID_ERROR' => '電話番号が正しくありません。',
    'CUSTOMER_BIRTHDAY_ERROR' => '生年月日が正しくありません。',
    'ADMIN_CHECK_LOGIN_PASSWORD_ERROR'  => 'ログインIDまたはパスワードが正しくありません。',

    'CUSTOMERREMINDER_CHECK_VERIFYHASHKEY_ERROR' => '認証キー相違',

    'VOCABULARYHEADER_CHECK_MACHINENAME_EXIST_ERROR' => 'グループコードがすでに登録されています。',
    'VOCABULARYHEADER_MACHINENAME_ERROR' => '大文字、小文字、数字、特殊文字 (_ -) のみが含まれているグループコードを設定してください。',
    'VOCABULARYDETAIL_CHECK_MACHINENAME_EXIST_ERROR' => 'コードがすでに登録されています。',
    'VOCABULARYDETAIL_MACHINENAME_ERROR' => '大文字、小文字、数字、特殊文字 (_ -) のみが含まれているコードを設定してください。',

    'CHARACTERS_IS_TOO_LONG_ERROR' => '%number%桁以内で入力してください。',
    'CHARACTERS_MIN_MAX_ERROR' => '%range%桁数で入力してください。',

    'ENTITY_PERMISSION_DENIED_MESSAGE' => 'コンテンツ権限不足',

    /* Zend 上書き */
    "Value is required and can't be empty" => "必須入力です。",
    "The input was not found in the haystack" => " 入力値が不正です。",
    'FRONT_LOGIN_ATTEMPT_ERROR' => '連続して不正な入力がされたためアカウントをロックしました。',
    "The input is less than %min% characters long" => " 入力値は %min% 文字以上で入力してください",
    "The input is more than %max% characters long" => " 入力値は %max% 文字以下で入力してください",

    // Laminas\Validator\EmailAddress
    "Invalid type given. String expected" => "不正な形式です。",
    "The input is not a valid email address. Use the basic format local-part@hostname" => "入力値は有効なEmailアドレスではありません。",
    "'%hostname%' is not a valid hostname for the email address" => "Emailアドレスの '%hostname%' は有効なホスト名ではありません",
    "'%hostname%' does not appear to have any valid MX or A records for the email address" => "Emailアドレスの '%hostname%' は有効なホスト名ではありません",
    "'%hostname%' is not in a routable network segment. The email address should not be resolved from public network" => "'%hostname%' はルーティング可能なネットワークセグメントではありません。Emailアドレスはパブリックネットワークから解決できません",
    "'%localPart%' can not be matched against dot-atom format" => "'%localPart%' は有効な形式ではありません",
    "'%localPart%' can not be matched against quoted-string format" => "'%localPart%' は有効な形式ではありません",
    "'%localPart%' is not a valid local part for the email address" => "Emailアドレスの '%localPart%' は有効な形式ではありません",
    "The input exceeds the allowed length" => "入力値は許された長さを超えています",

    // Laminas\Validator\Hostname
    "The input appears to be a DNS hostname but the given punycode notation cannot be decoded" => " 入力値は DNS ホスト名のようですが、有効な形式ではありません",
    "The input appears to be a DNS hostname but contains a dash in an invalid position" => " 入力値は DNS ホスト名のようですが有効な形式ではありません",
    "The input does not match the expected structure for a DNS hostname" => " 入力値は DNS ホスト名の構造に一致していません",
    "The input appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'" => " 入力値は DNS ホスト名のようですが 有効な形式ではありません",
    "The input does not appear to be a valid local network name" => " 入力値は有効なローカルネットワーク名ではないようです",
    "The input does not appear to be a valid URI hostname" => "入力値は有効なURIホスト名ではないようです",
    "The input appears to be an IP address, but IP addresses are not allowed" => " 入力値は IP アドレスのようですが、 IP アドレスは許されていません",
    "The input appears to be a local network name but local network names are not allowed" => " 入力値は有効な形式ではありません",
    "The input appears to be a DNS hostname but cannot extract TLD part" => " 入力値は DNS ホスト名のようですが TLD 部を展開できません",
    "The input appears to be a DNS hostname but cannot match TLD against known list" => " 入力値は DNS ホスト名のようですが、有効な形式ではありません",
];
