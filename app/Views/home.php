<?php 
include 'sidebar.php'; 
use App\Libraries\Files;
?>

<main class='px-8 py-16'>
    <?php foreach($files as $entry): ?>
        <?php if ($entry->is_dir): ?>
            <?= "DIR: $entry"?>
        <?php else:?>
            <?php echo $entry ?>
        <?php endif ?>
        <br>
    <?php endforeach ?>
</main>
