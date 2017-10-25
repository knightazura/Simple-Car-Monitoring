<template>
  <el-form ref="form" :rules="rules" :model="form" label-position="top">
      <!-- NIP -->
      <div class="form-group">
        <label for="nip">Nomor Induk Pegawai</label>
        <el-form-item prop="nip">
          <el-input v-model="form.nip" placeholder="Contoh: 1122334456" id="nip"></el-input>
        </el-form-item>
      </div>

      <!-- Name -->
      <div class="form-group">
        <label for="employee_name">Nama Pegawai</label>
        <el-form-item prop="employee_name">
          <el-input v-model="form.employee_name" placeholder="Contoh: Saiko Mizuki" id="employee_name"></el-input>
        </el-form-item>
      </div>

      <!-- Posisi -->
      <div class="form-group">
        <label for="employee_position">Posisi</label>
        <el-form-item prop="employee_position">
          <el-input v-model="form.employee_position" placeholder="Contoh: Ketua Divisi" id="employee_position"></el-input>
        </el-form-item>
      </div>

      <!-- Divisi -->
      <div class="form-group">
        <label for="division">Divisi</label>
        <el-form-item prop="division">
          <el-input v-model="form.division" placeholder="Contoh: General Affairs" id="division"></el-input>
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
      if (this.meta == 'Edit') {
        this.storeURL = `/employee/${this.entity_id}?_method=PUT`
        this.buttonContext = 'Update'
        get(`/api/employee/${this.entity_id}`)
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
        storeURL: `/employee`,
        buttonContext: 'Submit',
        form: {},
        rules: {
          nip: [
            { required: true, message: 'Mohon masukkan NIK terlebih dahulu' },
            { min: 6, message: 'NIP minimal mempunyai 6 karakter!' }
          ],
          employee_name: [
            { required: true, message: 'Mohon masukkan Nama Pegawai terlebih dahulu' },
            { min: 3, message: 'Nama Pegawai minimal mempunyai 3 karakter!' }
          ],
          employee_position: [
            { required: true, message: 'Mohon masukkan Posisi pegawai terlebih dahulu' },
            { min: 3, message: 'Posisi Pegawai minimal mempunyai 3 karakter!' }
          ],
          division: [
            { required: true, message: 'Mohon masukkan field Divisi terlebih dahulu' },
            { min: 3, message: 'Field Divisi minimal mempunyai 3 karakter!' }
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
        location.href = ('/employee')
      }
    }
  }
</script>
