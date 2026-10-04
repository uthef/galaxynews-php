<?php
    $LAYOUT_MODEL = new Layout();
    $LAYOUT_MODEL->title = "Ошибка 404";
    http_response_code(404);
    ob_start();
?>

<!-- BODY SECTION -->

<div class="separator"></div>

<div id="main-content">
    <h1 class="accent-color">Ошибка 404</h1>
    <p>Невозможно отобразить запрошенную страницу</p>
    <a class="button top-space" href="/">
        <span class="material-symbols-outlined">arrow_back</span>
        <span>Вернуться на главную</span>
    </a>
</div>

<?php
    $LAYOUT_MODEL->body = ob_get_clean();
    require("layouts/main_layout.php");