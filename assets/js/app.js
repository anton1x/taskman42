import ReactDOM from 'react-dom';
import React from 'react';
import UserRightsManager from './components/UserRightsManager/UserRightsManager';
import store from './components/UserRightsManager/Store/state';
/*
 * Welcome to your app's main JavaScript file!
 *
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('../css/style.scss');



// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');


require('bootstrap/dist/js/bootstrap.bundle.js');


const $user_rights_manager = $('#user-rights-manager');
if($user_rights_manager.length){
    const manage_user_endpoint = $user_rights_manager.data('endpoint');
    ReactDOM.render(<UserRightsManager endpoint={manage_user_endpoint}></UserRightsManager>, $user_rights_manager[0]);
}

store.subscribe(()=>console.log(store.getState()));
store.dispatch({
    type: 'UPDATE_RIGHTS',
    payload: {
        rights: ['CAN_VIEW_PROJECT']
    }
})

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
