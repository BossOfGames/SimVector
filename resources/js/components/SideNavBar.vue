<template>
    <div class="sn-nav-panel">
        <div class="sn-brand">
            <img style="width: 100%; height: 100%;" src="/img/logo.svg"/>
        </div>
        <div class="sn-nav">
            <div class="sp-nav-item">
                <div>
                    <i class="material-icons">info</i>
                    <div>
                        Info
                    </div>
                </div>
            </div>
            <div class="sp-nav-item">
                <div>
                    <i class="material-icons">info</i>
                    <div>
                        Info
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SideNavBar"
    }
</script>

<style scoped>
    .sp-nav-item {
        flex: 1;
        text-align: center;
        line-height: 1;
        padding: .25rem 1rem;
        padding-bottom: .5rem;
        color: white;
        border: none;
        background: transparent;
        text-decoration: none;
        text-underline: none;
        transition: .2s;
    }
    .sp-nav-item:hover {
        background: #ffcc00;
        transition: .2s;
        color: white;
        border: none;
        text-decoration: none;
        text-underline: none;
    }
    .sn-nav-item {
        width: 100%;
        padding: .25rem auto;
    }
    .sn-nav-panel {
        float: left;
        width: 60px;
        height: 100vh;
    }
    .sn-brand {
        height: 60px;
        background: #1a1a1a;
    }
    .sn-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-flow: row wrap;
        flex-wrap: wrap;
        height: 100%;
    }
</style>
