<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(APP_DEFAULT_LANG ?? 'sk') ?>">
<head>
    <?php require __DIR__ . '/../partials/head.php'; ?>
</head>
<body>

<main>
    <?= $content ?>
</main>

</body>
</html>
