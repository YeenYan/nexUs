// resources/js/store/index.js

import { createStore } from "vuex";
import axios from "axios";

const store = createStore({
    state: {
        /*****************
         **** MENUS ****/
        active_select_priority_menu: false,
        active_task_priority_menu: false,
        active_activity_priority_menu: false,
        selected_priority_type: null,

        activity_status_menu: false,
        activity_status_type: null,

        /*****************
         **** MODALS ****/
        active_CST_container: false,
        active_add_collection_modal: false,
        active_add_section_modal: false,
        active_add_task_modal: false,
        active_add_activity_modal: false,

        active_delete_collection_modal: false,
        active_delete_section_modal: false,
        active_delete_task_modal: false,
        active_delete_activity_modal: false,

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
        current_section_index: "",
        current_section_id: "",
        current_section_name: "",

        /***********************
         ******** TASK ********/
        tasks: [],
        current_task_index: null,
        task_id: null,
        priority_mode: "select",
        priority_type: null,
        priority_workspace_id: null,
        priority_collection_id: null,
        priority_section_id: null,

        /***********************
         ***** ACTIVITY *******/
        current_task: [],
        show_activity_side: false,
        complete_activity: [],
        in_progress_activity: [],
        to_do_activity: [],

        show_activity_details: false,
        current_activity_details: [],
        status_mode: "select",
    },
    mutations: {
        /*****************
         **** MENUS ****/
        showSelectPriorityMenu(state, newValue) {
            state.active_select_priority_menu = newValue;
        },
        showTaskPriorityMenu(state, newValue) {
            state.active_task_priority_menu = newValue;
        },
        showActivityPriorityMenu(state, newValue) {
            state.active_activity_priority_menu = newValue;
        },

        /*****************
         **** MODALS ****/
        resetModals(state) {
            state.active_CST_container = false;

            state.active_add_collection_modal = false;
            state.active_add_section_modal = false;
            state.active_add_task_modal = false;
            state.active_add_activity_modal = false;

            state.show_activity_details = false;

            state.active_delete_collection_modal = false;
            state.active_delete_section_modal = false;
            state.active_delete_task_modal = false;
            state.active_delete_activity_modal = false;
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
            state.sections.unshift(section);
        },
        updateSection(state, section) {
            state.sections[state.current_section_index] = section;
        },
        deleteSection(state) {
            state.sections.splice(state.current_section_index, 1);
        },

        /*****************************************
         **************** TASKS ******************
         ****************************************/
        setAddTaskModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_add_task_modal = newValue;
        },
        setDeleteTaskModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_delete_task_modal = newValue;
        },
        addTask(state, task) {
            state.change_task_list = true;
            state.tasks.unshift(task);
        },
        update_current_task_list(state, task) {
            let task_index = state.tasks.findIndex(
                (i) => i.task_id == task.task_id
            );
            state.tasks[task_index].task_name = task.task_name;
        },
        delete_task_in_list(state) {
            state.tasks.splice(state.current_task_index, 1);
        },
        /*****************************************
         ************* ACTIVITIES ****************
         ****************************************/
        setAddActivityModalIsClose(state, newValue) {
            this.commit("resetModals");
            state.active_CST_container = newValue;
            state.active_add_activity_modal = newValue;
        },

        setActivityDetailsModalIsClose(state, { isClose, activity_details }) {
            this.commit("resetModals");
            state.active_CST_container = isClose;
            state.show_activity_details = isClose;
            state.current_activity_details = activity_details;
        },
        setDeleteActivityModalIsClose(state, newValue) {
            state.active_delete_activity_modal = newValue;
        },

        /*****************************************
         *********** UPDATE METHODS ************
         ****************************************/
        async update_task_priority_type(state, priority_type) {
            try {
                const response = await axios.put(
                    route("workspace.collection.section.task.update_priority", {
                        workspace: state.priority_workspace_id,
                        collection_id: state.priority_collection_id,
                        section_id: state.priority_section_id,
                        task_id: state.task_id,
                    }),
                    { priority_type: priority_type }
                );
                if (response.status == 200) {
                    state.change_task_list = false;
                    state.tasks[state.current_task_index].priority_type =
                        response.data.single_task.priority_type;
                }
            } catch (error) {
                console.log(error);
            }
        },
        /*****************************************
         ******* UPDATE TASK STARRED VALUE *******
         ****************************************/
        async update_starred(state, starred) {
            try {
                const response = await axios.put(
                    route("workspace.collection.section.task.update_starred", {
                        workspace: state.priority_workspace_id,
                        collection_id: state.priority_collection_id,
                        section_id: state.priority_section_id,
                        task_id: state.task_id,
                    }),
                    { starred: starred }
                );
                if (response.status == 200) {
                    state.change_task_list = false;
                    state.tasks[state.current_task_index].starred =
                        response.data.single_task.starred;
                }
            } catch (error) {
                console.log(error);
            }
        },
        /*****************************************
         ********* UPDATE ACTIVITY NAME **********
         ****************************************/
        async update_activity_name(state, name) {
            try {
                const response = await axios.put(
                    route(
                        "workspace.collection.section.task.activity.update_activity_name",
                        {
                            workspace: state.priority_workspace_id,
                            collection_id: state.priority_collection_id,
                            section_id: state.current_task.section_id,
                            task_id: state.current_activity_details.task_id,
                            activity_id:
                                state.current_activity_details.activity_id,
                        }
                    ),
                    { activity_name: name }
                );
                if (response.status == 200) {
                    let res_data = response.data.updated_activity;
                    state.current_activity_details = res_data;

                    if (res_data.status_type == 2) {
                        locateIndex(state.complete_activity);
                    } else if (res_data.status_type == 1) {
                        locateIndex(state.in_progress_activity);
                    } else if (res_data.status_type == 0) {
                        locateIndex(state.to_do_activity);
                    }

                    function locateIndex(array_type) {
                        let activity_index = array_type.findIndex(
                            (i) => i.activity_id == res_data.activity_id
                        );

                        array_type[activity_index].activity_name =
                            res_data.activity_name;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        /*****************************************
         ***** UPDATE ACTIVITY PRIORITY TYPE *****
         ****************************************/
        async update_activity_priority_type(state, priority_type) {
            console.log({
                workspace: state.priority_workspace_id,
                collection_id: state.priority_collection_id,
                section_id: state.current_task.section_id,
                task_id: state.current_activity_details.task_id,
                activity_id: state.current_activity_details.activity_id,
                priority_type: priority_type,
            });
            try {
                const response = await axios.put(
                    route(
                        "workspace.collection.section.task.activity.update_priority",
                        {
                            workspace: state.priority_workspace_id,
                            collection_id: state.priority_collection_id,
                            section_id: state.current_task.section_id,
                            task_id: state.current_activity_details.task_id,
                            activity_id:
                                state.current_activity_details.activity_id,
                        }
                    ),
                    { priority_type: priority_type }
                );
                if (response.status == 200) {
                    let res_data = response.data.updated_activity;

                    state.current_activity_details.priority_type =
                        res_data.priority_type;

                    if (res_data.status_type == 2) {
                        locateIndex(state.complete_activity);
                    } else if (res_data.status_type == 1) {
                        locateIndex(state.in_progress_activity);
                    } else if (res_data.status_type == 0) {
                        locateIndex(state.to_do_activity);
                    }

                    function locateIndex(array_type) {
                        let activity_index = array_type.findIndex(
                            (i) => i.activity_id == res_data.activity_id
                        );

                        array_type[activity_index].priority_type =
                            res_data.priority_type;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        /*****************************************
         ******* UPDATE ACTIVITY STATUS **********
         ****************************************/
        async update_activity_status_type(state, status_type) {
            try {
                const response = await axios.put(
                    route(
                        "workspace.collection.section.task.activity.update_status",
                        {
                            workspace: state.priority_workspace_id,
                            collection_id: state.priority_collection_id,
                            section_id: state.current_task.section_id,
                            task_id: state.current_activity_details.task_id,
                            activity_id:
                                state.current_activity_details.activity_id,
                        }
                    ),
                    { status_type: status_type }
                );
                if (response.status == 200) {
                    let res_data = response.data.updated_activity;

                    this.commit(
                        "add_count_to_task",
                        response.data.current_task
                    );

                    this.commit("filter_updated_activity_status", {
                        status: status_type,
                        activity_id: state.current_activity_details.activity_id,
                        updated_activity: res_data,
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        /*****************************************
         ******* UPDATE ACTIVITY DUE DATE ********
         ****************************************/
        async update_due_date(state, date) {
            try {
                const response = await axios.put(
                    route(
                        "workspace.collection.section.task.activity.update_due_date",
                        {
                            workspace: state.priority_workspace_id,
                            collection_id: state.priority_collection_id,
                            section_id: state.current_task.section_id,
                            task_id: state.current_activity_details.task_id,
                            activity_id:
                                state.current_activity_details.activity_id,
                        }
                    ),
                    { due_date: date }
                );
                if (response.status == 200) {
                    let res_data = response.data.updated_activity;

                    state.current_activity_details.due_date = res_data.due_date;

                    if (res_data.status_type == 2) {
                        locateIndex(state.complete_activity);
                    } else if (res_data.status_type == 1) {
                        locateIndex(state.in_progress_activity);
                    } else if (res_data.status_type == 0) {
                        locateIndex(state.to_do_activity);
                    }

                    function locateIndex(array_type) {
                        let activity_index = array_type.findIndex(
                            (i) => i.activity_id == res_data.activity_id
                        );

                        array_type[activity_index].due_date = res_data.due_date;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        /*****************************************
         *** UPDATE ACTIVITY DESCRIPTION DATE ****
         ****************************************/
        async update_description(state, description) {
            try {
                const response = await axios.put(
                    route(
                        "workspace.collection.section.task.activity.update_description",
                        {
                            workspace: state.priority_workspace_id,
                            collection_id: state.priority_collection_id,
                            section_id: state.current_task.section_id,
                            task_id: state.current_activity_details.task_id,
                            activity_id:
                                state.current_activity_details.activity_id,
                        }
                    ),
                    { description: description }
                );
                if (response.status == 200) {
                    state.current_activity_details =
                        response.data.updated_activity;

                    console.log(response.data.updated_activity);
                }
            } catch (error) {
                console.log(error);
            }
        },
        /*****************************************
         *********** DELETE ACTIVITY *************
         ****************************************/
        async delete_activity(state) {
            try {
                const response = await axios.delete(
                    route(
                        "workspace.collection.section.task.activity.destroy",
                        {
                            workspace: state.priority_workspace_id,
                            collection_id: state.priority_collection_id,
                            section_id: state.current_task.section_id,
                            task_id: state.current_activity_details.task_id,
                            activity:
                                state.current_activity_details.activity_id,
                        }
                    )
                );
                if (response.status == 200) {
                    this.commit(
                        "add_count_to_task",
                        response.data.current_task
                    );

                    if (state.current_activity_details.status_type == 2) {
                        locateIndex(state.complete_activity);
                    } else if (
                        state.current_activity_details.status_type == 1
                    ) {
                        locateIndex(state.in_progress_activity);
                    } else if (
                        state.current_activity_details.status_type == 0
                    ) {
                        locateIndex(state.to_do_activity);
                    }

                    function locateIndex(array_type) {
                        let activity_index = array_type.findIndex(
                            (i) =>
                                i.activity_id ==
                                state.current_activity_details.activity_id
                        );

                        array_type.splice(activity_index, 1);
                    }

                    this.commit("resetModals");
                }
            } catch (error) {
                console.log(error);
            }
        },

        /*****************************************
         ******** FETCHING ACTIVITIES ************
         ****************************************/
        async show_activities(state, task) {
            state.complete_activity = [];
            state.in_progress_activity = [];
            state.to_do_activity = [];

            try {
                const response = await axios.get(
                    route("workspace.collection.section.task.show", {
                        workspace: state.priority_workspace_id,
                        collection_id: state.priority_collection_id,
                        section_id: task.section_id,
                        task_id: task.task_id,
                    })
                );

                if (response.status == 200) {
                    this.commit(
                        "filter_activity_status",
                        response.data.activities
                    );
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    // form.errors = error.response.data.errors;
                    // Handle errors in your form or display them to the user
                } else if (error.response) {
                    // Other server errors (handle as needed)
                    console.error("Server error:", error.response.data.message);
                } else {
                    // Network or client-side errors
                    console.error("Error creating task:", error.message);
                }
            }
        },
        /*****************************************
         ********* FILTERING ACTIVITIES **********
         ********* BASED ON STATUS TYPE **********
         ****************************************/
        filter_activity_status(state, activity_list) {
            for (let i = 0; i < activity_list.length; i++) {
                // console.log(activity_list[i].status_type);
                if (activity_list[i].status_type == 2) {
                    state.complete_activity.push(activity_list[i]);
                } else if (activity_list[i].status_type == 1) {
                    state.in_progress_activity.push(activity_list[i]);
                } else {
                    state.to_do_activity.push(activity_list[i]);
                }
            }
        },
        /*****************************************
         ********* FILTERING ACTIVITIES **********
         ******** AFTER UPDATING STATUS **********
         ****************************************/
        filter_updated_activity_status(
            state,
            { status, activity_id, updated_activity }
        ) {
            // For removing in the current array
            if (state.current_activity_details.status_type == 2) {
                locateIndex_remove(state.complete_activity);
            } else if (state.current_activity_details.status_type == 1) {
                locateIndex_remove(state.in_progress_activity);
            } else if (state.current_activity_details.status_type == 0) {
                locateIndex_remove(state.to_do_activity);
            }

            // Getting the Index from the given array then remove it
            function locateIndex_remove(array_type) {
                let activity_index = array_type.findIndex(
                    (i) => i.activity_id == activity_id
                );

                if (activity_index < 0) {
                    // This is when their's no match
                } else {
                    array_type.splice(activity_index, 1);
                }
            }

            // Adding to the specified array
            if (status == 2) {
                state.complete_activity.push(updated_activity);
                state.current_activity_details.status_type = 2;
            } else if (status == 1) {
                state.in_progress_activity.push(updated_activity);
                state.current_activity_details.status_type = 1;
            } else if (status == 0) {
                state.to_do_activity.push(updated_activity);
                state.current_activity_details.status_type = 0;
            }
        },

        /*****************************************
         ***** ADDING ACTIVITY COUNT TO TASK *****
         ******** AFTER CREATING ACTIVITY ********
         ****************************************/
        add_count_to_task(state, task) {
            let task_index = state.tasks.findIndex(
                (i) => i.task_id == task.task_id
            );

            state.tasks[task_index] = task;
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
