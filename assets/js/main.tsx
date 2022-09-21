import '../styles/app.scss';

import React from 'react';
import { createRoot } from 'react-dom/client';

import Default from './components/Default';

// Default
const start = document.getElementById('default');
if(start !== null) {
    const root = createRoot(start);
    const elt = <Default />;
    root.render(elt);
} 