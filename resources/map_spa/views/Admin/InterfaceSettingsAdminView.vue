<template>
    <div>
        <div class="display-2">Material Crew Global Settings</div>
        <v-alert dense border="left" type="warning" class="hidden-sm-and-up">
            For best editing experience, use a larger device.
        </v-alert>
        <v-container>
            <v-row>
                <v-flex md6 s12>
                    <v-card>
                        <div>General Settings</div>
                        <v-card-text>
                            <div class="title">Colors:</div>
                            <div class="d-inline-flex">
                                <div>
                                    <div>Primary:</div>
                                    <div class="dot"></div>
                                </div>
                                <div>
                                    <div>Accent:</div>
                                    <div class="dot"></div>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-row>
        </v-container>
    </div>
</template>

<script>
    export default {
        name: "InterfaceSettingsAdminView",
        data() {
            return {
                settings: {
                    colors: {
                        primary: "",
                        accent: "",
                        dark: true
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .dot {
        border-radius: 50%;
        height: 25px;
        width: 25px;
        margin: auto;
        border: 2px solid white;
    }
</style>