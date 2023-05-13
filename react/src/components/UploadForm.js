import React from 'react';
import axios from 'axios';


export default function UploadForm(props) {
    function uploadFile(e) {
        e.preventDefault();
        const uploadForm = document.querySelector('#uploadForm');
        axios.post('/api/upload', new FormData(uploadForm))
        .then(_ => window.location.reload())
        .catch(console.error);
    }

    return (
    <form id='uploadForm' action='/api/upload' method='POST' encType="multipart/form-data">
        <input 
            className='file:cursor-pointer file:rounded file:border file:bg-slate-50 hover:file:bg-slate-100 file:py-2 file:px-2 text-transparent' 
            type="file" 
            name="files[]" 
            id="file" multiple
            onChange={ uploadFile } 
        />
            
    </form>
    );
}