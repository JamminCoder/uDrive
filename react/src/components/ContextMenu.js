import React, { useState } from 'react';

export function useContextMenu(menuItems) {
    const [contextMenu, setContextMenu] = useState(null);

    function handleContextMenu(e) {
        if (!contextMenu) setContextMenu(
            <ContextMenu x={ e.pageX } y={ e.pageY } items={ menuItems } />
        ); else setContextMenu(null);
        
        
        window.addEventListener('mousedown', e => {
            // Don't close the context menu if the user clicks inside
            if (!e.target.parent.classList.contains('context-menu__item'))
                setContextMenu(null);
        });
    }

    return [contextMenu, handleContextMenu];
}

export function ContextMenuItem(props) {
    return (
        <li key={ i } className='context-menu__item'>
            { props.children }
        </li>
    )
}

export default function ContextMenu({ x, y, items }) {
    return (
        <div 
        style={{ top: y, left: x }}
        className='context-menu'>
            <ul>
            { items.map((item, i) => <ContextMenuItem key={i} >{ item }</ContextMenuItem> )}
            </ul>
        </div>
    );
}