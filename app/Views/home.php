<?php 
include 'sidebar.php'; 
?>

<main class='px-8 py-16'>
    <?php foreach($files as $entry): ?>
        <?php if ($entry->is_dir): ?>
            <a href='<?= $entry->storagePath ?>' class='text-blue-700'><?= $entry->storagePath ?> </a>
        <?php else:?>
            <?php echo $entry->storagePath ?>
        <?php endif ?>
        <br>
    <?php endforeach ?>
</main>
