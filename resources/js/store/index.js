// resources/js/store/index.js

import { createStore } from "vuex";

const store = createStore({
    state: {
        /*****************
         **** MODALS ****/
        active_CST_container: false,
        active_add_collection_modal: false,
        active_add_section_modal: false,
        active_delete_collection_modal: false,
        active_delete_section_modal: false,

        /****************
         ****-----******/
        avatar: "",
        workspace: [],
        collections: [],
        sections: [],

        /****************
         ****-----******/
        current_col_name: "",

        /****************
         ****-----******/
        current_section_id: "",
        current_section_name: "",
    },
    mutations: {
        /*****************
         **** MODALS ****/
        resetModals(state) {
            state.active_CST_container = false;
            state.active_add_section_modal = false;
            state.active_add_collection_modal = false;
            state.active_delete_collection_modal = false;
            state.active_delete_section_modal = false;
        },
        setCSTContainerisClose(state, newValue) {
            state.active_CST_container = newValue;
        },
        setAddCollectionModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_add_collection_modal = newValue;
        },
        setAddSectionModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_add_section_modal = newValue;
        },
        setDeleteSectionModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_delete_section_modal = newValue;
        },
        setDeleteCollectionModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_delete_collection_modal = newValue;
        },
        /*****************
         **** ------ ****/
        setWorkspace(state, workspace) {
            state.workspace = workspace;
        },
        setUserAvatar(state, avatar) {
            state.avatar = avatar;
        },

        addCollection(state, collection) {
            state.collections[0] = collection;
        },
        addSection(state, section) {
            state.sections[0] = section;
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
