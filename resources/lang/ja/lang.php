<?php

return [
    'enums' => [
        'user_role' => [
            'job_seeker' => '求職者',
            'admin' => '管理者',
        ],
        'application_status' => [
            'pending' => '保留',
            'reviewed' => 'レビュー',
            'accepted' => '了承済み',
            'rejected' => '却下',
        ],
    ],

    'label' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'not_a_member' => '会員ではありませんか？',
        'already_a_member' => 'すでに会員ですか？',
        'full_name' => '氏名',
        'role' => '役割',
        'user_login' => 'ログイン',
        'signup' => '会員登録',
        'verification_code' => '検証コード',
        'suggested_jobs' => 'おすすめの仕事',
        'my_applications' => '私のアプリケーション',
        'resume_uploaded' => 'アップロードされた履歴書',
        'date_applied' => '申請日',
        'no_uploaded_resume' => '履歴書がアップロードされていない',
    ],

    'button' => [
        'login' => 'ログイン',
        'register' => '登録',
        'verify' => 'ベリファイ',
        'apply' => '適用する',
        'reviewed' => 'レビュー',
        'view_or_replace_resume' => '履歴書の表示/差し替え',
        'browse_all_jobs' => 'すべての求人を見る',
        'update_profile' => 'プロフィール更新',
        'my_applications' => '私のアプリケーション',
        'delete' => '削除',
        'upload' => 'アップロード',
    ],

    'link' => [
        'become_a_member' => '会員になる',
        'login_here' => 'ログインはこちら',
    ],

    'title' => [
        'signup' => '会員登録',
        'user_login' => 'ログイン',
        'user_verify' => 'ユーザー検証',
        'dashboard' => 'ダッシュボード',
    ],

    'note' => [
        'password' => [
            '8_min_chars' => '少なくとも8文字である',
            'uppercase' => '大文字を含む',
            'lowercase' => '小文字を含む',
            'numbers' => '数字を含む',
            'symbols' => '記号を含む',
        ],
        'enter_6_digit_verification_code' => 'ご登録のEメールアドレスに送信される6桁の認証コードを入力してください。',
        'dashboard_welcome' => 'おかえりなさい、:name！次のチャンスを見つける準備はできましたか？',
    ],
];
