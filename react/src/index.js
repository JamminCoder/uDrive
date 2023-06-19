import React from 'react';
import ReactDOM from 'react-dom/client';
import { 
    RouterProvider
} from 'react-router-dom';
import router from './router';
import axios from 'axios';

import { getCsrfHeader } from './components/Csrf';
axios.defaults.headers = getCsrfHeader();

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
    <React.StrictMode>
        <RouterProvider router={ router }/>
    </React.StrictMode>
);
