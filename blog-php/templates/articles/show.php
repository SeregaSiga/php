<?php include __DIR__ . '/../header.php'; ?>

<h1><?= $article->getName() ?></h1>
<p><?= $article->getText() ?></p>

<?php
    $pattern = '~article/show/(\d+)~';
    preg_match($pattern, $_GET['route'], $matches);
?>

<?php foreach ($comments as $comment): ?>
    <?php if ($comment->getArticleId() == $matches[1]): ?>
        <div class="card" style="padding: 20px; margin-bottom: 10px;">
            <h4 class="card-title">Комментарии:</h4>
            <p class="card-subtitle"><?= $comment->getText() ?></p>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<a href="/project/www/comments/<?= $article->getId() ?>">Редактировать комментарии</a>

<div>
    <h2>Добавить комментарий</h2>
    <form action="/project/www/comments/add/<?= $article->getId() ?>" method="post">
        <label>Текст <input type="text" name="text"></label>

        <br><br>

        <input type="submit" value="Добавить">
    </form>
</div>
<?php include __DIR__ . '/../footer.html'; ?>