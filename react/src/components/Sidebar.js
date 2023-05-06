import React from 'react';

export default function Sidebar() {
    function uploadFile() {
        const uploadForm = document.querySelector('#uploadForm');
        uploadForm.submit();
    }

    return (
    <aside className='w-60 h-[100vh] left-0 top-0 bg-slate-50 p-8 relative shadow-xl overflow-x-hidden'>
        <div className='flex flex-col gap-4'>
            <a className='btn'>Create File</a>
            <form id='uploadForm' action='/api/upload' method='POST' encType="multipart/form-data">
                <input onChange={ uploadFile } className='file:rounded file:border file:bg-slate-50 file:py-2 file:px-2 text-transparent' type="file" name="file" id="file"/>
            </form>
        </div>
    </aside>
    );
}