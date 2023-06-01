import axios from 'axios';

export const API_FILE_DELETE = filePath => `/api/delete/${ filePath }`;
export const API_DIR_DELETE = dirPath => `/api/dir/delete/${ dirPath }`;
export const API_FILE_STORAGE = filePath => `/api/storage/${ filePath }`;

export async function deleteFile(filePath) {
    try {
        const res = await axios.delete(API_FILE_DELETE(filePath));
        return res;
    } catch (err) { 
        return err 
    };
}


export async function deleteDirectory(dirPath) {
    try {
        const res = await axios.delete(API_DIR_DELETE(dirPath));
        return res;
    } catch (err) { 
        return err 
    };
}
