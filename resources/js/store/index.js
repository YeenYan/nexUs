// resources/js/store/index.js

import { createStore } from "vuex";

const store = createStore({
    state: {
        /*****************
         **** MENUS ****/
        active_priority_menu: false,
        selected_priority_type: null,

        /*****************
         **** MODALS ****/
        active_CST_container: false,
        active_add_collection_modal: false,
        active_add_section_modal: false,
        active_add_task_modal: false,
        active_delete_collection_modal: false,
        active_delete_section_modal: false,

        /****************
         ****-----******/
        avatar: "",
        workspace: [],

        /***********************
         **** COLLECTION ******/
        collections: [],
        current_col_name: "",

        /***********************
         ******* SECTION ******/
        sections: [],
        current_section_id: "",
        current_section_name: "",

        /***********************
         ******** TASK ********/
        tasks: [],
    },
    mutations: {
        /*****************
         **** MENUS ****/
        showPriorityMenu(state, newValue) {
            state.active_priority_menu = newValue;
        },

        /*****************
         **** MODALS ****/
        resetModals(state) {
            state.active_CST_container = false;
            state.active_add_collection_modal = false;
            state.active_add_section_modal = false;
            state.active_add_task_modal = false;
            state.active_delete_collection_modal = false;
            state.active_delete_section_modal = false;
        },
        setCSTContainerisClose(state, newValue) {
            state.active_CST_container = newValue;
        },

        /*****************************************
         *************** WORKSPACE ***************
         ****************************************/
        setWorkspace(state, workspace) {
            state.workspace = workspace;
        },
        setUserAvatar(state, avatar) {
            state.avatar = avatar;
        },

        /*****************************************
         ************* COLLECTIONS ***************
         ****************************************/
        setAddCollectionModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_add_collection_modal = newValue;
        },
        setDeleteCollectionModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_delete_collection_modal = newValue;
        },
        addCollection(state, collection) {
            state.collections[0] = collection;
        },

        /*****************************************
         ************** SECTIONS *****************
         ****************************************/
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
        addSection(state, section) {
            state.sections[0] = section;
        },

        /*****************************************
         **************** TASKS ******************
         ****************************************/
        setAddTaskModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_add_task_modal = newValue;
        },
        addTask(state, task) {
            state.tasks[0] = task;
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
