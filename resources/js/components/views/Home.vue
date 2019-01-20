<template>
<div>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Estadísticas</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>
      <div>
    <button class="btn btn-primary" @click="getData">get Data</button>
    <ve-line
      :data="chartData"
      v-loading="isLoading"
      :data-empty="dataEmpty"
      :settings="chartSettings">
    </ve-line>
 </div>
</div>

</template>

<script>

  const DATA_FROM_BACKEND = {
    columns: ['date', 'PV'],
    rows: [
      { 'date': '2018-05-22', 'PV': 32371},
      { 'date': '2018-05-23', 'PV': 12328},
      { 'date': '2018-05-24', 'PV': 92381}
    ]
  }
  const EMPTY_DATA = {
    columns: ['date', 'PV'],
    rows: [
      { 'date': '2018-05-22', 'PV': 90000},
      { 'date': '2018-05-23', 'PV': 50000},
      { 'date': '2018-05-24', 'PV': 12381}
    ]
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
        isLoading: false,
        dataEmpty: false
      }
    },
    methods: {
      getData () {
        this.isLoading = true
        // ajax get data ....
        setTimeout(() => {
          this.chartData = this.chartData.rows.length
            ? EMPTY_DATA
            : DATA_FROM_BACKEND
          this.dataEmpty = !this.chartData.rows.length
          this.isLoading = false
        }, 1000)
      }
    },
    created () {
      
    },
    mounted() {
      this.getData()
      /*this.chartData.rows= [
              { 'date': '1/1', 'sales': 12342 },
              { 'date': '1/1', 'sales': 12253 },
              { 'date': '1/3', 'sales': 21253 },
              { 'date': '1/4', 'sales': 41253 },
              { 'date': '1/5', 'sales': 31253 },
              { 'date': '1/6', 'sales': 71253 }
            ]
      this.$http.get('api/precios/Aceite/Huachalomo')
        .then(response => {
          // console.log(response.body)
          response.body.forEach(element => {
            // console.log(element)
            
          });
        })*/
    }
  }
</script>

<style>
  
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
