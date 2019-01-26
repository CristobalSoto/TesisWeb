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
      <button class="btn btn-primary" @click="getData">Cargar datos</button>
      <ve-line
        :data="chartData"
        v-loading="isLoading"
        :data-empty="dataEmpty"
        >
      </ve-line>
    </div>
  </div>

</div>

</template>

<script>
  import {Select, Option, Form, FormItem, Table, TableColumn} from 'element-ui'
  import {WebUtils} from "../../lib/webUtils"


  const DATA_FROM_BACKEND = {
    columns: ['date', 'PV', '212', 'hla'],
    rows: [
      { 'date': '2018-05-22', 'PV': 32371},
      { 'date': '2018-05-23', 'PV': 12328},
      { 'date': '2018-05-24', 'PV': 92381}
    ]
  }
  const EMPTY_DATA = {
    columns: ['date', 'PV', '212', 'hla'],
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
        rawData: [
          {'01':[]},{'02':[]},{'03':[]},{'04':[]},
          {'05':[]},{'06':[]},{'07':[]},{'08':[]},
          {'09':[]},{'10':[]},{'11':[]},{'12':[]},
        ],
        formatedData : {
          columns: [],
          rows: []
        },
        options: {
          tipoProducto: [],
          tiempo: [
            {id: '1', metric: 'Mensual'},
            {id: '2', metric: 'Anual'}
          ]
        },
        tipoProducto: '',
        medidaTiempo: 'Mensual',
        chartData: {
          columns: [],
          rows: []
        },
        isLoading: false,
        dataEmpty: false,
        meses: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
        productos : []
      }
    },
    methods: {
      getData () {
        let index = 0
        this.isLoading = true
        
        this.$http.get('api/productos-mensuales/' + this.tipoProducto + '/2009')
        .then(response => {
          response.body.forEach(obj => {
            
            let mes = obj.fecha_inicio.substring(3, 5)
            let indexMes = this.meses.indexOf(mes)
            let indexProd = this.productos.indexOf(obj.producto)
            this.rawData[indexMes][mes][indexProd].precio.push(obj.precio_promedio)
          });
          
          this.formatData()
          //console.log(this.rawData)
          this.chartData = this.formatedData
          this.isLoading = false
        })
        /*
        setTimeout(() => {
          this.chartData = this.chartData.rows.length
            ? EMPTY_DATA
            : DATA_FROM_BACKEND
          this.dataEmpty = !this.chartData.rows.length
          this.isLoading = false
        }, 1000) */
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
      },
      formatData () {
        this.formatedData = {
          columns: [],
          rows: []
        }
        this.formatedData.columns.push('mes')
        this.meses.forEach(mes => {
          
          let mesIndex = this.meses.indexOf(mes)
          this.formatedData.rows[mesIndex] = {}
          this.formatedData.rows[mesIndex].mes = mes 
          this.productos.forEach(prod =>{
            if (this.formatedData.columns.indexOf(prod) < 0) {
              this.formatedData.columns.push(prod)
            }
            
            let indexProd = this.productos.indexOf(prod)
            let arreglo = this.rawData[mesIndex][mes][indexProd].precio
            let arrayLen = arreglo.length
            let sum = WebUtils.sumArray(arreglo, arrayLen)
            let prom = sum/arrayLen
            // console.log(mes + " "+prod+" " +sum)
            this.formatedData.rows[mesIndex][prod] = prom
          })
        })
        console.log(this.formatedData)
      }
    },
    mounted() {
      // this.getData()
      this.loadProducts()
      
    },
    watch: {
      'medidaTiempo' (newVal, OldVal) {
        console.log(this.medidaTiempo)
      },
      'tipoProducto' (newVal, OldVal) {
        this.productos = []
        this.rawData = [
          {'01':[]},{'02':[]},{'03':[]},{'04':[]},
          {'05':[]},{'06':[]},{'07':[]},{'08':[]},
          {'09':[]},{'10':[]},{'11':[]},{'12':[]},
        ]
        let index = 0
        this.$http.get('api/productos/'+ this.tipoProducto)
        .then(response => {
          // console.log(response.body)
          response.body.forEach(element => {
            this.productos.push(element.producto)
            index = 0
            this.rawData.forEach(objData =>{
              objData[this.meses[index]].push({nombre: element.producto, precio: [] })
              index++
            })
            //this.productos.push({ nombre:element.producto, precio: []})
          });
          // console.log(this.data)
          // console.log(this.productos)
        })
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
