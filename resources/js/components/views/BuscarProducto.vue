<template>
<div>
  <div class="row">
    <h1 class="col-md-12 mt-4 mb-5" >Seleccione su ubicación y el producto</h1>
  </div>
  <div class="row">
    <div class="col-md-1">
      <label class="typo__label">Region</label>
    </div>
    <div class="col-md-3">
      <el-select v-model="region" placeholder="Select">
        <el-option v-for="item in options.regiones" :key="item.region" :label="item.region" :value="item.region">
        </el-option>
      </el-select>
    </div>
    <div class="col-md-1">
      <label class="typo__label">Sector</label>
    </div>
    <div class="col-md-7">
      <el-select v-model="sector" placeholder="Select">
        <el-option v-for="item in options.sectores" :key="item.sector" :label="item.sector" :value="item.sector">
        </el-option>
      </el-select>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-1">
      <label class="typo__label">Tipo producto</label>
    </div>
    <div class="col-md-3">
      <el-select v-model="tipoProducto" placeholder="Select">
        <el-option v-for="item in options.tiposProducto" :key="item.tipoProducto" :label="item.tipoProducto" :value="item.tipoProducto">
        </el-option>
      </el-select>
    </div>
    <div class="col-md-1">
      <label class="typo__label">Producto</label>
    </div>
    <div class="col-md-7">
      <el-select v-model="producto" :disabled="false" placeholder="Select">
        <el-option v-for="item in options.productos" :key="item.producto" :label="item.producto" :value="item.producto">
        </el-option>
      </el-select>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <button type="button" @click="getProduct" class="btn btn-primary">Consultar producto</button>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12"> 
      <el-table :data="tableProductData" stripe style="width: 100%">
        <el-table-column prop="producto" label="Producto" width="180">
        </el-table-column>
        <el-table-column prop="tipo_punto_monitoreo" label="Punto de monitoreo" width="180">
        </el-table-column>
        <el-table-column prop="precio" label="Precio">       
          <template slot-scope="scope">
            <span>{{ scope.row.precio }}</span>
            <span v-if="scope.row.barato" class="badge badge-warning">Mas barato</span>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div> 
</div>
</template>

<script>

  import {Select, Option, Form, FormItem, Table, TableColumn} from 'element-ui'

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
      return {
        region: '',
        sector: '',
        tipoProducto: '',
        producto: '',
        options: {
          regiones: [],
          sectores: [],
          tiposProducto: [],
          productos: []
        },
        value: '',
        tableProductData: [],
        puntosMonitoreo: []
      }
    },
    methods: {
      loadRegions () {
        this.options.regiones = []
        this.$http.get('api/regiones')
        .then(response => {
          response.body.forEach(element => {
            this.options.regiones.push({region: element.region})
          });
        })
      },
      loadSectors () {
        this.sector = ''
        this.options.sectores = []
        this.$http.get('api/sectores/' + this.region)
        .then(response => {
          response.body.forEach(element => {
            this.options.sectores.push({sector: element.sector})
          });
        })
      },
      loadTypeProduct () {
        this.options.tipoProducto = []
        this.$http.get('api/tipos-producto')
        .then(response => {
          response.body.forEach(element => {
            this.options.tiposProducto.push({tipoProducto: element.tipo_producto})
          });
        })
      },
      loadProduct () {
        this.producto = ''
        this.options.productos = []
        this.$http.get('api/productos/' + this.tipoProducto)
        .then(response => {
          response.body.forEach(element => {
            this.options.productos.push({producto: element.producto})
          });
        })
      },
      loadPuntosMonitoreo () {
        this.puntosMonitoreo = []

        this.$http.get('api/puntos-monitoreo/' + this.tipoProducto + '/' + this.producto)
        .then(response => {
          response.body.forEach(element => {
            this.puntosMonitoreo.push(element.tipo_punto_monitoreo)
          });
        })

      },
      getProduct () {
        this.tableProductData = []
        let cantidad = this.puntosMonitoreo.length
        console.log('api/precios-search/' + this.tipoProducto + "/" + this.producto + "/" + this.sector + "/" + cantidad)
        this.$http.get('api/precios-search/' + this.tipoProducto + "/" + this.producto + "/" + this.sector + "/" + cantidad)
        .then(response => {
          let cheaper = 1000000
          response.body.forEach(objCheap => {
            if (cheaper >= objCheap.precio_promedio) {
              cheaper = objCheap.precio_promedio
            }
          }) 
          console.log(cheaper)
          response.body.forEach(obj => {
            let masBarato = cheaper === obj.precio_promedio ? true: false
            this.tableProductData.push({
              producto: obj.producto, 
              tipo_punto_monitoreo: obj.tipo_punto_monitoreo, 
              precio: obj.precio_promedio,
              barato: masBarato
              })
          });
        })
      }
    },
    created () {
      this.loadRegions()
      this.loadTypeProduct()
    },
    mounted() {
    
    },
    watch: {
      'tipoProducto' (newVal, OldVal) {
        this.loadProduct()
      },
      'producto' (newVal, OldVal) {
        this.loadPuntosMonitoreo()
      },
      'region' (newVal, OldVal) {
        this.loadSectors()
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
