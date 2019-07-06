<template>
    <div>
        <div class="side-header">Airport Information</div>
        <div class="panel-item" v-for="chart in apd" @click="openChart(chart.pdf_name)">
            {{chart.chart_name}}
        </div>
        <div class="panel-item" v-for="chart in hot" @click="openChart(chart.pdf_name)">
            {{chart.chart_name}}
        </div>
        <div class="panel-item" v-for="chart in min" @click="openChart(chart.pdf_name)">
            {{chart.chart_name}}
        </div>
        <div class="side-header">Instrument Approach Procedures</div>
        <div class="panel-item" v-for="chart in iaps" @click="openChart(chart.pdf_name)">
            {{chart.chart_name}}
        </div>
        <div class="side-header">Departure Procedures (SIDs)</div>
        <div class="panel-item" v-for="chart in sids" @click="openChart(chart.pdf_name)">
            {{chart.chart_name}}
        </div>
        <div class="side-header">Arrival Procedures (STARs)</div>
        <div class="panel-item" v-for="chart in stars" @click="openChart(chart.pdf_name)">
            {{chart.chart_name}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "AirportChartsTab",
        computed: {
            charts() {
                return this.$store.state.airport.charts;
            },
            cycle() {
                return this.$store.state.airport.cycle;
            },
            sids() {
                return this.$store.state.airport.charts.charts.filter(c => c.chart_code === "DP")
            },
            stars() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "STAR")
            },
            iaps() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "IAP")
            },
            apd() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "APD")
            },
            hot() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "HOT")
            },
            min() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "MIN")
            },
        },
        methods: {
            openChart(chart) {
                window.open('https://aeronav.faa.gov/d-tpp/'+ this.cycle +'/'+chart, '_blank')
            }
        }
    }
</script>

<style scoped>
    .panel-item:hover {
        background: #ffcc00;
        transition: .2s;
    }
    .panel-item {
        padding: .5rem 1rem;
        transition: .2s;
        cursor: pointer;
    }
    .side-header {
        position: sticky;
    }
</style>
