<?php
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список статей</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .article-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .article {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .article:hover {
            transform: translateY(-5px);
        }
        .article h2 {
            color: #2c3e50;
            margin-top: 0;
        }
        .article small {
            color: #7f8c8d;
            font-size: 0.9em;
        }
        .add-article-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .add-article-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Статьи</h1>
        
        <a href="/pages/add_article.php" class="add-article-btn">Добавить статью</a>
        
        <div class="article-list">
            <?php
            $result = pg_query($conn, "SELECT * FROM articles ORDER BY created_at DESC");
            while ($row = pg_fetch_assoc($result)) {
                echo "<div class='article'>
                        <h2>{$row['title']}</h2>
                        <p>{$row['content']}</p>
                        <small>Опубликовано: " . date('d.m.Y H:i', strtotime($row['created_at'])) . "</small>
                      </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>