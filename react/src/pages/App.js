import React, { useEffect, useState } from 'react';
import Sidebar from '../components/Sidebar';
import { RenderFiles } from '../components/Files';
import { getStoragePath } from '../utils';
import Error from '../components/Error';
import { listDir } from '../api/storage';


export default function App() {
    const [files, setFiles] = useState();
    const [error, setError] = useState(null);
    const storagePath = getStoragePath();

    useEffect(() => {
        listDir(storagePath)
        .then(listings => {
            setFiles(listings);
        }).catch(err => setError(err.message));
    }, []);

    return (
        <div 
            onContextMenu={e => {
                if (e.target.classList.contains('hasContextMenu')) 
                    e.preventDefault();
            }}
            className='flex'>
            <Sidebar/>
            <main className='p-8'>
                <h1 className='text-2xl font-medium mb-8'>{ storagePath }</h1>
                <section className='grid gap-4'>
                    <RenderFiles files={ files } />
                </section>
            </main>
            <Error>{ error }</Error>
        </div>
    );
}