<template>
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-6 vh-100">
          <div class="card h-100">
            <div class="card-header">
              <div class="ms-auto d-flex my-auto mt-lg-0 mt-4 justify-content-between">
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                  <div class="input-group ps-2 pe-2">
                    <input class="form-control border-white" id="myInput" type="text" v-model="search" placeholder="Search..." />
                  </div>
                  <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group"></div>
                </div>
                <v-btn color="success" size="small" @click="showAddModal">
                  <span>Add</span>
                </v-btn>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>
                        <a href="#" class="text-muted pe-1" @click.prevent="change_sort('name')">User</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                      </th>

                      <th>
                        <a href="#" class="text-muted pe-1" @click.prevent="change_sort('role')">Role</a>
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
                      <td class="hover text-left" @click="pp = user.id">
                        {{ user.name }}
                      </td>
                      <td>
                        <template v-if="user.roles && user.roles.length >= 0">

                          <div v-for="userRole in user.roles">
                            {{ userRole.role_name }}
                          </div>
                        </template>
                      </td>
                      <td class="text-left">
                        <div class="d-flex gap-3">
                            <template v-if="checkAccess('can-edit-users')">
                                <div>
                                    <i class="fa fa-edit fa-1x text-warning"  @click.prevent="showEditModal(user)"></i>
                                </div>
                            </template>
                          <template v-if="checkAccess('can-delete-users')">
                            <div>
                            <i class="fa fa-trash text-danger" @click.prevent="removeUser(user)"></i>
                            </div>
                          </template>

                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 vh-100"></div>
        <v-row justify="center">
          <v-dialog v-model="dialog" width="500px">
            <v-card class="p-3">
              <v-card-title>
                <span class="text-h5">{{ idAdd ? "Add User" : "Edit User" }}</span>
              </v-card-title>

              <v-form v-model="form" @submit.prevent="onSubmit">
                <v-card-text>

                  <v-text-field class="mb-2" clearable :rules="[rules.required]" v-model="name" label="User Name" :error-messages="errors.name ? [errors.name[0]] : []" color="primary" variant="outlined"></v-text-field>
                  <v-text-field class="mb-2" :rules="[rules.required]" clearable variant="outlined" label="Email" type="email" color="primary" v-model="email"  :error-messages="errors.email ? [errors.email[0]] : []"></v-text-field>
                  <v-text-field class="mb-2" :rules="[rules.required]" clearable variant="outlined" label="Password" color="primary" v-model="password" type="password" :error-messages="errors.password ? [errors.password[0]] : []"></v-text-field>
                  <v-autocomplete class="mb-2" :rules="[rules.required]" color="primary" v-model="role" :items="roles" item-title="role_name" item-value="v" label="Select Role" variant="outlined" :error-messages="errors.role ? [errors.role[0]] : []"></v-autocomplete>

                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="danger" size="small" type="reset" @click="closeModal()">Close</v-btn>
                  <v-btn  :loading="loading" color="success" size="small" type="submit" variant="elevated">Add</v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
        </v-row>
      </div>
    </div>
  </template>

  <script>
  import axios from "axios";
  import Auth from "../../../Auth";

  export default {
    data() {
      return {
        users: [],
        roles: [],
        dialog: false,
        idAdd: true,
        form: false,
        name: null,
        password: null,
        email: null,
        role: null,
        loading: false,

        isEdit: false,
        isAdd: false,
        isDelete: false,


        rules: {
          required: (value) => !!value || "Field is required",
        },
        errors: {},
      };
    },


    methods: {
        async checkAccess(name) {
                Auth.hasAccess(name) // Call the hasAccess function from Auth class
                },


      async fetchUsers() {
        try {
          const response = await this.api("get", "users");
          if (response.status == 200) {
            if (response.data.users) {
              this.users = response.data.users;
            }
          }
        } catch (error) {}
      },
      async fetchRoles() {
        try {
          const response = await this.api("get", "roles");
          if (response.status == 200) {
            if (response.data.roles) {
              this.roles = response.data.roles;
            }
          }
        } catch (error) {}
      },
      closeModal(){
        this.dialog = false
        this.loading =false
      },
      showAddModal() {
        this.fetchRoles();
        this.idAdd = true;
        this.dialog = true;
      },
      showEditModal(user) {
        this.fetchRoles();
        this.idAdd = false;
        this.dialog = true;
      },
      addUser() {
        this.dialog = false;
      },
      onSubmit() {
        if(!this.errors){
            return
        }
        // if (!this.form) return;
        this.loading = true;
        this.errors= {};
         axios
          .post("/api/v1/user", {
            name: this.name,
            email: this.email,
            password: this.password,
            role: this.role,
          })
          .then((response) => {
            this.loading = false;
            this.dialog = false;
            // Handle successful form submission
            // ...
          })
          .catch((error) => {
            if (error.response && error.response.status === 422) {
              this.loading = false;
              this.errors = error.response.data.errors;
            }
          });
      },
    },
    created() {
      this.fetchUsers();
    },
  };
  </script>

  <style lang="scss" scoped></style>
