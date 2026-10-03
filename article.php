<?php 
    require("models/layout.php");
    require("database/database.php");

    $id = intval($_GET["id"] ?? "0");
    $from = intval($_GET["from"] ?? "0");

    $db = new Database();
    $db->connectWithDefaultParams();
    $article = $db->getArticle($id);

    if (!$article) {
        require("error404.php");
        return;
    }

    $LAYOUT_MODEL = new Layout();
    $LAYOUT_MODEL->title = $article->getTitle();
    $LAYOUT_MODEL->description = $article->getAnnounce();

    ob_start();
?>

<!-- HEAD -->
<link rel="stylesheet" href="/static/styles/article.css">

<?php 
    $LAYOUT_MODEL->head = ob_get_clean();
    ob_start();
?>

<!-- BODY -->
<div class="separator"></div>

<div id="main-content">
    <div class="breadcrumbs">
        <a href="/">Главная</a>
        <span>/</span>
        <span><?php echo $article->getTitle() ?></span>
    </div>
    <h1><?php echo $article->getTitle() ?></h1>
    <div class="date top-space"><?php echo $article->getDate() ?></div>
    <div class="article-wrapper">
        <div class="text">
            <article>
                <h2 class="announce">
                    <span><?php echo $article->getAnnounce() ?></span>
                </h2>
                <?php $lines = explode("\n", $article->getContent()) ?>
                <?php foreach ($lines as $line): ?>
                    <?php if (strlen($line) == 0): ?>
                        <?php continue; ?>
                    <?php endif; ?>

                    <p><?php echo $line ?></p>
                <?php endforeach; ?>
            </article>
            <div class="button-wrapper">
                <a class="button" href="/?page=<?php echo $from ?>">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span>Назад к новостям</span>
                </a>
            </div>
        </div>
        <img src="<?php echo $article->getImageUrl() ?>" alt="Сгенерированное изображение, дополняющее содержимое статьи">
    </div>
</div>

<?php 
    $LAYOUT_MODEL->body = ob_get_clean();
    require("layouts/main_layout.php");