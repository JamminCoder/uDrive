import React from 'react';
import UploadForm from './UploadForm';

export default function Sidebar() {
    return (
    <aside className='w-60 h-[100vh] left-0 top-0 bg-slate-50 p-8 relative shadow-xl overflow-x-hidden'>
        <h2 className='text-2xl font-medium mb-8'>uDrive</h2>
        <div className='flex flex-col gap-4'>
            <UploadForm/>
        </div>
    </aside>
    );
}