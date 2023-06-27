<template>
    <div class="container-fluid p-0">

                <h5>Dashboard</h5>


                <h4 v-if="checkAccess('can-edit-dashboard')">
                   View Enabled
                </h4>
                <h4 v-else>
                    Unauthorized Access
                </h4>



        <!-- <router-view> </router-view> -->
    </div>
</template>

<script>

    import Auth from '../Auth.js';
    export default {
        data() {
            return {
                loggedUser: Auth.user,
                user: {},
                permissions: [],
            };
        },
        mounted() {

        },
        methods: {
            async checkAccess(name) {
                Auth.hasAccess(name) // Call the hasAccess function from Auth class
                },
            logout() {
                axios.post('api/v1/logout',{
                    'company': Auth.company,
                    'token': Auth.token,
                })
                .then(({data}) => {
                    if(data.status === true){
                        this.toast.success('Logging out successfully');
                        Auth.logout();
                        this.$router.push('/');
                    }
                })
                .catch((error) => {
                    console.log(error);
                });

            },

          async testUser(){
                try {
                const response = await this.api(
                    'get',
                     'test_permission'
                     );
                if(response.status==200){
                   console.log(response.data);
                }
            } catch (error) {

            }
            }
        },
        created(){
            // this.testUser();
        }
    }
</script>

<style lang="scss" scoped>

</style>
