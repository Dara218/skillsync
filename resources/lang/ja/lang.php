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
        'job_type' => [
            'full_time' => 'フルタイム',
            'part_time' => 'パートタイム',
            'remote_time' => 'リモートタイム',
            'internship'=> 'インターンシップ',
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
        'no_info' => '情報はない。',
        'no_description' => '記述がない。',
        'jobs' => '求人',
        'personal_details' => '個人の詳細',
        'address' => '住所',
        'contact_number' => '連絡先',
        'birth_date' => '生年月日',
        'update' => '更新',
        'update_profile_photo' => 'プロフィール写真の更新',
        'change_password' => 'パスワードを変更する',
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
        'view' => 'ビュー',
        'search' => '探索',
        'go_back' => '戻る',
        'update_email_address' => 'メールアドレスの更新',
        'updated_password' => 'パスワードの更新',
        'delete_account' => 'アカウント削除',
    ],

    'link' => [
        'become_a_member' => '会員になる',
        'login_here' => 'ログインはこちら',
        'browse_all_jobs' => 'すべての求人を見る',
        'update_profile' => 'プロフィール更新',
        'my_applications' => '私のアプリケーション',
        'dashboard' => 'ダッシュボード',
        'logout' => 'ログアウト',
    ],

    'title' => [
        'signup' => '会員登録',
        'user_login' => 'ログイン',
        'user_verify' => 'ユーザー検証',
        'dashboard' => 'ダッシュボード',
        'jobs' => '求人',
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

    'placeholder' => [
        'search_for_jobs' => '求人検索...',
    ],

    'errors' => [
        'not_found' => [
            'title' => '見つからない。',
            'message' => 'お探しのページは見つかりませんでした。',
        ],
        'bad_request' => [
            'title' => 'リクエストが不正です。',
            'message' => 'リクエストが不正なため、サーバーが処理できません。',
        ],
        'unauthorized' => [
            'title' => '認証が必要です。',
            'message' => 'このページにアクセスするには認証が必要です。',
        ],
        'forbidden' => [
            'title' => 'アクセス拒否。',
            'message' => 'このページへのアクセス権がありません。',
        ],
        'expired' => [
            'title' => 'ページの有効期限が切れました。',
            'message' => 'ページの有効期限が切れたため、再度試してください。',
        ],
        'too_many_request' => [
            'title' => 'リクエストが多すぎます。',
            'message' => 'リクエストが多すぎるため、一時的にアクセスが制限されています。',
        ],
        'internal_server_error' => [
            'title' => '内部サーバーエラー。',
            'message' => 'サーバー内部でエラーが発生しました。後でもう一度お試しください。',
        ],
        'bad_gateway' => [
            'title' => '不正なゲートウェイ。',
            'message' => 'ゲートウェイサーバーから不正な応答がありました。',
        ],
        'service_unavailable' => [
            'title' => 'サービス利用不可。',
            'message' => '現在、サービスを利用することができません。しばらくしてからもう一度お試しください。',
        ],
        'gateway_timeout' => [
            'title' => 'ゲートウェイタイムアウト。',
            'message' => 'ゲートウェイサーバーの応答がタイムアウトしました。',
        ],
    ],
];
