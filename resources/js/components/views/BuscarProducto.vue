<template>
  <div class="row">
    <h1 class="col-md-12 mt-4 mb-5" >Seleccione su ubicación y el producto</h1>
    <el-form ref="form" label-width="120px">
      <el-form-item label="Activity form">
        <el-select v-model="value" placeholder="Select">
          <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
          </el-option>
        </el-select>
      </el-form-item>
    </el-form>

  </div>
</template>

<script>

  import {Select, Option, Form, FormItem} from 'element-ui'

  export default {
    components: {
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
        value: ''
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
