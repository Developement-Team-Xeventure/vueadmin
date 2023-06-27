<template>
   <nav id="sidebar" :class="`sidebar js-sidebar ${sidebarVariable?'collapsed':''}`">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="#">
                    <span class="align-middle">Billonex</span>
                </a>
                <ul class="sidebar-nav">

                     <li class="sidebar-header">
                        Main
                    </li>


                    <li v-for="menu in menusItems" :key="menu.id" class="sidebar-item" :class="{ 'has-submenu': menu.is_parent }">

                        <router-link v-if="menu.is_parent==0&&menu.is_child==0" class="sidebar-link" :to="{ name: menu.route }">
                            <i  :class="`bx bx-${menu.icon}`"></i>
                            <span class="">{{ menu.title }}</span>
                        </router-link>

                        <a v-else-if="menu.is_parent==1&&menu.is_child==0" :data-bs-target="`#menu-${menu.id}`" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i :class="`bx bx-${menu.icon}`"></i>
                             <span class="mb-2">{{ menu.title }}</span>
						</a>

                        <ul :id="`menu-${menu.id}`" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item" v-for="subMenu in menusItems" :key="subMenu.id">

                                <router-link class="sidebar-link" :to="{ name: subMenu.route }"
                                    v-if="subMenu.parent_id === menu.id && subMenu.is_child === 1">
                                    {{ subMenu.title }}
                                </router-link>

                            </li>
                        </ul>

                    </li>




                </ul>

            </div>
        </nav>
</template>


<script>
    export default {
  data() {
    return {
        menusItems: [],
        collapse: false,
    };
  },

  props: {
    sidebarVariable: {
      type: Boolean,
      required: true
    }
  },

  methods: {
    async sidebarMenus() {
            try {
                const response = await this.api('get', 'menus');
                if(response.status==200){
                    this.menusItems=response.data.menus;
                }
            } catch (error) {

            }
        }
  },
  created() {
      this.sidebarMenus();
    },
};
</script>

<style lang="css">


</style>

