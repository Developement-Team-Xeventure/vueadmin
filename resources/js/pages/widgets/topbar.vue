<template>
    <div class="col-lg-12 mb-3">
           <div class="card border-radius-xl">
               <div class="card-header">
                  <div class="row">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <router-link v-if="checkAccess('can-view-users')"  class="flex-sm-fill text-sm-center nav-link bg-light border-radius-xl me-2" active-class="activeTop" :to="{name:'user'}">Users</router-link>
                        <router-link v-if="checkAccess('can-view-permissions')" class="flex-sm-fill text-sm-center nav-link bg-light border-radius-xl me-2" active-class="activeTop" :to="{name:'permission'}">Permissions</router-link>
                        <!-- <router-link class="flex-sm-fill text-sm-center nav-link bg-light border-radius-xl me-2" active-class="activeTop" :to="{name:'general'}">Transaction</router-link> -->

                    </nav>
                  </div>
               </div>
           </div>
    </div>
</template>

<script>
import Auth from '../../Auth';
export default {
    data() {
        return {
            users:[
                {
                    id:1,
                    name:'User 1',

                }
            ]
        }
    },
    methods:{
        async checkAccess(name) {
            Auth.hasAccess(name)
        },
    }
}
</script>


<style lang="scss" scoped>

</style>
