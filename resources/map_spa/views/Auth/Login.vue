<template>
    <v-content fill-height style="background: center url('/img/vaos_df_bg-01.svg'); background-size: cover">
        <v-container class="fill-height" style="height: 100vh" fluid>
            <v-row align="center" justify="center">
                <v-col cols="12" sm="8" md="3">
                    <v-card class="elevation-12">
                        <v-toolbar color="primary" dark flat>
                            <v-toolbar-title>{{ comm_name }} Login</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        label="Email"
                                        name="login"
                                        prepend-icon="email"
                                        type="text"
                                ></v-text-field>

                                <v-text-field
                                        id="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="lock"
                                        type="password"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <div class="flex-grow-1"></div>
                            <v-btn color="accent">Register</v-btn>
                            <v-btn color="primary">Login</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-content>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                comm_name: window.appSettings.community_name
            }
        }
    }
</script>

<style scoped>

</style>