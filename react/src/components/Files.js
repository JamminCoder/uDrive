import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useContextMenu } from './ContextMenu';
import Error from './Error';

export function RenderFiles({ files }) {
    return files ? files.map((entry, i) => 
        entry.isDir 
        ? <Dir key={ i } dir={ entry }/>
        : <File key={ i } file={ entry }/>
    ): '';
}

export function Dir({ dir }) {
    const itemUrl = '/storage/' + dir.storagePath;
    return (
        <a className='bg-blue-200 p-2 rounded border block' href={ itemUrl }>
            { dir.name }
        </a>
    );
}

export function File({ file }) {
    const [visible, setVisible] = useState(true);
    const [error, setError] = useState();
    const deleteUrl = `/api/delete/${ file.storagePath }`;
    const fileUrl = `/api/storage/${ file.storagePath }`;
    const fileName = file.name;
    
    const [contextMenu, handleContextMenu] = useContextMenu([
        <a href={ fileUrl } >Download</a>,
        <a onClick={ sendDelete } href={ deleteUrl } className='text-red-500 font-medium'>Delete</a>
    ]);

    let truncatedName = fileName.length > 30 
    ? fileName.substring(0, 30) + '...'
    : fileName;

    function sendDelete(e) {
        e.preventDefault();
        e.stopPropagation();
        axios.delete(deleteUrl)
        .then(() => setVisible(false))
        .catch(err => {
            console.error(err);
            setError(err.message);
        });
    }

    if (!visible) return;

    return (
        <div
            onContextMenu={ handleContextMenu }
            className='hasContextMenu bg-blue-50 p-2 rounded border flex justify-between text-sm w-96'>
            <a href={ fileUrl } >
                { truncatedName }
            </a>

            <Error>{ error }</Error>
            { contextMenu }
        </div>
    );
}