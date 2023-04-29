import React from 'react';
import ReactDOM from 'react-dom/client';

function SayHello({ name }) {
    return <div>Hello, { name }</div>
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
    <React.StrictMode>
        <SayHello name='tim' />
    </React.StrictMode>
);
