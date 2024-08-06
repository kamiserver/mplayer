<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['file']['name']);
    $targetFile = $uploadDir . $fileName;
    $coverFile = $uploadDir . pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
    $metadataFile = $uploadDir . pathinfo($fileName, PATHINFO_FILENAME) . '.json';

    // ファイルをアップロード
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile) && move_uploaded_file($_FILES['cover']['tmp_name'], $coverFile)) {
        // メタデータをJSON形式で保存
        $metadata = [
            'title' => $_POST['title'],
            'artist' => $_POST['artist']
        ];
        file_put_contents($metadataFile, json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        header('Location: index.php');
        exit;
    } else {
        echo "ファイルのアップロードに失敗しました。";
    }
}
?>
