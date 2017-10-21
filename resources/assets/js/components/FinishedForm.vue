<template>
  <div class="card">
    <div class="card-body">
      <el-form ref="form" :rules="rules" :model="form" label-position="top">
          <!-- Start -->
          <div class="row">
            <div class="col-md-6">
              <el-form-item label="Waktu berangkat" prop="start_use">
                <el-date-picker v-model="form.start_use"
                  class="w-100"
                  type="datetime"
                  placeholder="Silahkan pilih"></el-date-picker>
              </el-form-item>
            </div>
            <div class="col-md-6">
              <el-form-item label="Posisi KM">
                <el-input v-model="form.start_km_pos" placeholder="Contoh: 1703"></el-input>
              </el-form-item>
            </div>
          </div>

          <!-- Finish -->
          <div class="row">
            <div class="col-md-6">
              <el-form-item label="Waktu kembali" prop="end_use">
                <el-date-picker v-model="form.end_use"
                  class="w-100"
                  type="datetime"
                  placeholder="Silahkan pilih"></el-date-picker>
              </el-form-item>
            </div>
            <div class="col-md-6">
              <el-form-item label="Posisi KM">
                <el-input v-model="form.end_km_pos" placeholder="Contoh: 1714"></el-input>
              </el-form-item>
            </div>
          </div>

          <!-- Difference time -->
          <div class="row">
            <div class="col">
              <el-form-item label="Lamanya dipergunakan">
                <el-input v-model="usageTime" placeholder="Satuan hari"></el-input>
              </el-form-item>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <el-form-item label="Keterangan tambahan jika perlu">
                <el-input type="textarea" v-model="form.additional_description"></el-input>
              </el-form-item>
            </div>
          </div>

          <el-button type="primary" @click="onSubmit('form')">Submit</el-button>
      </el-form>
    </div>
  </div>
</template>

<script>
  import {get, post} from '../helpers/api'

  export default {
    props: ['entity'],
    data () {
      return {
        form: {},
        rules: {
          start_use: { required: true, message: 'Field ini harus dipilih!' },
          end_use: { required: true, message: 'Field ini harus dipilih!' }
        }
      }
    },
    computed: {
      usageTime () {
        var time1 = null
        var time2 = null

        time1 = (this.form.start_use) ? this.form.start_use.getTime() : null
        time2 = (this.form.end_use) ? this.form.end_use.getTime() : null

        var difference = time2 - time1

        var daysDifference = Math.floor(difference/1000/60/60/24)
        difference -= daysDifference*1000*60*60*24
        
        var hoursDifference = Math.floor(difference/1000/60/60)
        difference -= daysDifference*1000*60*60
        
        return (daysDifference >= 1) ? daysDifference + ' hari' : hoursDifference + ' jam'
      }
    },
    methods: {
      original () {
        get(`/api/usage/${this.entity}`)
          .then((response) => {
            this.form = response.data.model
          })
      },
      onSubmit (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            // Set computed usageTime to form
            this.form.usage_time = this.usageTime

            post(`/api/a`, this.form)
              .then((response) => {
                console.log(response)
              })

          } else { return false }
        })
      }
    },
    created () {
      this.original()
    }
  }
</script>
