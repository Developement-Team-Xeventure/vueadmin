<template>
<!--
<div class="container-scroller content">
      <Navbar/>
      <div class="container-fluid page-body-wrapper ">
         <Sidebar/>

          <div class="main-panel" >
            <router-view v-slot="{ Component }">
            <transition name="scale" mode="out-in">
            <component :is="Component" />
            </transition>
            </router-view>
          </div>


    </div>
    {{ (Request::routeIs("users") ? 'active' : '') }}
    </div> -->
    <div class="wrapper">
        <sidebar :sidebarVariable="sidebarVariable" />

        <div class="main">
            <Navbar @toggleSidebarVariable="toggleSidebarVariable" />


            <main class="content">

                <router-view>

                   </router-view>

            </main>
        </div>
    </div>


</template>

<script>

import Navbar from './common/headerComponent.vue';
import Sidebar from './common/sidebarComponent.vue';


export default {
    components:{
        Navbar:Navbar,
        Sidebar:Sidebar,

    },
    data () {
        return {
            sidebarVariable: false
        }
    },
    methods:{
        toggleSidebarVariable() {
            this.sidebarVariable = !this.sidebarVariable;
        }


    }
}
</script>

<style lang="scss" scoped>

</style>
