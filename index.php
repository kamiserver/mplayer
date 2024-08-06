<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ミニマル音楽プレイヤー</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ミニマル音楽プレイヤー</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file">音楽ファイルを選択:</label>
        <input type="file" name="file" id="file" required>
        <label for="title">曲のタイトル:</label>
        <input type="text" name="title" id="title" required>
        <label for="artist">アーティスト名:</label>
        <input type="text" name="artist" id="artist" required>
        <label for="cover">ジャケット画像を選択:</label>
        <input type="file" name="cover" id="cover" required>
        <button type="submit">アップロード</button>
    </form>

    <h2>アップロード済みの曲</h2>
    <?php
    $files = glob('uploads/*.mp3');
    if ($files) {
        foreach ($files as $file) {
            $info = pathinfo($file);
            $filenameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
            $cover = 'uploads/' . $filenameWithoutExtension . '.jpg';
            $metadata = 'uploads/' . $filenameWithoutExtension . '.json';

            if (file_exists($cover) && file_exists($metadata)) {
                $metadataContent = json_decode(file_get_contents($metadata), true);
                $title = htmlspecialchars($metadataContent['title']);
                $artist = htmlspecialchars($metadataContent['artist']);

                echo '<div class="music-item">';
                echo '<img src="' . $cover . '" alt="Cover" class="cover">';
                echo '<div class="info">';
                echo '<p><strong>曲名:</strong> ' . $title . '</p>';
                echo '<p><strong>アーティスト:</strong> ' . $artist . '</p>';
                echo '<audio controls src="' . $file . '"></audio>';
                echo '</div>';
                echo '</div>';
            }
        }
    } else {
        echo '<p>まだ曲がアップロードされていません。</p>';
    }
    ?>
</body>
</html>
