<?php
// public/partials/head_tags.php

// Calcula basePath (ex.: '/agenda' quando seu site está em http://localhost/agenda)
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($basePath === '') $basePath = '/';
?>
<link rel="apple-touch-icon" sizes="180x180" href="<?= htmlspecialchars($basePath) ?>/images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= htmlspecialchars($basePath) ?>/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= htmlspecialchars($basePath) ?>/images/favicon-16x16.png">
<link rel="shortcut icon" href="<?= htmlspecialchars($basePath) ?>/images/favicon.ico">
<link rel="manifest" href="<?= htmlspecialchars($basePath) ?>/site.webmanifest">
<meta name="theme-color" content="#ffffff">