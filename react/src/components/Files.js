import React from 'react';

export function RenderFiles({ files }) {
    return files ? files.map(entry => 
        <File path={ entry.storagePath } isDir={ entry.is_dir } />
    ): ''
}

export function File({ path, isDir }) {
    return (
        <a className={`${ isDir ? 'bg-blue-200 ': 'bg-blue-50 ' }p-2 rounded border block`} href={ '/storage/' + path }>
            { path }
        </a>
    );
}