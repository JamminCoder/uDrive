import React from 'react';

export function getCsrfName() {
    return document.querySelector('meta[name="csrf_name"]').getAttribute('content');
}

export function getCsrfValue() {
    return document.querySelector('meta[name="csrf_value"]').getAttribute('content');
}

export function setFormCsrf(formData) {
    formData.set(getCsrfName(), getCsrfValue());
}

export default function Csrf()  {
    return <input type='hidden' name={ getCsrfName() } value={ getCsrfValue() } />
}