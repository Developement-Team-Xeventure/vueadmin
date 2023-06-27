
<template>
    <div class="container">
        <div class="row justify-content-center mt-5 align-items-center">
            <div class="col-lg-5 col-md-6 col-sm-6 offset-lg-7 offset-md-6 offset-sm-6">
                <div class="card shadow">
                    <div class="card-header">
                        <span class="h4 pb-5 pt-5">Register Company</span>
                    </div>

                    <div class="card-body h-100">
                        <form @submit.prevent="onSubmit">
                            <!-- Name -->
                            <div class="form-group" :class="{ error: v$.form.name.$errors.length }">
                                <label for="">Business Name</label>
                                <input class="form-control" placeholder="Business Name" type="text"
                                    v-model="v$.form.name.$model">

                                <!-- error message -->

                                <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group" :class="{ error: v$.form.email.$errors.length }">
                                <label for="">Email</label>
                                <input class="form-control" placeholder="email" type="email" v-model="v$.form.email.$model">

                                <!-- error message -->

                                <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>



                            <!-- Phone -->
                            <div class="form-group" :class="{ error: v$.form.phone.$errors.length }">
                                <label for="">Phone</label>
                                <input class="form-control" placeholder="xxxxxxx" type="text"
                                    v-model="v$.form.phone.$model">

                                <!-- error message -->

                                <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>
                            <!-- B type -->
                            <div class="form-group" :class="{ error: v$.form.btype.$errors.length }">
                                <label for="">Business Type</label>
                                <select v-model="v$.form.btype.$model" class="form-control">
                                    <option value="">Select</option>
                                    <option  v-if="btypes"  v-for="btype in btypes" :value="btype.id">{{ btype.type }}</option>
                                </select>
                                <div class="input-errors" v-for="(error, index) of v$.form.btype.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <!-- B Cat -->
                            <div class="form-group" :class="{ error: v$.form.bcat.$errors.length }">
                                <label for="">Business Category</label>
                                <select v-model="v$.form.bcat.$model" class="form-control">
                                    <option value="">Select</option>
                                    <option  v-if="bcats"  v-for="bcat in bcats" :value="bcat.id">{{ bcat.category }}</option>

                                </select>
                                <div class="input-errors" v-for="(error, index) of v$.form.bcat.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <!-- B Country -->
                            <div class="form-group" :class="{ error: v$.form.country.$errors.length }">
                                <label for="">Country</label>
                                <select v-model="v$.form.country.$model" class="form-control">
                                    <option value="101">India</option>
                                </select>
                                <div class="input-errors" v-for="(error, index) of v$.form.country.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div>

                            <!-- B State -->
                            <div class="form-group" :class="{ error: v$.form.state.$errors.length }">
                                <label for="">State</label>
                                <select v-model="v$.form.state.$model" class="form-control">
                                    <option value="4028">Kerala</option>
                                </select>
                                <div class="input-errors" v-for="(error, index) of v$.form.state.$errors" :key="index">
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


                            <!-- <div class="form-group"  >
                                <label for="">Confirm Password</label>
                                <input class="form-control" placeholder="******" type="text"
                                    v-model="v$.form.confirm_password.$model">
                                    <div class="input-errors" v-for="(error, index) of v$.form.confirm_password.$errors" :key="index">
                                    <div class="error-msg">{{ error.$message }}</div>
                                </div>
                            </div> -->



                            <!-- Submit Button -->
                            <div class="buttons-w ">
                                <v-btn class="m-1" color="danger" :to="{ name: 'company' }" variant="outlined"> Back </v-btn>
                                <v-btn class="m-1" color="primary"  type="submit" variant="flat"> Register </v-btn>

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

export default {
    setup() {
        return { v$: useVuelidate() }
    },

    data() {
        return {
            form: {
                name: 'Name',
                email: 'email@gmail.com',
                phone: '123456789',
                btype: 2,
                bcat: 2,
                state: 4028,
                country: 101,
                password: '123456',
                // confirm_password: '',
            },
            btypes:[],
            bcats:[],

        }
    },

    validations() {
        return {
            form: {
                name: {
                    required: helpers.withMessage('Business Name Required', required),
                    min: minLength(2)
                },
                email: {
                    required: helpers.withMessage('Business Email Required', required),
                    email: helpers.withMessage('Email Not Valid', email)
                },
                phone: {
                    required: helpers.withMessage('Phone is required', required),
                    min: minLength(8)
                },
                btype: {
                    required: helpers.withMessage('Business Type is required', required),
                },
                bcat: {
                    required: helpers.withMessage('Business Category is required', required),
                },
                state: {
                    required: helpers.withMessage('State is required', required),
                },
                country: {
                    required: helpers.withMessage('Country is required', required),
                },
                password: {
                    required: helpers.withMessage('Password is required', required),
                },
                // confirm_password: sameAs(this.password)

            },
        }
    },
    methods: {

        async fetchBusinessCategories(){
            try {
                const response = await axios.get('api/v1/b-categories');
                if (response.status == 200) {
                    this.bcats = response.data.data;

                }
            } catch (error) {
                console.log(error);
            }
        },

        async fetchBusinessTypes(){
            try {
                const response = await axios.get('api/v1/b-types');
                if (response.status == 200) {
                    this.btypes = response.data.data

                }
            } catch (error) {
                console.log(error);
            }
        },

        async onSubmit() {
            const result = await this.v$.$validate()
            if (!result) {
                // notify user form is invalid
                return
            }

            try {

                const response = await axios.post('api/v1/company', {
                    name: this.form.name,
                    email: this.form.email,
                    phone: this.form.phone,
                    btype: this.form.btype,
                    bcat: this.form.bcat,
                    state: this.form.state,
                    country: this.form.country,
                    password: this.form.password,
                });
                if (response.status == 201) {
                    this.$router.push({ name: 'company' })
                }
            } catch (error) {
                // notify Company Creation Error
                console.log(error);
            }

        }
    },
    created(){
        this.fetchBusinessCategories();
        this.fetchBusinessTypes();
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

