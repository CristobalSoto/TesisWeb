<template>
<div>
  <div class="row">
    <div class="col-md-6 mt-3">
      <h1 class="h2">Estadísticas</h1>
    </div>
    <div class="col-md-6 mt-4">
      <el-select v-model="tipoProducto" placeholder="Producto">
        <el-option 
          v-for="item in options.tipoProducto" 
          :key="item.nombre" 
          :label="item.nombre" 
          :value="item.nombre">
        </el-option>
      </el-select>
      <el-select v-model="medidaTiempo" placeholder="Tiempo">
        <el-option 
        v-for="item in options.tiempo" 
        :key="item.metric" 
        :label="item.metric" 
        :value="item.metric">
        </el-option>
      </el-select>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button class="btn btn-primary" @click="getData">get Data</button>
      <ve-line
        :data="chartData"
        v-loading="isLoading"
        :data-empty="dataEmpty"
        :settings="chartSettings">
      </ve-line>
    </div>
  </div>

</div>

</template>

<script>
  import {Select, Option, Form, FormItem, Table, TableColumn} from 'element-ui'

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
    components: {
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      [Form.name]: Form,
      [FormItem.name]: FormItem,
      [Option.name]: Option,
      [Select.name]: Select
    },
    data() {
      this.chartSettings = {
        yAxisType: ['0,0a']
      }
      return {
        options: {
          tipoProducto: [],
          tiempo: [
            {id: '1', metric: 'Semanal'},
            {id: '2', metric: 'Anual'}
          ]
        },
        tipoProducto: '',
        medidaTiempo: 'Semanal',
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
      },
      loadProducts () {
        this.options.tipoProducto = []
        this.$http.get('api/tipos-producto')
        .then(response => {
          // console.log(response.body)
          response.body.forEach(element => {
            this.options.tipoProducto.push({nombre: element.tipo_producto})
          });
        })
      }
    },
    mounted() {
      this.getData()
      this.loadProducts()
      
    },
    watch: {
      'medidaTiempo' (newVal, OldVal) {
        console.log(this.medidaTiempo)
      },
      'tipoProducto' (newVal, OldVal) {
        console.log(this.tipoProducto)
      }
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
