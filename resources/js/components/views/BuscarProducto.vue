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
      <el-select v-model="value" placeholder="Select">
        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
        </el-option>
      </el-select>
    </div>
    <div class="col-md-1">
      <label class="typo__label">Sector</label>
    </div>
    <div class="col-md-7">
      <el-select v-model="value" placeholder="Select">
        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
        </el-option>
      </el-select>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-1">
      <label class="typo__label">Tipo producto</label>
    </div>
    <div class="col-md-3">
      <el-select v-model="value" placeholder="Select">
        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
        </el-option>
      </el-select>
    </div>
    <div class="col-md-1">
      <label class="typo__label">Producto</label>
    </div>
    <div class="col-md-7">
      <el-select v-model="value" placeholder="Select">
        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
        </el-option>
      </el-select>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <button type="button" class="btn btn-primary">Consultar producto</button>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12"> 
      <el-table :data="tableData" stripe style="width: 100%">
        <el-table-column prop="date" label="Date" width="180">
        </el-table-column>
        <el-table-column prop="name" label="Name" width="180">
        </el-table-column>
        <el-table-column prop="address" label="Address">
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
        options: [{
          value: 'Option1',
          label: 'Option1'
        }, {
          value: 'Option2',
          label: 'Option2'
        }, {
          value: 'Option3',
          label: 'Option3'
        }, {
          value: 'Option4',
          label: 'Option4'
        }, {
          value: 'Option5',
          label: 'Option5'
        }],
        value: '',
        tableData: [{
          date: '2016-05-03',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-02',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-04',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-01',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }]
      }
    },
    methods: {
    },
    created () {
      
    },
    mounted() {
    
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
