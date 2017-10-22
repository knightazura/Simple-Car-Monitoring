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

                <!-- Driver -->
                <el-form-item label="Driver" prop="driver_id">
                    <el-select class="w-75" v-model="formRule.driver_id" filterable placeholder="Pilih">
                        <el-option
                            v-for="driver in idle_drivers"
                            :key="driver.id"
                            :label="driver.driver_name"
                            :value="driver.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <!-- Car Type (car_plat_number) -->
                <el-form-item label="Jenis Kendaraan" prop="car_plat_number">
                    <el-select class="w-50" v-model="formRule.car_plat_number" filterable placeholder="Pilih">
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

                <!-- Total Passengers -->
                <el-form-item label="Jumlah penumpang">
                    <el-input-number v-model="formRule.total_passengers" :min="1"></el-input-number>
                </el-form-item>

                <!-- Destination -->
                <el-form-item label="Tempat tujuan" prop="destination">
                    <el-input class="w-75" v-model="formRule.destination"></el-input>
                </el-form-item>

                <!-- Necessity -->
                <el-form-item label="Keperluan" prop="necessity">
                    <el-input class="w-75" type="textarea" v-model="formRule.necessity"></el-input>
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
                    <el-input class="w-10" v-model="formRule.estimates_time" placeholder=". . ."></el-input> hari
                </el-form-item>

                <!-- Additional Description -->
                <el-form-item label="Keterangan tambahan">
                    <el-input class="w-75" type="textarea" v-model="formRule.additional_description"></el-input>
                </el-form-item>

                <!-- Buttons -->
                <el-form-item>
                    <el-button type="primary" @click="onSubmit('formRule')">Request</el-button>
                    <el-button v-if="cancelOrBack" @click="resetForm('formRule')">Reset</el-button>
                    <a href="/car-usage" class="btn" v-if="!cancelOrBack">Kembali</a>
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
                formRule: {},
                idle_employees: [],
                idle_drivers: [],
                available_cars: [],
                rules: {
                    nip: [{ required: true, message: 'NIP / Pegawai tidak boleh kosong!' }],
                    driver_id: [{ required: true, message: 'Driver tidak boleh kosong!' }],
                    car_plat_number: [{ required: true, message: 'Jenis kendaraan tidak boleh kosong!' }],
                    destination: [{ required: true, message: 'Tempat tujuan tidak boleh kosong!' }],
                    necessity: [{ required: true, message: 'Keperluan tidak boleh kosong!' }]
                }
            }
        },
        computed: {
            cancelOrBack () {
                return (this.meta == 'Create') ? true : false
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
                        })
                        .catch((error) => { console.log(error) })
                }
            },
            idleEmployees () {
                get(`/api/employees/available`)
                    .then((response) => {
                        this.idle_employees = response.data.model
                    })
            },
            idleDriver () {
                get(`/api/driver/available`)
                    .then((response) => {
                        this.idle_drivers = response.data.model
                    })
            },
            availableCars () {
                get(`/api/car/available`)
                    .then((response) => {
                        this.available_cars = response.data.model
                    })
            },
            onSubmit (formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        post(this.storeURL, this.formRule)
                            .then((response) => {
                                swal({
                                    icon: "success",
                                    text: response.data.message
                                })
                                .then(function () {
                                    location.href = response.data.redirect_url
                                })
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
            resetForm (formName) {
                this.$refs[formName].resetFields()
            }
        },
        mounted() {
            this.init()
        }
    }
</script>
