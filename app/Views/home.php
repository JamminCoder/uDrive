<?php 
include 'sidebar.php'; 
use App\Libraries\Files;
?>

<main class='px-8 py-16'>
    <?php Files::renderFileTree($files) ?>

</main>