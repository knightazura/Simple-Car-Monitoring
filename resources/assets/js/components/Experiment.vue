<template>
  <el-form label-width="120px" class="demo-ruleForm">
    <el-select v-model="value" filterable placeholder="Select">
      <el-option
        v-for="item in employees"
        :key="item.nip"
        :label="item.employee_name"
        :value="item.nip">
      </el-option>
    </el-select>
  </el-form>
</template>
<script>
  import { get } from '../helpers/api'

  export default {
    data() {
      return {
        value: '',
        employees: []
      }
    },
    methods: {
      loadAll() {
        get(`/api/employees`)
          .then((response) => {
            this.employees = response.data.model
          })
      }
    },
    mounted() {
      this.loadAll()
    }
  }
</script>
