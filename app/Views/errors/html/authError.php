<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= lang('Errors.whoops') ?></title>

    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>

    <div class="container text-center">

        <h1 class="headline"><?= lang('Errors.whoops') ?></h1>

        <p class="lead"><?= lang('Error Code: 404') ?></p>
        <?php if(isset($msg)) : ?>
            <p class="lead"><?= lang($msg) ?></p>
        <?php endif ?>
        <!-- <a href="/"><button class="btn btn-primary">Log In</button></a> -->

    </div>

</body>

</html>