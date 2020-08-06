<template>
    <div style="height: 100%;">
        <iframe :src="frame_source"></iframe>
    </div>
</template>

<script>
    export default {
        name: "iFrameContainerView",
        data() {
            return {
                frame_source: ""
            }
        },
        created() {
            this.frame_source = this.$router.currentRoute.meta.frameUrl
        }
    }
</script>

<style scoped>
iframe {
    border: none;
    width: 100%;
    height: 100%;
}
</style>