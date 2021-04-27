<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$this->e($title)?></title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <?= $this->insert('sections/styles') ?>
    <?= $this->insert('sections/scripts') ?>
</head>
<body>

<?= $this->insert('sections/header') ?>

<div class="container">

    <?= $this->section('content') ?>

</div>

</body>

</html>