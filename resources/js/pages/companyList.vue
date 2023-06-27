<template>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">

                        <v-card title="Companies" subtitle="Select company" variant="">

                        <div class="row justify-content-center">
                            <div class="col-lg-12 ">
                                <div class="card me-2 ms-2" v-if="companies&&companies.length>0" v-for="company in companies">
                                    <div class="card-body d-flex justify-content-between">
                                        <div class="div">
                                            {{ company.name }}
                                        </div>
                                        <div class="div">
                                            <v-btn color="primary" @click="setCompany(company.code)"
                                            variant="flat">
                                            Open
                                            </v-btn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <div class="">
                                <v-btn color="primary" :to="{ name: 'company-register' }" variant="outlined"> New Company </v-btn>
                            </div>
                        </div>
                        </v-card>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>


<script>

export default {
    data() {
        return {
            companies: []
        }
    },
    methods: {

        setCompany(cmpny){
            localStorage.setItem('c', JSON.stringify(cmpny));
            this.$router.push('/login');
        },

        async fetchCompanies() {
            try {
                const response = await this.api('get', 'company', { id: 1 });
                if(response.status==200){
                    this.companies=response.data.company
                }
            } catch (error) {

            }
        }

    },
    created(){
        this.fetchCompanies();
    }
}
</script>

<style lang="css" scoped>
.card-body {
    height: 100% !important;
}
</style>
