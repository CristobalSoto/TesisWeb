<template>
  <div v-loading="loading">
    <button @click="getData">get Data</button>
    <ve-line
      :data="chartData"
      :data-empty="dataEmpty"
      :settings="chartSettings">
    </ve-line>
  </div>
</template>

<script>
  const DATA_FROM_BACKEND = {
    columns: ['date', 'PV', 'Order'],
    rows: [
      { 'date': '2018-05-22', 'PV': 32371, 'Order': 19810 },
      { 'date': '2018-05-23', 'PV': 12328, 'Order': 4398 },
      { 'date': '2018-05-24', 'PV': 92381, 'Order': 52910 }
    ]
  }
  const EMPTY_DATA = {
    columns: [],
    rows: []
  }

  export default {
    data() {
      this.chartSettings = {
        yAxisType: ['0,0a']
      }
      return {
        chartData: {
          columns: [],
          rows: []
        },
        loading: true,
        dataEmpty: false
      }
    },
    methods: {
      getData () {
        // this.loading = true
        // ajax get data ....
        setTimeout(() => {
          this.chartData = this.chartData.rows.length
            ? EMPTY_DATA
            : DATA_FROM_BACKEND
          this.dataEmpty = !this.chartData.rows.length
          // this.loading = false
        }, 1000)
      }
    },
    created () {
      this.getData()
    }
  }
</script>

<style>
  @import url("//unpkg.com/element-ui@2.4.11/lib/theme-chalk/index.css");
  
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity .15s
  }

  .fade-enter,
  .fade-leave-to
    /* .fade-leave-active in <2.1.8 */

  {
    opacity: 0
  }
</style>


