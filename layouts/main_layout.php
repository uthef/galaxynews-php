<?php 
    /** @var Layout $LAYOUT_MODEL */
    $LAYOUT_MODEL;
    
    if (!isset($LAYOUT_MODEL))
        die("Layout model is not set");
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="/static/styles/base.css">
        <link rel="shortcut icon" href="/static/images/design/logo.svg">
        <title><?php echo $LAYOUT_MODEL->title ?? "Без названия" ?> - Галактический вестник</title>
        
        <?php if ($LAYOUT_MODEL->description != null): ?>
            <meta name="description" content="<?php echo htmlspecialchars($LAYOUT_MODEL->description, ENT_QUOTES) ?>">
        <?php endif; ?>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
        <?php if ($LAYOUT_MODEL->head != null): ?>
            <?php echo $LAYOUT_MODEL->head; ?>
        <?php endif; ?>
    </head>
    <body>
        <header>
            <div id="logo"></div>
            <div id="site-name">
                <span>Галактический</span>
                <br>
                <span>Вестник</span>
            </div>
        </header>
        <?php if ($LAYOUT_MODEL->body != null): ?>
            <?php echo $LAYOUT_MODEL->body; ?>
        <?php endif; ?>
        <footer>
            <div class="separator btm-space"></div>
            <span>© <?php echo date("Y") ?> — 2412 «Галактический вестник»</span>
            <div id="author">
                <span>Автор:</span>
                <a href="https://github.com/uthef">Evergrey</a>
            </div>
        </footer>
    </body>
</html>