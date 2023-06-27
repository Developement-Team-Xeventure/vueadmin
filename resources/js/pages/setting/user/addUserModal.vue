<template>
    <v-row justify="center">
        <v-dialog v-model="dialog"  persistent width="1024">

            <v-card>
                <v-card-title>
                    <span class="text-h5">Add User</span>
                </v-card-title>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="dialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="dialog = false"
                    >
                        Save
                    </v-btn>
                </v-card-actions>


            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
  export default {
    props:['open'],
    data: () => ({
      dialog: this.open|| false,
    }),
  }
</script>

<style lang="scss" scoped></style>
