import React, { useState } from 'react';
import axios from 'axios';

export function RenderFiles({ files }) {
    return files ? files.map(entry => 
        entry.isDir ? <Dir path={ entry.storagePath } />:

        <File path={ entry.storagePath }/>
    ): '';
}

export function Dir({ path }) {
    return (
        <a className='bg-blue-200 p-2 rounded border block' href={ '/storage/' + path }>
            { path }
        </a>
    );
}

export function File({ path }) {
    const [visible, setVisible] = useState(true);
    const deleteUrl = `/api/delete/${ path }`;

    function sendDelete(e) {
        e.preventDefault();
        axios.post(deleteUrl);
        setVisible(false);
    }

    if (!visible) return;

    return (
        <div className='bg-blue-50 p-2 rounded border flex justify-between'>
            <a href={ 'api/file/storage/' + path }>
                { path }
            </a>

            <a onClick={ sendDelete } href={ deleteUrl }  className='underline text-red-600'>Delete</a>
        </div>
    );
}