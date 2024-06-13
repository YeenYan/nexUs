// resources/js/store/index.js

import { createStore } from "vuex";

const store = createStore({
    state: {
        /*****************
         **** MODALS ****/
        is_close: false,

        /****************
         ****-----******/
        workspace: [],
        avatar: "",
    },
    mutations: {
        /*****************
         **** MODALS ****/
        setIsClose(state, newValue) {
            state.is_close = newValue;
        },
        /*****************
         **** ------ ****/
        setWorkspace(state, workspace) {
            state.workspace = workspace;
        },
        setUserAvatar(state, avatar) {
            state.avatar = avatar;
        },
    },
    actions: {
        initializeStore({ commit }, { workspace, avatar }) {
            commit("setWorkspace", workspace);
            commit("setUserAvatar", avatar);
        },
    },
});

export default store;
