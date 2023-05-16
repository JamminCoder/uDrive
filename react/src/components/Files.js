import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useContextMenu } from './ContextMenu';

export function RenderFiles({ files }) {
    return files ? files.map((entry, i) => 
        entry.isDir 
        ? <Dir key={ i } path={ entry.storagePath } />
        : <File key={ i } path={ entry.storagePath }/>
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
    const fileUrl = `/api/storage/${ path }`;
    
    const [contextMenu, handleContextMenu] = useContextMenu([
        <a href={ fileUrl } >Download</a>,
        <a onClick={ sendDelete } href={ deleteUrl } className='text-red-500 font-medium'>Delete</a>
    ]);

    let truncatedPath = path.length > 30 
    ? path.substring(0, 30) + '...'
    : path;

    function sendDelete(e) {
        e.preventDefault();
        e.stopPropagation();
        axios.delete(deleteUrl).then(() => setVisible(false));
    }

    if (!visible) return;

    return (
        <div
            onContextMenu={ handleContextMenu }
            className='hasContextMenu bg-blue-50 p-2 rounded border flex justify-between text-sm w-96'>
            <a href={ fileUrl } >
                { truncatedPath }
            </a>

            { contextMenu }
        </div>
    );
}