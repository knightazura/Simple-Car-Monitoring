<template>
    <div class="card-body">
        <div class="px-5">
            <el-form :model="formRule" :rules="rules" ref="formRule" label-position="right" label-width="200px">
                <!-- NIP (Employee) -->
                <el-form-item label="NIP / Nama Pegawai" prop="nip">
                    <el-select class="w-75" v-model="formRule.nip" filterable placeholder="Pilih">
                        <el-option
                            v-for="emp in idle_employees"
                            :key="emp.nip"
                            :label="emp.employee_name"
                            :value="emp.nip">
                        </el-option>
                    </el-select>
                </el-form-item>

                <!-- Car Type (car_plat_number) v-model="formRule.car_plat_number" -->
                <el-form-item label="Jenis Kendaraan" prop="car_plat_number">
                    <el-select class="w-50" v-model="formRule.car_plat_number" filterable placeholder="Pilih" @change="carSelect">
                        <el-option-group
                            v-for="group in available_cars"
                            :key="group.label"
                            :label="group.label">
                            <el-option
                                v-for="item in group.options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                            </el-option>
                        </el-option-group>
                    </el-select>
                </el-form-item>

                <!-- Driver -->
                <el-form-item label="Driver" prop="driver_id">
                    <el-input v-if="!second_did"
                        type="text" class="w-75" v-model="dnm" readonly placeholder="Pilih kendaraan terlebih dahulu"></el-input>
                    <!-- Second Main Driver choice, when the car doesn't have Driver -->
                    <el-select v-else @change="secondDriverChoice"
                        class="w-75" v-model="dnm" filterable clearable placeholder="Pilih">
                        <el-option
                            v-for="bd in bup_drivers"
                            :key="bd.id"
                            :label="bd.driver_name"
                            :value="bd.id"
                            :disabled="bd.disabled">
                        </el-option>
                    </el-select>
                    <el-tooltip placement="top">
                        <div slot="content">Jika sopir diganti, mohon tuliskan alasannya pada kolom "Keterangan tambahan" dibawah</div>
                        <i class="el-icon-warning"></i>
                    </el-tooltip>

                    <el-input type="hidden" class="w-10" v-model="formRule.driver_id"></el-input>
                    <el-alert
                        class="w-100 mt-2"
                        :title="dsm"
                        type="warning"
                        style="line-height: 0"
                        :closable="false"
                        v-if="cda"
                        show-icon>
                    </el-alert>
                </el-form-item>

                <!-- Backup Driver -->
                <el-form-item v-if="!second_did" label="Driver pengganti" prop="backup_driver_id">
                    <el-select class="w-75" v-model="formRule.backup_driver_id" filterable clearable placeholder="Pilih">
                        <el-option
                            v-for="bd in bup_drivers"
                            :key="bd.id"
                            :label="bd.driver_name"
                            :value="bd.id"
                            :disabled="bd.disabled">
                        </el-option>
                    </el-select>
                </el-form-item>

                <!-- Total Passengers -->
                <el-form-item label="Jumlah penumpang">
                    <el-input-number v-model="formRule.total_passengers" :min="1"></el-input-number>
                </el-form-item>

                <!-- Destination -->
                <el-form-item label="Tempat tujuan" prop="destination">
                    <el-input class="w-75" v-model="formRule.destination"></el-input>
                    <el-tooltip placement="top">
                        <div slot="content">Jika tempat tujuan lebih dari satu, pisahkan dengan tanda koma<br/>Contoh: Palopo, Mamuju, Palu</div>
                        <i class="el-icon-warning"></i>
                    </el-tooltip>
                </el-form-item>

                <!-- Necessity -->
                <el-form-item label="Keperluan" prop="necessity">
                    <el-select class="w-75" v-model="formRule.necessity" placeholder="Pilih">
                        <el-option :label="'DINAS DALAM KOTA'" :value="'DINAS DALAM KOTA'"></el-option>
                        <el-option :label="'DINAS LUAR KOTA'" :value="'DINAS LUAR KOTA'"></el-option>
                        <el-option :label="'PRIBADI DALAM KOTA'" :value="'PRIBADI DALAM KOTA'"></el-option>
                        <el-option :label="'PRIBADI LUAR KOTA'" :value="'PRIBADI LUAR KOTA'"></el-option>
                    </el-select>
                </el-form-item>

                <!-- Fuel Usage Status -->
                <el-form-item label="Status BBM" prop="fuel_status">
                    <el-radio v-model="formRule.fuel_status" label="Kurang">Kurang</el-radio>
                    <el-radio v-model="formRule.fuel_status" label="Cukup">Cukup</el-radio>
                </el-form-item>

                <!-- Fuel Usage -->
                <el-form-item label="BBM" prop="fuel">
                    <el-input-number v-model="formRule.fuel_usage" :min="0" :step="10"></el-input-number>
                </el-form-item>

                <!-- Desire time -->
                <el-form-item label="Waktu yang di-inginkan">
                    <el-date-picker
                        class="w-50"
                        v-model="formRule.desire_time"
                        type="datetime"
                        placeholder="Silahkan Pilih">
                    </el-date-picker>
                </el-form-item>

                <!-- Estimated time -->
                <el-form-item label="Estimasi waktu penggunaan">
                    <div class="row">
                        <div class="col-sm-5"><el-input-number v-model="et_hours" :min="0" :max="23"></el-input-number>&nbsp;&nbsp;jam</div>
                        <div class="col-sm-5"><el-input-number v-model="et_days" :min="0"></el-input-number>&nbsp;&nbsp;hari</div>
                    </div>
                </el-form-item>

                <!-- Additional Description -->
                <el-form-item label="Keterangan tambahan">
                    <el-input class="w-75" type="textarea" v-model="formRule.additional_description"></el-input>
                </el-form-item>

                <!-- Buttons -->
                <el-form-item>
                    <el-button type="primary" @click="onSubmit('formRule')">{{ buttonDesc }}</el-button>
                    <el-button v-if="cancelOrBack" @click="resetForm('formRule')">Reset</el-button>
                    <el-button @click="back">Kembali</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
    import { get, post } from '../helpers/api'

    export default {
        props: ['meta', 'entity_id'],
        data () {
            return {
                storeURL: `/car-usage`,
                formRule: {
                    driver_id: '',
                    fuel_status: 'Cukup'
                },
                second_did: false,
                dnm: '',
                cda: false,
                dsm: '',
                idle_employees: [],
                idle_drivers: [],
                bup_drivers: [],
                available_cars: [],
                et_days: 0,
                et_hours: 1,
                rules: {
                    nip: [{ required: true, message: 'NIP / Pegawai tidak boleh kosong!' }],
                    driver_id: [{ required: true, message: 'Driver tidak boleh kosong! Silahkan pilih kendaraan terlebih dahulu' }],
                    backup_driver: [{ required: this.cda, message: 'Harus ada driver pengganti!' }],
                    car_plat_number: [{ required: true, message: 'Jenis kendaraan tidak boleh kosong!' }],
                    destination: [{ required: true, message: 'Tempat tujuan tidak boleh kosong!' }],
                    necessity: [{ required: true, message: 'Keperluan tidak boleh kosong!' }]
                }
            }
        },
        computed: {
            cancelOrBack () {
                return (this.meta == 'Create') ? true : false
            },
            buttonDesc () {
                return (this.meta == 'Create') ? 'Request' : 'Update'
            }
        },
        methods: {
            init () {
                this.idleDriver()
                this.idleEmployees()
                this.availableCars()

                if (this.meta == 'Edit') {
                    this.storeURL = `/car-usage/${this.entity_id}?_method=PUT`
                    get(`/api/usage/${this.entity_id}`)
                        .then((response) => {
                            this.formRule = response.data.model
                            this.dnm = response.data.model.driver_id
                            this.et_days = response.data.model.et_days
                            this.et_hours = response.data.model.et_hours
                        })
                        .catch((error) => { console.log(error) })
                }
            },
            idleEmployees () {
                get(`/api/employees-available/${this.meta.toLowerCase()}/${this.entity_id}`)
                    .then((response) => {
                        this.idle_employees = response.data.model
                    })
            },
            idleDriver () {
                get(`/api/driver-available/${this.meta.toLowerCase()}/${this.entity_id}`)
                    .then((response) => {
                        this.idle_drivers = response.data.model
                        this.bup_drivers = response.data.model
                    })
            },
            availableCars () {
                get(`/api/car-available/${this.meta.toLowerCase()}/${this.entity_id}`)
                    .then((response) => {
                        this.available_cars = response.data.model
                    })
            },
            onSubmit (formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.formRule.estimates_time = ((this.et_days * 24) + this.et_hours)
                        console.log(this.formRule)
                        post(this.storeURL, this.formRule)
                            .then((response) => {
                                if (response.data.valid) {
                                    swal({
                                        icon: "success",
                                        text: response.data.message
                                    })
                                    .then(function () {
                                        location.href = response.data.redirect_url
                                    })
                                }
                                else {
                                    swal({
                                        icon: "error",
                                        text: response.data.message
                                    })
                                }
                            })
                            .catch((error) => {
                                swal({
                                    icon: "error",
                                    text: error
                                })
                            })
                    } else {return false}
                })
            },
            carSelect () {
                get(`/api/b/${this.formRule.car_plat_number}`)
                    .then((response) => {
                        this.second_did = false
                        this.checkDriverAvail(response.data.data.id)
                        this.formRule.driver_id = response.data.data.id
                        this.dnm = response.data.data.driver_name
                        this.bup_drivers.forEach(function (driver) {
                            driver.disabled = (driver.id == response.data.data.id) ? true : false
                        })
                    })
                    .catch((error) => {
                        this.second_did = true
                        this.dnm = ''
                        this.bup_drivers.forEach(function (driver) {
                            driver.disabled = false
                        })
                        this.formRule.driver_id = ''
                        this.formRule.backup_driver_id = ''
                        this.cda = false
                    })
            },
            secondDriverChoice () {
                this.formRule.driver_id = this.dnm
            },
            checkDriverAvail(did) {
                get(`/api/check-driver-availability/${did}`)
                    .then((response) => {
                        this.cda = response.data.model
                        this.dsm = response.data.msg
                    })
                    .catch((error) => console.log(error))
            },
            resetForm (formName) {
                this.$refs[formName].resetFields()
            },
            back () {
                location.href = `/car-usage/${this.entity_id}`
            }
        },
        mounted() {
            this.init()
        }
    }
</script>
