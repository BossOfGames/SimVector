<template>
    <div class="custom-controls">
        <div class="filter-button" @click="$emit('show-settings')">
            <div style="margin: auto">
                <div style="font-size: 18px;"><span class="mdi mdi-cog"></span></div>
                <div style="font-weight: 700">Map Settings</div>
            </div>
        </div>
        <div style="background: blue; width: 50px; display: flex; justify-content: space-between; flex-direction: column">
            <div class="zoom-button" @click="$emit('zoom-in')">+</div>
            <div class="zoom-button" @click="$emit('zoom-out')">–</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MapControls"
    }
</script>

<style>
    .custom-controls {
        position: fixed;
        z-index: 5;
        right: .5rem;
        top: .5rem;
        width: 140px;
        height: 70px;
        display: flex;
        justify-content: space-between;
        background: #1a1a1a;
        color: white;
    }
    .filter-button {
        width: 100%;
        text-align: center;
        display: flex;
    }
    .filter-button:hover {
        background: #ffcc00;
        cursor: pointer;
        color:black;
    }
    .flex-justify {
        display: flex;
        justify-content: space-between;
    }
    .zoom-button {
        text-align: center;
        font-weight: 700;
        line-height: 35px;
        font-size: 25px;
        cursor: pointer;
        background: #333333;
        color:white;
    }
    .zoom-button:hover {
        background: #00F98E;
        color:black;
    }
</style>
