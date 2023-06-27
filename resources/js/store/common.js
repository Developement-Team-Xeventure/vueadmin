import Vuex from "vuex";
import axios from "axios";

export default new Vuex.Store({

    state: {
        sidebarMenuItems: [],
        partyGroups: [],
    },

    getters: {
        
    },
    mutations: {
        SET_SIDEBAR_LINKS(state, links) {
            state.sidebarMenuItems = links
        },

    },
    actions: {
        sidebarMenus({ commit }) {
            axios.get(`/api/v1/sidebar`)
                .then((s) => {
                    //console.log(s.data.data);
                    if (s.data.data) {
                        this.commit('SET_SIDEBAR_LINKS',
                            s.data.data.map((r) => {

                                return {
                                    name: r.name,
                                    value: r.value,
                                    icon: r.icon,
                                    display: r.display,
                                    parent: r.parent,
                                    child: r.child,
                                    gchild: r.grandChild,

                                }
                            }))


                    }
                })
        },


    },

    modules: {

    }

});
