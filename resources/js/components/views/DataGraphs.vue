<template>
  <div>
    <div class="row">
      <div class="col-md-6 mt-3">
        <h1 class="h2">Datos estadísticos</h1>
      </div>
      <div class="col-md-6 mt-3">
        <el-select v-model="ano" placeholder="Año">
            <el-option
              v-for="item in options.anos"
              :key="item.ano"
              :label="item.ano"
              :value="item.ano">
            </el-option>
        </el-select>
        <el-select v-model="tipoProducto" :loading="loadingProducts" placeholder="Productos">
            <el-option
              v-for="item in options.tipoProducto"
              :key="item.nombre"
              :label="item.nombre"
              :value="item.nombre"
            ></el-option>
          </el-select>
      </div>
    </div>
    <div class="card">
      <div class="row">
        <div class="col-md-6 mt-3">
          <h5 class="card-title ml-1">Variación productos en el tiempo</h5>
        </div>
        <div class="col-md-6 mt-4">
          <el-select v-model="medidaTiempo" placeholder="Tiempo">
            <el-option
              v-for="item in options.tiempo"
              :key="item.metric"
              :label="item.metric"
              :value="item.metric"
            ></el-option>
          </el-select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button class="btn btn-primary btn-sm ml-2" @click="getDataProductsTime">Cargar datos</button>
          <p class="text-danger ml-2 mt-2" v-if="errorProductos">Debe seleccionar el tipo de producto</p>
          <br><br>
          <ve-line :data="chartDataProductos" v-loading="isLoading" :data-empty="dataEmpty"></ve-line>
        </div>
      </div>
    </div>
    <!-- Separación gráfico -->
    <div class="card mt-2">
      <div class="row">
        <div class="col-md-6 mt-3">
          <h5 class="card-title ml-1">Valores de productos por región</h5>
        </div>
        <div class="col-md-6 mt-4">
          <el-select v-model="region" placeholder="Region">
            <el-option
              v-for="item in options.regiones"
              :key="item.region"
              :label="item.region"
              :value="item.region"
            ></el-option>
          </el-select>
          <el-select v-model="ano" placeholder="Año">
            <el-option
              v-for="item in options.anos"
              :key="item.ano"
              :label="item.ano"
              :value="item.ano"
            ></el-option>
          </el-select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button class="btn btn-primary btn-sm ml-2" @click="getDataProductsRegion">Cargar datos</button>
          <p class="text-danger ml-2 mt-2" v-if="errorRegion">Debe seleccionar la región</p>
          <br>
          <br>
          <ve-line :data="chartDataProductosRegion" :extend="extend" v-loading="loadingProductsxRegion" :data-empty="dataEmpty"></ve-line>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Select, Option, Form, FormItem, Table, TableColumn } from "element-ui";
import { WebUtils } from "../../lib/webUtils";

