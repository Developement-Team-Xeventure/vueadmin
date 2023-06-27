<template>
        <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle" @click="toggleSidebarVariable">
                    <i class="hamburger align-self-center"></i>

                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">

                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-bs-toggle="dropdown"> <span class="text-dark">Admin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="settings"></i> Settings & Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" role="button"
                                @click="logout()"

                                >Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>


</template>

<script>

// import eventBus from '../event-bus';

import Auth from '../../Auth';
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
            toggleSidebarVariable() {
            this.$emit('toggleSidebarVariable');
            },

            async checkAccess(name) {
                Auth.hasAccess(name)
            },

            logout() {
                axios.post('/api/v1/logout',{
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




        },
        created(){

        }
    }
</script>

<style lang="css" scoped>

</style>
