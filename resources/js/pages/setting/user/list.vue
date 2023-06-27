<template>

<div class="col-lg-12">

<div class="row">
    <div class="col-lg-6 vh-100">
        <div class="card h-100">
            <div class="card-header">
                <div class="ms-auto  d-flex my-auto mt-lg-0 mt-4 justify-content-between">
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <div class="input-group ps-2 pe-2">
                            <input class="form-control border-white" id="myInput" type="text" v-model="search"
                                placeholder="Search...">
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        </div>
                    </div>
                    <v-btn color="success" size="small" @click="showAddModal">
                        <span>Add</span>
                    </v-btn>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm ">
                        <thead>
                            <tr>
                                <th><a href="#" class="text-muted pe-1" @click.prevent="change_sort('name')">
                                        User</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>

                                <th><a href="#" class="text-muted pe-1" @click.prevent="change_sort('role')">
                                        Role</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'role'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'role'">&darr;</span>
                                </th>

                                <th class="text-right text-muted">
                                    <i class="fa fa-ellipsis-vertical"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="user in users" v-if="users">

                                <td  class="hover text-left " @click="pp = user.id">
                                    <!-- {{ user.name }} -->
                                    {{ user.name }}
                                </td>
                                <td>

                                    <template v-if=" user.roles && user.roles.length>=0">
                                        <div v-for="userRole in user.roles">
                                            {{ userRole.name}}
                                        </div>
                                    </template>

                                </td>
                                <td class="text-left">
                                    <div class="d-flex gap-3">
                                        <i class="fa fa-edit fa-1x text-warning" v-if="checkAccess('can-edit-users')" @click.prevent="showEditModal(user)">
                                        </i>


                                        <i class="fa fa-trash text-danger" v-if="checkAccess('can-delete-users')" @click.prevent="removeUser(user)">
                                        </i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <div class="col-lg-6 vh-100">

    </div>
    <template>
    <v-row justify="center">
        <v-dialog v-model="dialog"   width="500px">

            <v-card>
                <v-card-title>
                    <span class="text-h5">{{idAdd ? 'Add User':'Edit User'}}</span>
                </v-card-title>

            <v-card-text>

                <v-text-field clearable  label="User Name" color="primary" variant="outlined"></v-text-field>
                {{ roles }}
                <v-autocomplete clearable  label="User Role" color="primary" variant="outlined"
                :items=roles
                ></v-autocomplete>

            </v-card-text>



                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="danger"
                        size="small"
                        @click="dialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="primary"
                        size="small"
                        @click="addUser()"
                    >
                        Save
                    </v-btn>
                </v-card-actions>


            </v-card>
        </v-dialog>
    </v-row>
</template>

</div>
</div>
</template>

<script>

import Auth from '../../../Auth';

export default {


    data() {
        return {
        users:[],
        roles:[],
        dialog:false,
        idAdd:true,
        form:{
            name: '',
            role: '',
        }

        }
    },
    methods:{
        async checkAccess(name) {
            Auth.hasAccess(name)
        },
        async fetchUsers(){
            try {
                const response = await this.api('get', 'users');
                if(response.status==200){
                    if(response.data.users){
                        this.users=response.data.users
                    }
                }
            } catch (error) {

            }
        },
        async fetchRoles(){
            try {
                const response = await this.api('get', 'roles');
                if(response.status==200){
                    if(response.data.roles){
                        // this.roles=response.data.roles
                        this.roles = response.data.roles.filter(e => {
                                return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
                            })
                    }
                }
            } catch (error) {

            }
        },
        showAddModal(){
            this.fetchRoles();

            this.idAdd=true
            this.dialog=true
        },
        showEditModal(user){
            this.fetchRoles();
            this.idAdd=false
            this.dialog=true
        },
        addUser(){
            this.dialog=false
        }

    },
    created(){

        this.fetchUsers();
    }
}
</script>

<style lang="scss" scoped>

</style>
