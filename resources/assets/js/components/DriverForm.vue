<template>
  <el-form ref="form" :rules="rules" :model="form" label-position="top">
      <!-- Name -->
      <div class="form-group">
        <label for="driver_name">Nama Sopir</label>
        <el-form-item prop="driver_name">
          <el-input v-model="form.driver_name" placeholder="Contoh: Abdullah" id="driver_name"></el-input>
        </el-form-item>
      </div>

      <!-- Company -->
      <div class="form-group">
        <label for="company">Nama Perusahaan</label>
        <el-form-item prop="company">
          <el-select class="w-100"
            v-model="form.company"
            :multiple-limit="1"
            clearable
            filterable
            allow-create
            placeholder="Pilih perusahaan atau buat baru">
            <el-option
              v-for="comp in companies"
              :key="comp.value"
              :label="comp.label"
              :value="comp.value">
            </el-option>
          </el-select>
        </el-form-item>
      </div>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phonenumber">Nomor HP</label>
        <el-form-item prop="phonenumber">
          <el-input v-model="form.phonenumber" placeholder="Contoh: 08123456789" id="phonenumber"></el-input>
        </el-form-item>
      </div>

      <!-- Status -->
      <div class="form-group">
        <label for="company">Status Sopir</label>
        <el-form-item>
          <el-radio-group v-model="form.status">
            <el-radio :label="0">Stand by</el-radio>
            <el-radio :label="2">Sakit/Izin</el-radio>
            <el-radio :label="3">Tidak ada informasi</el-radio>
          </el-radio-group>
        </el-form-item>
      </div>

    <el-button type="success" @click="onSubmit('form')">{{ buttonContext }}</el-button>
    <el-button v-if="clearBtnVisibility" :plain="true" type="warning" @click="resetForm('form')">Clear</el-button>
    <el-button @click="back">Kembali</el-button>
</el-form>
</template>
<script>
  import { get, post } from '../helpers/api'

  export default {
    props: ['meta', 'entity_id'],
    created () {
      this.init()

      if (this.meta == 'Edit') {
        this.storeURL = `/driver/${this.entity_id}?_method=PUT`
        this.buttonContext = 'Update'
        get(`/api/driver/${this.entity_id}`)
          .then((response) => {
            this.form = response.data.model
          })
      }
    },
    computed: {
      clearBtnVisibility () {
        return (this.meta == 'Edit') ? false : true
      }
    },
    data () {
      return {
        storeURL: `/driver`,
        buttonContext: 'Submit',
        form: {
          status: 0
        },
        companies: [],
        rules: {
          driver_name: [
            { required: true, message: 'Mohon masukkan Nama Pegawai terlebih dahulu' },
            { min: 3, message: 'Nama Pegawai minimal mempunyai 3 karakter!' }
          ],
          company: [
            { required: true, message: 'Mohon masukkan field Nama Perusahaan terlebih dahulu' },
            { min: 3, message: 'Field Nama Perusahaan minimal mempunyai 3 karakter!' }
          ]
        }
      }
    },
    methods: {
      init () {
        get(`/api/driver-company/existing`)
          .then((response) => {
            this.companies = response.data.model
          })
          .catch((erorr) => {
            swak({
              icon: "error",
              text: error
            })
          })
      },
      onSubmit (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            post(this.storeURL, this.form)
              .then((response) => {
                swal({
                  icon: "success",
                  text: response.data.message
                })
                .then(() => location.href = response.data.redirect_url)
              })
              .catch((error) => {
                swal({
                  icon: "error",
                  text: error
                })
              })
          } else { console.log('Error') }
        })
      },
      resetForm (formName) {
        this.$refs[formName].resetFields()
      },
      back () {
        location.href = ('/driver')
      }
    }
  }
</script>
