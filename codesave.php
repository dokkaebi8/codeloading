<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POSTデータからcodeを取得
    $code = $_POST['code'] ?? '';
    if (!empty($code)) {
        // タイムスタンプ（ミリ秒）を取得
        $timestamp = round(microtime(true) * 1000);
        // フォーマットされたURLを生成
        $formatted_url = "https://stake.com/ja?drop={$code}&type=drop&code={$code}&modal=redeemBonus";
        // タイムスタンプとURLを組み合わせ
        $content = "{$timestamp}|{$formatted_url}\n";
        // ファイルのパスを絶対パスで指定
        $file_path = __DIR__ . '/action.txt';
        // ファイルへの書き込みを試行（上書き保存）
        $result = file_put_contents($file_path, $content, LOCK_EX);
        if ($result === false) {
            // 書き込みに失敗した場合のエラーハンドリング
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'ファイルへの書き込みに失敗しました。']);
            exit;
        }
        // 成功レスポンスを返す
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => '保存しました。']);
        exit;
    }
}
// POSTデータが不正な場合のエラーレスポンス
http_response_code(400);
echo json_encode(['status' => 'error', 'message' => '不正なリクエストです。']);
exit;
?>
