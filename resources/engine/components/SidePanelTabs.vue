<template>
    <div style="display: flex; flex-direction: column; justify-content: space-between; height: 100%">
        <div>
            <slot :name="tabBodyName"></slot>
        </div>
        <div class="footer-nav">
            <button class="footer-nav-item" v-for="tab in tabs" :name="tab" @click="switchTab(tab)" :class="{ 'footer-nav--active': activeTab === tab}">
                <slot :name="tabNavName(tab)"></slot>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SidePanelTabs",
        props: {
            initialTab: String,
            tabs: Array
        },
        data() {
            return {
                activeTab: this.initialTab
            }
        },
        computed: {
            tabBodyName() {
                return `tab-body-${this.activeTab}`;
            }
        },
        methods: {
            tabNavName(tab) {
                return `tab-nav-${tab}`;
            },
            switchTab(tab) {
                console.log(tab);
                this.activeTab = tab;
            }
        }
    }
</script>

<style scoped>
    .footer-nav {
        position: sticky;
        bottom: 0;
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: stretch;
        margin-top: auto;
        background: #333;
    }
    @supports (-webkit-touch-callout: none) {
        .footer-nav {
            position: fixed;
        }
}
    .footer-nav-item {
        flex: 1;
        text-align: center;
        line-height: 1;
        padding: .25rem 1rem;
        color: white;
        border: none;
        background: transparent;
        text-decoration: none;
        text-underline: none;
        transition: .2s;
        outline: none;
    }
    .footer-nav--active {
        color: #2eb5ff;
    }
    .footer-nav-item:hover {
        background: #ffcc00;
        transition: .2s;
        color: white;
        border: none;
        text-decoration: none;
        text-underline: none;
    }
    .footer-nav-item:active {
        outline: none;
    }
</style>
