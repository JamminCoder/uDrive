const fileUpload = document.querySelector('#file');
const uploadForm = document.querySelector('#uploadForm');
fileUpload.addEventListener('change', (e) => {
    uploadForm.submit();
})