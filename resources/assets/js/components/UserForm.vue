<template>
  <div class="card">
    <div class="card-body">
      <el-form ref="form" :model="form" label-position="top">
        <!-- Nama Lengkap -->
        <div class="form-group">
          <label for="name">Nama Lengkap</label>
          <el-form-item prop="name">
            <el-input v-model="form.name" id="name"></el-input>
          </el-form-item>
        </div>

        <!-- Username -->
        <div class="form-group">
          <label for="username">Username</label>
          <el-form-item prop="username">
            <el-input v-model="form.username" id="username"></el-input>
          </el-form-item>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label for="email">Alamat e-mail</label>
          <el-form-item prop="email">
            <el-input v-model="form.email" id="email"></el-input>
          </el-form-item>
        </div>

        <!-- Role -->
        <div class="form-group" v-if="isAdmin">
          <label for="role_id">User Role</label>
          <el-form-item>
            <el-select class="w-100" v-model="form.role_id" placeholder="Select">
              <el-option :value="1" :label="'Administrator'"></el-option>
              <el-option :value="2" :label="'User'"></el-option>
            </el-select>
          </el-form-item>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="password">Password</label>
          <el-form-item>
            <el-input type="password" v-model="form.password" id="password" :disabled="!change_password"></el-input>
          </el-form-item>
          <el-checkbox v-model="change_password">Ubah Password</el-checkbox>
        </div>

        <!-- Submit -->
        <div class="form-group">
          <el-button type="primary" @click="onSubmit">Save</el-button>
          <a href="/manage-users" class="btn">Kembali</a>
        </div>
      </el-form>
    </div>
  </div>
</template>

<script>
  import { get, post } from '../helpers/api'

  export default {
    props: ['entity_id', 'role_id'],
    created () {
      this.init()
    },
    computed: {
      isAdmin () {
        return (this.role_id > 1) ? true : false
      }
    },
    data () {
      return {
        form: {},
        change_password: false
      }
    },
    methods: {
      init () {
        get(`/api/user/${this.entity_id}`)
          .then((response) => {
            this.form = response.data.model
            this.form.role_id = response.data.model.roles[0].id
          })
          .catch(error => swal({ icon: "error", text: error }))
      },
      onSubmit () {
        post(`/manage-users/${this.entity_id}?_method=PUT`, this.form)
          .then((response) => {
            swal({
              icon: "success",
              text: response.data.message
            })
              .then(() => location.href = response.data.redirect_url)
          })
      }
    }
  }
</script>
