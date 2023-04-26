<aside class='w-60 h-[100vh] left-0 top-0 bg-slate-50 p-8 relative shadow-xl'>
    <?php // Files::renderFileTree($files) ?>
    
    <div class='flex flex-col gap-4'>
        <a class='btn'>Create File</a>
        <form id='uploadForm' action='/upload' method='POST' enctype="multipart/form-data">
            <input class='file:rounded file:border file:bg-slate-50 file:py-2 file:px-2 text-transparent' type="file" name="file" id="file"/>
        </form>
    </div>
</aside>
<script src='/js/files/upload.js'></script>