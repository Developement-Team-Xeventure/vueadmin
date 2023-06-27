<template>
    <form @submit.prevent="login">

      <div>
        <label for="text">Email:</label>
        <input id="text" type="text" v-model="name"  class="form-control"/>
        <span>{{ $v.name.$error ? 'Username Required' : '' }}</span>
      </div>

      <div>
        <label for="password">Password:</label>
        <input id="password" type="password" v-model="password"  class="form-control"/>
        <span>{{ $v.password.$error ? 'Password Required' : '' }}</span>
      </div>
      <div>
        <label for="password">Company:</label>
        <input id="password" type="password" v-model="password"  class="form-control"/>
        <span>{{ $v.password.$error ? 'Password Required' : '' }}</span>
      </div>

      <input type="hidden" name="company"  class="form-control" v-model="company">

      <v-btn type="submit"  color="primary">Login</v-btn>

    </form>
  </template>

  <script>
  import { ref } from 'vue';
  import { useVuelidate } from '@vuelidate/core';
  import { required, email } from '@vuelidate/validators';
import axios from 'axios';

  export default {
    props:['q'],
    setup(props) {
      const name = ref('');
      const password = ref('');
      const company = ref(localStorage.getItem('c') || null); // Use ref to make it reactive
      const rules = {
        name: { required },
        password: { required},
      };

      const setCompany = () => {
        console.log(company);
      let cmpny = localStorage.getItem('c');
      console.log(cmpny + 'xcvxcv');
    };

    setCompany();

    const v$ = useVuelidate(rules, { name, password });
    const  login = async() => {
    v$.value.$touch();
    if (v$.value.$invalid) {
        return;
    }
    try {
                const response = await axios.post('api/v1/company/login',
                {
                    name:name,
                    password:password,
                    company:company,
                }

                );
                console.log(response);
            } catch (error) {
                console.log(error);

        }


      };

      return {
        name,
        password,
        company,
        login,

        $v: v$,
      };
    },

  };
  </script>
