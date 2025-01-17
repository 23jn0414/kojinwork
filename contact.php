<?php
// お問い合わせ内容を受け取り、CSVに保存するスクリプト

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTデータを受け取る
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // 必須項目が入力されているか確認
    if (!empty($name) && !empty($email) && !empty($message)) {
        // CSVファイルに保存するデータ
        $data = [
            date('Y-m-d H:i:s'), // 現在の日時
            $name,
            $email,
            $message,
        ];

        // CSVファイルのパス
        $filePath = 'inquiries.csv';

        // ファイルが存在しない場合、ヘッダー行を追加
        if (!file_exists($filePath)) {
            $header = ['日時', '名前', 'メールアドレス', 'メッセージ'];
            $file = fopen($filePath, 'a');
            fputcsv($file, $header);
            fclose($file);
        }

        // データをCSVに書き込む
        $file = fopen($filePath, 'a');
        fputcsv($file, $data);
        fclose($file);

        // 成功メッセージを返す
        echo 'お問い合わせ内容を受け付けました。ありがとうございます！';
    } else {
        echo '全ての項目を入力してください。';
    }
} else {
    echo '無効なリクエストです。';
}
