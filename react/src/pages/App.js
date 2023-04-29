import React from 'react';
import { useParams } from 'react-router-dom';
import Sidebar from '../components/Sidebar';

export default function App() {
    const { path } = useParams();

    return (
        <div className='flex'>
            <Sidebar/>
            
            Hello!
        </div>
    );
}