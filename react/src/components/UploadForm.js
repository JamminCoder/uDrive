import React, { useState } from 'react';
import axios from 'axios';
import { getStoragePath } from '../utils';
import Error from './Error';


const storagePath = getStoragePath();
const uploadPath = `/api/upload${ storagePath }`;
const uploadDirPath = `/api/dir/upload${ storagePath }`

export function FormButton({ onClick, children }) {
    return <button 
    className='cursor-pointer rounded border bg-slate-50 hover:bg-slate-100 py-2 px-2' 
    onClick={ onClick }
    >{ children }</button>
}

export function UploadFileButton() {
    const [error, setError] = useState(null);
    const id = 'fileUpload';

    function uploadFile(e) {
        e.preventDefault();
        const uploadForm = document.querySelector('#uploadForm');
        axios.post(uploadPath, new FormData(uploadForm))
        .then(_ => window.location.reload())
        .catch(err => {
            console.error(err)
            setError(err.message);
        });
    }

    function handleUploadClick(e) {
        e.preventDefault();
        document.querySelector(`#${ id }`).click();
    }

    return (
    <>
        <input 
            className='hidden' 
            type="file" 
            name='files[]'
            id={ id } multiple
            onChange={ uploadFile } 
        />
        
        <FormButton onClick={ handleUploadClick }>Upload File</FormButton>
        <Error>{ error }</Error>
    </>
    );
}

export function UploadFolderButton() {
    const [error, setError] = useState(null);
    const id = 'folderUpload';

    function uploadFolder(e) {
        e.preventDefault();
        const uploadForm = document.querySelector('#uploadForm');
        const formData = new FormData(uploadForm);

        axios.post(uploadDirPath, formData)
        .then(_ => window.location.reload())
        .catch(err => setError(err.message));
    }

    function handleUploadClick(e) {
        e.preventDefault();
        document.querySelector(`#${ id }`).click();
    }

    return (
    <>
        <input 
            className='hidden' 
            type='file'
            name='folder[]'
            id={ id }
            multiple
            directory='true'
            mozdirectory='true'
            webkitdirectory='true'
            onChange={ uploadFolder } 
        />

        <FormButton onClick={ handleUploadClick }>Upload Folder</FormButton>
        <Error>{ error }</Error>
    </>
    );
}


export default function UploadForm() {
    return (
    <form id='uploadForm' action={ uploadPath } method='POST' encType="multipart/form-data" className='relative grid gap-4'>
        <UploadFileButton/>
        <UploadFolderButton/>
    </form>
    );
}