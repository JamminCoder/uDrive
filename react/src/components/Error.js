import React, { useState } from 'react';

export default function Error(props) {
    const [isClosed, setIsClosed] = useState(false);

    if (isClosed || !props.children) return;

    return (
        <div className='font-medium bg-red-400 bg-opacity-80 rounded-lg w-[100%] max-w-screen-md mt-4 p-8 fixed top-0 left-[50%] -translate-x-[50%] flex justify-between items-center'>
            <div>
                <h2 className='text-xl'>Error:</h2>  
                <p className='font-mono'>{ props.children }</p>
            </div>
            <a onClick={ _ => setIsClosed(true) } className='btn font-light bg-white'>Close</a>
        </div>
    );
}