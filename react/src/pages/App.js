import React, { useEffect, useState } from 'react';
import Sidebar from '../components/Sidebar';
import axios from 'axios';
import { RenderFiles } from '../components/Files';


/**
 * Gets the path relative to `/storage` that will be used to scan the storage directory.
 * @returns { string }
 */
function getStoragePath() {
    const paths = window.location.toString().split('storage/');
    if (paths.length > 1) return '/' + paths[1];
    return '/';
}

export default function App() {
    const [files, setFiles] = useState();
    const storagePath = getStoragePath();
    useEffect(() => {
        axios.get('/api/storage' + storagePath)
        .then(res => {
            if (res.data.files) setFiles(res.data.files);
        })
        .catch(console.error);
    }, []);

    return (
        <div className='flex'>
            <Sidebar/>
            <main className='p-8'>
                <h1 className='text-2xl font-medium mb-8'>{ storagePath }</h1>
                <section className='grid gap-4'>
                    <RenderFiles files={ files } />
                </section>
            </main>
        </div>
    );
}