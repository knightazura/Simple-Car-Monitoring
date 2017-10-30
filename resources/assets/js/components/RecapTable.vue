<template>
  <div>
    <div class="row">
      <el-table
      :data="tableData"
      border
      style="width: 100%">
      <el-table-column
        prop="original_created_date"
        label="Tanggal"
        sortable
        width="180">
      </el-table-column>
      <el-table-column
        prop="employee_name"
        label="Pegawai"
        width="180">
      </el-table-column>
      <el-table-column
        prop="driver"
        label="Sopir">
      </el-table-column>
      <el-table-column
        prop="car"
        label="Kendaraan"
        width="100"
        :filters="[{ text: 'DD232A (Kijang)', value: 'DD232A (Kijang)' }, { text: 'DD11A (Innova)', value: 'DD11A (Innova)' }, { text: 'DD1554AJ (Avanza)', value: 'DD1554AJ (Avanza)' }, { text: 'DD4550KL (Avanza)', value: 'DD4550KL (Avanza)' }, { text: 'DD1609AY (Xenia)', value: 'DD1609AY (Xenia)' }]"
        :filter-method="filterTag"
        filter-placement="bottom-end">
        <template scope="scope">
          <el-tag
            :type="scope.row.tag === 'Home' ? 'primary' : 'success'"
            close-transition>{{scope.row.tag}}</el-tag>
        </template>
      </el-table-column>
    </el-table>
    </div>
    <div class="row">
      <el-pagination
        layout="prev, pager, next"
         @current-change="handleCurrentChange"
        :current-page="pgn.current_page"
        :page-size="pgn.per_page"
        :total="pgn.total">
      </el-pagination>
    </div>
  </div>
</template>

<script>
  import { get } from '../helpers/api'

  export default {
    created () {
      get('/api/a')
        .then((response) => {
          this.pgn = response.data.data
          this.tableData = response.data.data.data
        })
    },
    data () {
      return {
        pgn: '',
        tableData: []
      }
    },
    methods: {
      handleCurrentChange () {
        console.log(this)
      },
      filterTag(value, row) {
        return row.tag === value;
      }
    }
  }
</script>
