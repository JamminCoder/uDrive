import React from 'react';
import axios from 'axios';
import { getStoragePath } from '../utils';

const uploadPath = `/api/upload${ getStoragePath() }`;

export function UploadButton() {
    function uploadFile(e) {
        e.preventDefault();
        const uploadForm = document.querySelector('#uploadForm');
        axios.post(uploadPath, new FormData(uploadForm))
        .then(_ => window.location.reload())
        .catch(console.error);
    }

    function handleUploadClick(e) {
        e.preventDefault();
        document.querySelector('#file').click()
    }

    return (
    <>
        <input 
            className='hidden' 
            type="file" 
            name="files[]" 
            id="file" multiple
            onChange={ uploadFile } 
        />
        <button 
        className='cursor-pointer rounded border bg-slate-50 hover:bg-slate-100 py-2 px-2' 
        onClick={ handleUploadClick }
        >Upload Files</button>
    </>
    );
}

export default function UploadForm(props) {
    return (
    <form id='uploadForm' action={ uploadPath } method='POST' encType="multipart/form-data">
        <UploadButton/>
    </form>
    );
}