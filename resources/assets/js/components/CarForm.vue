<template>
  <el-form ref="form" :rules="rules" :model="form" label-position="top">
      <!-- Plat Number -->
      <div class="form-group">
        <label for="plat_number">Nomor Plat</label>
        <el-form-item prop="plat_number">
          <el-input v-model="form.plat_number" placeholder="Contoh: DD11A" id="plat_number"></el-input>
        </el-form-item>
      </div>

      <!-- Name -->
      <div class="form-group">
        <label for="car_name">Jenis Kendaraan</label>
        <el-form-item prop="car_name">
          <el-input v-model="form.car_name" placeholder="Contoh: Toyota Innova" id="car_name"></el-input>
        </el-form-item>
      </div>

      <!-- Company -->
      <div class="form-group">
        <label for="company">Status Mobil</label>
        <el-form-item>
          <el-radio-group v-model="form.car_status">
            <el-radio :label="0">Tersedia</el-radio>
            <el-radio :label="2">Diperbaiki</el-radio>
            <el-radio :label="3">Rusak</el-radio>
          </el-radio-group>
        </el-form-item>
      </div>

    <el-button type="success" @click="onSubmit('form')">{{ buttonContext }}</el-button>
    <el-button v-if="!clearBtnVisibility" :plain="true" type="warning" @click="resetForm('form')">Clear</el-button>
    <el-button @click="back">Kembali</el-button>
</el-form>
</template>
<script>
  import { get, post } from '../helpers/api'

  export default {
    props: ['meta', 'entity_id'],
    created () {
      if (this.meta == 'Edit') {
        this.storeURL = `/car/${this.entity_id}?_method=PUT`
        this.buttonContext = 'Update'
        get(`/api/car/${this.entity_id}`)
          .then((response) => {
            this.form = response.data.model
          })
      }
    },
    computed: {
      clearBtnVisibility () {
        return (this.meta == 'Edit') ? true : false
      }
    },
    data () {
      return {
        cuba: true,
        storeURL: `/car`,
        buttonContext: 'Submit',
        form: {},
        rules: {
          plat_number: [
            { required: true, message: 'Mohon masukkan field Nomor Plat terlebih dahulu' },
            { min: 3, message: 'Field Nama Plat minimal mempunyai 3 karakter!' }
          ],
          car_name: [
            { required: true, message: 'Mohon masukkan field Jenis kendaraan terlebih dahulu' },
            { min: 3, message: 'Field jenis kendaraan minimal mempunyai 3 karakter!' }
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
        location.href = ('/car')
      }
    }
  }
</script>
