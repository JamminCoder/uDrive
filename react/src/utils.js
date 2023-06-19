/**
 * Gets the path relative to `/storage` that will be used to scan the storage directory.
 * @returns { string }
 */
export function getStoragePath() {
    const paths = window.location.toString().split('storage/');
    if (paths.length > 1) return '/' + paths[1];
    return '/';
}

export function isLoggedIn() {
    return document.querySelector('meta[name="auth_status"]').getAttribute('content') === '1';
}

export function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}