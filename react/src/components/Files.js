import React, { useState } from 'react';
import { useContextMenu } from './ContextMenu';
import Error from './Error';
import { 
    API_FILE_DELETE, API_DIR_DELETE, API_FILE_STORAGE,
    deleteFile, deleteDirectory
 } from '../api/storage';
import { preventDefaults } from '../utils';

export function RenderFiles({ files }) {
    return files ? files.map((entry, i) => 
        entry.isDir 
        ? <Dir key={ i } dir={ entry }/>
        : <File key={ i } file={ entry }/>
    ): '';
}

export function Dir({ dir }) {
    const [visible, setVisible] = useState(true);
    const [error, setError] = useState();
    const [contextMenu, handleContextMenu] = useContextMenu([
        <a onClick={ sendDelete } href={ API_DIR_DELETE(dir.storagePath) } className='text-red-500 font-medium'>Delete</a>
    ]);
    const itemUrl = '/storage/' + dir.storagePath;


    function sendDelete(e) {
        preventDefaults(e);
        deleteDirectory(dir.storagePath)
        .then(_ => setVisible(false))
        .catch(err => {
            console.error(err);
            setError(err.message);
        });
    }

    if (!visible) return;

    return (
        <div
            onContextMenu={ handleContextMenu } 
            className='hasContextMenu bg-blue-200 p-2 rounded border block'>
            <a href={ itemUrl }>
                { dir.name }
            </a>

            { contextMenu }
            <Error>{ error }</Error>
        </div>
    );
}

export function File({ file }) {
    const [visible, setVisible] = useState(true);
    const [error, setError] = useState();
    const fileName = file.name;
    const fileUrl = API_FILE_STORAGE(file.storagePath);
    let truncatedName = fileName.length > 30 
    ? fileName.substring(0, 30) + '...'
    : fileName;

    const [contextMenu, handleContextMenu] = useContextMenu([
        <a href={ fileUrl } >Download</a>,
        <a onClick={ sendDelete } href={ API_FILE_DELETE(file.storagePath) } className='text-red-500 font-medium'>Delete</a>
    ]);


    function sendDelete(e) {
        preventDefaults(e);
        deleteFile(file.storagePath)
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