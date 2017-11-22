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
              <el-form-item label="Posisi KM awal">
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
              <el-form-item label="Posisi KM akhir">
                <el-input v-model="form.end_km_pos" placeholder="Contoh: 1714"></el-input>
              </el-form-item>
            </div>
          </div>

          <!-- Difference time -->
          <div class="row">
            <div class="col">
              <el-form-item label="Lamanya dipergunakan">
                <el-input v-model="form.usage_time" placeholder="Satuan hari"></el-input>
              </el-form-item>
            </div>
          </div>

          <!-- Fuel Usage -->
          <el-form-item label="BBM" prop="fuel">
              <el-input-number v-model="form.fuel_usage" :min="0" :step="10"></el-input-number>
          </el-form-item>

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
    /* computed: {
      usageTime () {
        var ttime = (this.form.start_use && this.form.end_use) ? this.timeDifference(this.form.start_use, this.form.end_use) : null

        return (ttime) ? `${ttime.days} hari, ${ttime.hours} jam` : null
      }
    }, */
    methods: {
      /* timeDifference (start_time, end_time) {
        var time1 = start_time.getTime()
        var time2 = end_time.getTime()

        var difference = time2 - time1

        var daysDifference = Math.floor(difference/1000/60/60/24)
        difference -= daysDifference*1000*60*60*24
        
        var hoursDifference = Math.floor(difference/1000/60/60)
        difference -= daysDifference*1000*60*60

        var minutesDifference = Math.floor(difference/1000/60);
        difference -= minutesDifference*1000*60

        return {
          days: daysDifference,
          hours: hoursDifference,
          minutes: minutesDifference
        }
      }, */
      original () {
        get(`/api/usage/${this.entity}`)
          .then((response) => {
            this.form = response.data.model
          })
      },
      printForm () {
        location.href = `/exp/print-3/${this.entity}`
      },
      onSubmit (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            // Set computed usageTime to form
            // this.form.usage_time = this.usageTime

            post(`/api/car-usage/finished`, this.form)
              .then((response) => {
                swal({
                    icon: "success",
                    text: response.data.message
                })
                .then(function () {
                    location.href = response.data.redirect_url
                })
              }).
              catch((error) => {
                swal({
                  icon: "error",
                  text: error
                })
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
