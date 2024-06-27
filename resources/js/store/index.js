// resources/js/store/index.js

import { createStore } from "vuex";

const store = createStore({
    state: {
        /*****************
         **** MODALS ****/
        active_CST_container: false,
        active_add_collection_modal: false,
        active_add_section_modal: false,

        /****************
         ****-----******/
        workspace: [],
        avatar: "",
    },
    mutations: {
        /*****************
         **** MODALS ****/
        setCSTContainerisClose(state, newValue) {
            state.active_CST_container = newValue;
        },
        setAddCollectionModalIsClose(state, newValue) {
            state.active_CST_container = newValue;
            state.active_add_collection_modal = newValue;
        },
        setAddSectionModalIsClose(state, newValue) {
            state.active_CST_container = newValue;
            state.active_add_section_modal = newValue;
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
