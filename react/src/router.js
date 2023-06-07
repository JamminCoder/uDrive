import React from 'react';
import { createBrowserRouter } from 'react-router-dom';
import App from './pages/App';

const router = createBrowserRouter([
    {
        path: '/',
        element: <App />,
    },
    {
        path: '/storage/*',
        element: <App />,
    },

    // This is temporary
    {
        path: '/index.php',
        element: <App />
    }
]);


export default router;