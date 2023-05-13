import React, { useState } from 'react';

export function useContextMenu(menuItems) {
    const [contextMenu, setContextMenu] = useState(null);

    function handleContextMenu(e) {
        if (!contextMenu) setContextMenu(
            <ContextMenu x={ e.pageX } y={ e.pageY } items={ menuItems } />
        ); else setContextMenu(null);
            
        window.addEventListener('mousedown', () => setContextMenu(null));
    }

    return [contextMenu, handleContextMenu];
}

export default function ContextMenu({ x, y, items }) {
    return (
        <div 
        style={{ top: y, left: x }}
        className='cursor-pointer bg-white border border-gray-200 rounded shadow-lg absolute z-10'>
            <ul>
            { items.map(item => {
                return (
                    <li className='p-2 hover:bg-gray-100 flex justify-between'>
                        { item }
                    </li>
                )
            }) }
            </ul>
        </div>
    );
}