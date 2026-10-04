<?php
    require("models/layout.php");
    require("database/database.php");

    $page = intval($_GET["page"] ?? "") ?? 0;

    $db = new Database();
    $db->connectUsingEnvVars();
    $model = $db->getLatestNews($page);

    $LAYOUT_MODEL = new Layout();
    $LAYOUT_MODEL->title = "Страница " . $model->getCurrentPage();

    if (count($model->articles) > 0) {
        /** @var Article */
        $latestArticle = $model->articles[0];
        $LAYOUT_MODEL->description = $latestArticle->getAnnounce();
    }

    ob_start();
?>

<!-- HEAD SECTION -->
<link rel="stylesheet" href="/static/styles/index.css">

<?php 
    $LAYOUT_MODEL->head = ob_get_clean();
    ob_start();
?>

<!-- BODY SECTION -->
<?php if (isset($latestArticle)): ?>
    <div id="latest-article" style="background-image: url('<?php echo htmlspecialchars($latestArticle->getImageUrl(), ENT_QUOTES) ?>')">
        <div class="preview">
            <h1><?php echo $latestArticle->getTitle() ?></h1>
            <p><?php echo $latestArticle->getAnnounce() ?></p>
        </div>
    </div>
<?php endif; ?>

<div id="main-content">
    <h2>Новости</h2>
    <div id="news-section">
        <?php /** @var Article $article */ foreach ($model->articles as $article): ?>
            <?php $articleLink = 
                "/article.php?id=" . $article->getId() . 
                    "&from=" . $model->getCurrentPage();
            ?>
            <div class="article-preview">
                <div class="date"><?php echo $article->getDate() ?></div>
                <article>
                    <h3>
                        <a href="<?php echo $articleLink ?>">
                            <?php echo $article->getTitle() ?>
                        </a>
                    </h3>
                    <p><?php echo $article->getAnnounce() ?></p>
                </article>
                <a class="button" href="<?php echo $articleLink ?>">
                    <span>Подробнее</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="page-switcher">
        <?php for ($i = 1; $i <= $model->getTotalPages(); $i++): ?>
            <?php if ($i == $model->getCurrentPage()): ?>
                <span class="button disabled"><?php echo $i ?></span>
                <?php continue; ?>
            <?php endif; ?>

            <a class="button" href="/?page=<?php echo $i ?>"><?php echo $i ?></a>
        <?php endfor; ?>

        <?php if ($model->getCurrentPage() < $model->getTotalPages()) : ?>
            <a class="button wide" href="/?page=<?php echo $model->getCurrentPage() + 1 ?>">
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        <?php endif; ?>
    </div>
</div>

<?php
    $LAYOUT_MODEL->body = ob_get_clean();
    require("layouts/main_layout.php");