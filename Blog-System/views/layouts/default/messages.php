<?php if (isset($_SESSION['messages']) && $_SESSION['messages']):
foreach ($_SESSION['messages'] as $message => $type): ?>
<div class="alert alert-<?= $type ?> alert-dismissible text-center col-md-12" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?= $message ?>
</div>
<?php endforeach;
$_SESSION['messages'] = [];
endif; ?>