export default {
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Form.name]: Form,
    [FormItem.name]: FormItem,
    [Option.name]: Option,
    [Select.name]: Select
  },
  data () {
    this.extend = {
      'xAxis.0.axisLabel.rotate': 60
    }
    return {
      rawData: [
        { "01": [] }, { "02": [] }, { "03": [] }, { "04": [] },
        { "05": [] }, { "06": [] }, { "07": [] }, { "08": [] }, 
        { "09": [] }, { "10": [] }, { "11": [] }, { "12": [] },
      ],
      rawDataRegiones: [
        { "Metropolitana": [] }, { "Maule": [] }, { "Bíobío": [] }, 
        { "Arica y Parinacota": [] }, { "Coquimbo": [] }, { "Valparaíso": [] }, 
        { "La Araucanía": [] },{ "Los Lagos": [] },
      ],
      formatedData: {
        columns: [],
        rows: []
      },
      formatedDataRegiones: {
        columns: [],
        rows: []
      },
      options: {
        regiones: [],
        tipoProducto: [],
        tiempo: [{ id: "1", metric: "Mensual" }, { id: "2", metric: "Anual" }],
        anos: [
          { ano: 2008 }, { ano: 2009 }, { ano: 2010 }, { ano: 2011 }, { ano: 2012 },
          { ano: 2013 }, { ano: 2014 }, { ano: 2015 }, { ano: 2016 }, { ano: 2017 },
          { ano: 2018 }, { ano: 2019 }
        ]
      },
      tipoProducto: null,
      region: null,
      ano: null,
      medidaTiempo: "Mensual",
      chartDataProductos: {
        columns: [],
        rows: []
      },
      chartDataProductosRegion: {
        columns: [],
        rows: []
      },
      isLoading: false,
      loadingProductsxRegion: false,
      loadingProducts: false,
      dataEmpty: false,
      errorProductos: false,
      errorRegion: false,
      meses: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
      regiones: ["Metropolitana", "Maule", "Bíobío", "Arica y Parinacota", "Coquimbo", "Valparaíso", "La Araucanía", "Los Lagos"],
      productos: []
    };
  },
  methods: {
    getDataProductsTime() {
      if (this.tipoProducto == null) {
        this.errorProductos = true;
        return false;
      } else {
        this.errorProductos = false;
      }
      let index = 0;
      this.isLoading = true;

     this.$http.get("api/productos-mensuales/" + this.tipoProducto + "/" + this.ano)
        .then(response => {
          response.body.forEach(obj => {
            let mes = obj.fecha_inicio.substring(3, 5)
            let indexMes = this.meses.indexOf(mes)
            let indexProd = this.productos.indexOf(obj.producto)
            this.rawData[indexMes][mes][indexProd].precio.push(obj.precio_promedio)
          })

          this.formatData();
          // console.log(this.rawData)
          this.chartDataProductos = this.formatedData;
          this.isLoading = false;
        }).catch((e) => {
          if (e.status === 404){
            //error To Do
            this.isLoading = false;
          }; 
        });
    },
    getDataProductsRegion() {
      if (this.tipoProducto == null) {
        this.errorRegion = true;
        return false;
      } else {
        this.errorRegion = false;
      }
      let index = 0;
      this.loadingProductsxRegion = true;

      this.$http.get("api/productos-region/" + this.tipoProducto + "/" + this.ano)
        .then(response => {
          response.body.forEach(obj => {
            let region = obj.region;
            let indexRegion = this.regiones.indexOf(region);
            let indexProd = this.productos.indexOf(obj.producto);
            this.rawDataRegiones[indexRegion][region][indexProd].precio.push( obj.precio_promedio);
          });
          console.log(this.rawDataRegiones)
          this.formatDataRegiones();
          this.chartDataProductosRegion = this.formatedDataRegiones;
          this.loadingProductsxRegion = false;
        });
    },
    loadProducts() {
      this.loadingProducts = true
      this.options.tipoProducto = [];
      this.$http.get("api/tipos-producto").then(response => {
        response.body.forEach(element => {
          this.options.tipoProducto.push({ nombre: element.tipo_producto });
        });
        this.loadingProducts = false
      });
    },
    loadRegions() {
      this.options.regiones = [];
      this.$http.get("api/regiones").then(response => {
        response.body.forEach(element => {
          this.options.regiones.push({ region: element.region });
        });
      });
    },
    formatData() {
      this.formatedData = {
        columns: [],
        rows: []
      };
      this.formatedData.columns.push("mes");
      this.meses.forEach(mes => {
        let mesIndex = this.meses.indexOf(mes);
        this.formatedData.rows[mesIndex] = {};
        this.formatedData.rows[mesIndex].mes = mes;
        this.productos.forEach(prod => {
          if (this.formatedData.columns.indexOf(prod) < 0) {
            this.formatedData.columns.push(prod);
          }

          let indexProd = this.productos.indexOf(prod);
          let arreglo = this.rawData[mesIndex][mes][indexProd].precio;
          let arrayLen = arreglo.length;
          let sum = WebUtils.sumArray(arreglo, arrayLen);
          let prom = sum / arrayLen;
          this.formatedData.rows[mesIndex][prod] = prom;
        });
      });
      console.log(this.formatedData)
    },
    formatDataRegiones () {
      this.formatedDataRegiones = {
        columns: [],
        rows: []
      };
      this.formatedDataRegiones.columns.push("region");
      this.regiones.forEach(region =>{
        let regionIndex = this.regiones.indexOf(region)
        this.formatedDataRegiones.rows[regionIndex] = {}
        this.formatedDataRegiones.rows[regionIndex].region = region
        this.productos.forEach(prod => {
          if (this.formatedDataRegiones.columns.indexOf(prod) < 0) {
            this.formatedDataRegiones.columns.push(prod)
          }
          let indexProd = this.productos.indexOf(prod);
          let arreglo = this.rawDataRegiones[regionIndex][region][indexProd].precio;
          let arrayLen = arreglo.length;
          let sum = WebUtils.sumArray(arreglo, arrayLen);
          let prom = sum / arrayLen;
          this.formatedDataRegiones.rows[regionIndex][prod] = prom;
        })  
      })
      console.log(this.formatedDataRegiones)
    },
  },
  mounted() {
    this.loadRegions();
    this.loadProducts();
  },
  watch: {
    medidaTiempo(newVal, OldVal) {
      // console.log(this.medidaTiempo)
    },
    tipoProducto(newVal, OldVal) {
      this.productos = [];
      this.rawData = [ { "01": [] }, { "02": [] }, { "03": [] }, { "04": [] }, { "05": [] },
        { "06": [] }, { "07": [] }, { "08": [] }, { "09": [] }, { "10": [] }, { "11": [] },
        { "12": [] }
      ];
      let index = 0;
      let indexRegion = 0;
      this.$http.get("api/productos/" + this.tipoProducto).then(response => {
        response.body.forEach(element => {
          this.productos.push(element.producto);
          index = 0;
          this.rawData.forEach(objData => {
            objData[this.meses[index]].push({
              nombre: element.producto,
              precio: []
            });
            index++;
          });
          indexRegion = 0;
          this.rawDataRegiones.forEach(objDataRegion => {
            objDataRegion[this.regiones[indexRegion]].push({
              nombre: element.producto,
              precio: []
            });
            indexRegion++;
          });
        });
      });
    }
  }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.15s;
}

.fade-enter,
  .fade-leave-to
    /* .fade-leave-active in <2.1.8 */

 {
  opacity: 0;
}
</style>
