import React from 'react';

export default function FileSystemItem({ path, isDir }) {
    return (
        <a className={`${ isDir ? 'text-blue-600 ': '' }p-2 rounded border block`} href={ path }>
            { path }
        </a>
    );
}