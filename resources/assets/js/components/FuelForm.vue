<template>
  <div class="card">
    <div class="card-body">
      <el-form ref="form" :model="form" :rules="rules" label-position="top">
        <div class="row">
          <div class="col">
            <el-form-item label="Bulan" prop="month">
              <el-select class="w-100" v-model="form.month" :disabled="form_mode" placeholder="Pilih">
                <el-option
                  v-for="month in months"
                  :key="month.value"
                  :label="month.label"
                  :value="month.value"></el-option>
              </el-select>
            </el-form-item>
          </div>
          <div class="col">
            <el-form-item label="Tahun" prop="year">
              <el-input-number class="w-100" v-model="form.year" :min="current_year" :disabled="form_mode"></el-input-number>
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <el-form-item label="Jumlah bahan bakar" prop="fuel_ratio">
              <el-input-number class="w-100" v-model="form.fuel_ratio" :min="0" :step="100"></el-input-number>
            </el-form-item>
          </div>
        </div>
        <!-- Simulator Calc -->
        <hr>
        <div class="row" v-if="form_mode">
          <div class="col">
            <el-form-item label="Total pemakaian bulan ini">
              <el-input class="w-100" v-model="current_fuel_usage" :readonly="true"></el-input>
            </el-form-item>
          </div>
          <div class="col">
            <el-form-item label="Jumlah tambahan">
              <el-input-number class="w-100" v-model="additional_fuel" :min="0" :step="10"></el-input-number>
            </el-form-item>
          </div>
          <div class="col">
            <el-form-item label="Hasil sisa BBM">
              <el-input class="w-100" v-model="fuel_result" :readonly="true"></el-input>
            </el-form-item>
          </div>
        </div>
        <el-button type="success" @click="onSubmit('form')">{{ buttonContext }}</el-button>
        <el-button @click="back">Kembali</el-button>
      </el-form>
    </div>
  </div>
</template>

<script>
  import { get, post } from '../helpers/api'

  export default {
    props: ['meta', 'entity_id'],
    created () {
      if (this.meta == 'Edit') {
        this.storeURL = `/fuel/${this.entity_id}?_method=PUT`

        // Get Entity
        get(`/api/fuel/edit/${this.entity_id}`)
          .then((response) => {
            this.form = response.data.model
          })
          .catch((error) => {
            swal({
              icon: "error",
              text: error
            })
          })

        // Get current usage
        get(`/api/fuel/current-usage`)
          .then((response) => {
            this.current_fuel_usage = response.data.model
          })
          .catch((error) => console.log(error))
      }
      else if (this.meta == 'Index') {
        this.form.month = new Date().getMonth() + 1
      }
    },
    computed: {
      form_mode () {
        return (this.meta == 'Edit') ? true : false
      },
      fuel_result () {
        return (this.form.fuel_ratio - this.current_fuel_usage) + this.additional_fuel
      }
    },
    data () {
      return {
        storeURL: `/fuel`,
        current_year: new Date().getFullYear(),
        buttonContext: 'Save',
        form: {
          month: 1
        },
        current_fuel_usage: 0,
        additional_fuel: 0,
        rules: {
          month: [{ required: true, message: 'Field bulan tidak boleh kosong' }],
          year: [{ required: true, message: 'Field tahun tidak boleh kosong' }],
          fuel_ratio: [{ required: true, message: 'Field jumlah BBM tidak boleh kosong' }]
        },
        months: [
          {value: 1, label: 'Januari'},
          {value: 2, label: 'Februari'}, 
          {value: 3, label: 'Maret'}, 
          {value: 4, label: 'April'}, 
          {value: 5, label: 'Mei'}, 
          {value: 6, label: 'Juni'}, 
          {value: 7, label: 'Juli'}, 
          {value: 8, label: 'Agustus'}, 
          {value: 9, label: 'September'}, 
          {value: 10, label: 'Oktober'}, 
          {value: 11, label: 'November'}, 
          {value: 12, label: 'Desember'}
        ]
      }
    },
    methods: {
      onSubmit (form) {
        this.$refs[form].validate((valid) => {
          if (valid) {
            this.form.fuel_ratio = this.form.fuel_ratio + this.additional_fuel
            post(this.storeURL, this.form)
              .then((response) => {
                swal({
                  icon: response.data.icon,
                  text: response.data.message
                })
                .then(() => {
                  location.href = response.data.redirect_url
                })
              })
          }
        })
      },
      back () {
        location.href = "/home"
      }
    }
  }
</script>
