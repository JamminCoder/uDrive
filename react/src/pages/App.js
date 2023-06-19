import React, { useEffect, useState } from 'react';
import Sidebar from '../components/Sidebar';
import axios from 'axios';
import { RenderFiles } from '../components/Files';
import { getStoragePath } from '../utils';
import Error from '../components/Error';


export default function App() {
    const [files, setFiles] = useState();
    const [error, setError] = useState(null);
    const storagePath = getStoragePath();

    useEffect(() => {
        axios.get('/api/storage' + storagePath)
        .then(res => {
            if (res.data.files) setFiles(res.data.files);
        })
        .catch(err => {
            console.error(err);
            setError(err.message);
        });
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