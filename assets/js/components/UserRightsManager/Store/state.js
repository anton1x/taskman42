import {createStore} from 'redux';


function reducer(state, action) {
    switch (action.type){
        case 'UPDATE_RIGHTS':
            return state = {...state, ...action.payload};
            break;
        default:
            return state;
    }
}

const store = createStore(reducer, {
    rights: []
});

export default store;