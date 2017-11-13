<template>
  <el-form ref="form" :rules="rules" :model="form" label-width="120px">
    <div class="alert alert-warning" role="alert">
      <b>Note:</b> Data Sopir baru yang bertanggung jawab terhadap mobil ini akan dihapus pada data mobil yang lama.  
    </div>
    <el-form-item label="Mobil" prop="car_plat_number">
      <el-select class="w-100" v-model="form.car_plat_number" filterable placeholder="Pilih" :disabled="selDis">
        <el-option
          v-for="car in cars"
          :key="car.plat_number"
          :label="`${car.car_name} - ${car.plat_number}`"
          :value="car.plat_number"
        ></el-option>
      </el-select>
    </el-form-item>

    <el-form-item label="Nama Sopir" prop="driver_id">
      <el-select class="w-100" v-model="form.driver_id" filterable placeholder="Pilih">
        <el-option
          v-for="driver in drivers"
          :key="driver.id"
          :label="`${driver.company} - ${driver.driver_name}`"
          :value="driver.id"
        ></el-option>
      </el-select>
    </el-form-item>

    <el-form-item>
      <el-button type="primary" @click="onSubmit('form')">{{ buttonDesc }}</el-button>
      <el-button @click="back">Kembali</el-button>
    </el-form-item>
  </el-form>
</template>
<script>
  import { get, post } from '../helpers/api'

  export default {
    props: ['meta', 'entity_id'],
    data () {
      return {
        initURL: `/api/driver-car/create-available`,
        storeURL: `/driver-car`,
        selDis: false,
        drivers: [],
        cars: [],
        buttonDesc: 'Set',
        form: {},
        rules: {
          car_plat_number: [{ required: true, message: 'Silahkan pilih kendaraan terlebih dahulu' }],
          driver_id: [{ required: true, message: 'Silahkan pilih sopir terlebih dahulu' }]
        }
      }
    },
    methods: {
      init() {
        if (this.meta == 'Edit') {
          this.initURL = `/api/driver-car/${this.entity_id}/edit-available`
          this.storeURL = `/driver-car/${this.entity_id}?_method=PUT`
          this.buttonDesc = 'Update'
          this.selDis = true
        }
        get(this.initURL).then((response) => {
          this.drivers = response.data.model.drivers
          this.cars = response.data.model.cars
          this.form = (this.meta == 'Edit') ? response.data.model.form : {}
        })
      },
      onSubmit(formName) {
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
          } else { return false }
        }) 
      },
      back() {
        location.href = `/driver-car/`
      }
    },
    created() {
      this.init()
    }
  }
</script>
