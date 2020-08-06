<template>
    <div style="height: 100%;">
        <iframe src="/engine"></iframe>
    </div>
</template>

<script>
    import IFrameContainerView from "./iFrameContainerView";
    export default {
        name: "LiveMapView",
        components: {IFrameContainerView}
    }
</script>

<style scoped>
    iframe {
        border: none;
        width: 100%;
        height: 100%;
    }
</style>
