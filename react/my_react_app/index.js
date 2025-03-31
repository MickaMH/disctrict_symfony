import React from 'react'
import ReactDOM from 'react-dom/client'
// import MonPremierComposant from "./jsx/MonPremierComposant";
import ComposantCategories from './jsx/ComposantCategories';

ReactDOM.createRoot(document.getElementById('react-app')).render(
    <React.StrictMode>
        <ComposantCategories />
    </React.StrictMode>,
)