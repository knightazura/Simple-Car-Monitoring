<template>
  <el-form ref="form" :rules="rules" :model="form" label-position="top">
      <!-- Name -->
      <div class="form-group">
        <label for="driver_name">Nama Sopir</label>
        <el-form-item prop="driver_name">
          <el-input v-model="form.driver_name" placeholder="Contoh: Saiko Mizuki" id="driver_name"></el-input>
        </el-form-item>
      </div>

      <!-- Company -->
      <div class="form-group">
        <label for="company">Nama Perusahaan</label>
        <el-form-item prop="company">
          <el-input v-model="form.company" placeholder="Contoh: PT. IPS" id="company"></el-input>
        </el-form-item>
      </div>

    <el-button type="success" @click="onSubmit('form')">{{ buttonContext }}</el-button>
    <el-button :plain="true" type="warning" @click="resetForm('form')">Clear</el-button>
    <el-button @click="back">Kembali</el-button>
</el-form>
</template>
<script>
  import { get, post } from '../helpers/api'

  export default {
    props: ['meta', 'entity_id'],
    created () {
      if (this.meta == 'Edit') {
        this.storeURL = `/driver/${this.entity_id}?_method=PUT`
        this.buttonContext = 'Update'
        get(`/api/driver/${this.entity_id}`)
          .then((response) => {
            this.form = response.data.model
          })
      }
    },
    data () {
      return {
        storeURL: `/driver`,
        buttonContext: 'Submit',
        form: {},
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
              .catch((error) => console.log(error))
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
