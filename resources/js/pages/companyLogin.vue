
<template>
    <div class="container">
        <div class="row justify-content-center mt-5 align-items-center">
            <div class="col-lg-5 col-md-6 col-sm-6 offset-lg-7 offset-md-6 offset-sm-6">
                <div class="card shadow">
                    <div class="card-header">
                        <span class="h4 pb-5 pt-5">Company Login</span>
                    </div>

                    <div class="card-body h-100">
                        <form @submit.prevent="onSubmit">

                            <!-- Email -->


                            <!-- Email -->
                            <div class="form-group" :class="{ error: v$.form.email.$errors.length }">
                                <label for="">Email</label>
                                <input class="form-control" placeholder="email" type="email" v-model="v$.form.email.$model">

                                <!-- error message -->

                                <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>



                            <div class="form-group" :class="{ error: v$.form.password.$errors.length }">
                                <label for="">Password</label>
                                <input class="form-control" placeholder="******" type="text"
                                    v-model="v$.form.password.$model">
                                <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>




                            <!-- Submit Button -->
                            <div class="buttons-w ">
                                <v-btn class="m-1" color="danger" :to="{ name: 'company' }" variant="outlined"> Back </v-btn>
                                <v-btn class="m-1" type="submit" color="primary"  variant="flat"> Login </v-btn>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import useVuelidate from '@vuelidate/core'
import { required, email, minLength, helpers ,sameAs } from '@vuelidate/validators'
import Auth from '../Auth';
export default {
    props:['q'],
    setup(props) {
        return {
            v$: useVuelidate(),
            company: props.q
         }
    },
    data() {
        return {
            form: {

                email: 'c1@gmail.com',
                password: '123456',


            },


        }
    },

    validations() {
        return {
            form: {

                email: {
                    required: helpers.withMessage('Email Required', required),
                    email: helpers.withMessage('Email Not Valid', email)
                },
                password: {
                    required: helpers.withMessage('Password is required', required),
                },


            },
        }
    },
    methods: {
         setCompany (){
            let cmpny = localStorage.getItem('c');
            this.company=JSON.parse(cmpny);
        },
        async onSubmit() {
            const result = await this.v$.$validate()
            if (!result) {
                // notify user form is invalid
                return
            }

            try {
                // axios.get('/oauth/personal-access-tokens')
                // .then(response => {
                //     console.log(response.data);
                // });

                const response = await axios.post('api/v1/company-login', {
                    email: this.form.email,
                    company:  this.company,
                    password: this.form.password,
                });
                if (response.status === 200) {

                    if(response.data.status==="success") {
                        Auth.login(response.data.authorization.token,response.data.authorization.c);
                        this.toast.success('Login successful');
                        this.$router.push('/home');
                    }

                }
            } catch (error) {
                // notify Login Error
                console.log(error);
            }

        }
    },
    created(){
        this.setCompany();


    }

}
</script>



<style lang="css" scoped>
.h-100 {
    height: 100% !important;
}

.container {
    justify-content: center;
    height: 100vh;
    /* Adjust as needed */
}</style>

