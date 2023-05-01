import React from 'react';

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
    return (
        <a className='bg-blue-50 p-2 rounded border block' href={ 'api/file/storage/' + path }>
            { path }
        </a>
    );
}