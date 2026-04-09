<?php
try {
    helper("setting");
    $setting = homeSetInfo();
} catch (\Throwable $th) {
    die("Something went wrong!");
}
?>
<?php echo view('inc/head_inc', ["setting" => $setting]); ?>
<?= $this->renderSection('styles') ?>

<?php
$uri = service('uri')->getPath();
?>

<?php if ($uri === '' || $uri === '/'): ?>
    <?= view('inc/header_main_new') ?>
<?php else: ?>
    <?= view('inc/header_main') ?>
<?php endif; ?>
<main>
    <?php echo $this->renderSection('content'); ?>
</main>
<?php echo view('inc/footer_inc', ["setting" => $setting]); ?>