<template>
  <el-form ref="form" :rules="rules" :model="form" label-position="top">
    <div class="form-group">
      <label for="company_name">Nama Perusahaan</label>
      <el-form-item prop="company_name">
        <el-input v-model="form.company_name" placeholder="Contoh: PT. INDUK SULMAPA KEKAR" id="company_name"></el-input>
      </el-form-item>
    </div>

    <div class="form-group">
      <label for="company_director">Nama Direktur Perusahaan</label>
      <el-form-item prop="company_director">
        <el-input v-model="form.company_director" placeholder="Contoh: ASRUL TINAI" id="company_director"></el-input>
      </el-form-item>
    </div>

    <el-button type="success" @click="onSubmit('form')">{{ buttonContext }}</el-button>
    <el-button @click="back">Kembali</el-button>
  </el-form>
</template>

<script>
  import { get, post } from '../helpers/api'

  export default {
    props: ['meta', 'entity_id'],
    created () {
      if (this.meta == 'Edit') {
        this.storeURL = `/driver-company/${this.entity_id}?_method=PUT`,
        this.buttonContext = 'Update'
        get(`/api/driver-company/edit/${this.entity_id}`)
          .then((response) => {
            this.form = response.data.model
          })
          .catch((error) => {
            swal({
              icon: 'error',
              message: error
            })
          })
      }
    },
    data () {
      return {
        storeURL: `/driver-company`,
        buttonContext: 'Submit',
        form: {},
        rules: {
          company_name: [
            { required: true, message: 'Mohon masukkan nama Perusahaan terlebih dahulu!' },
            { min: 5, message: 'Nama perusahaan minimal mempunyai 5 karakter' }
          ],
          company_director: [
            { required: true, message: 'Mohon masukkan nama Direktur Perusahaan terlebih dahulu!' },
            { min: 3, message: 'Nama Direktur Perusahaan minimal mempunyai 3 karakter' }
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
              .catch((error) => {
                swal({
                  icon: "error",
                  text: error
                })
              })
          } else { console.log('Error') }
        })
      },
      back () {
        location.href = '/driver'
      }
    }
  }
</script>
