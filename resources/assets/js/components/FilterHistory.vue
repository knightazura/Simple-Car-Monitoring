<template>
  <div class="col">
      <form action="/exp/filter" method="POST">
        <el-date-picker
          v-model="value3"
          name="range"
          type="datetimerange"
          placeholder="Select time range">
        </el-date-picker>
        <input type="submit">
      </form>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        value3: [new Date(2000, 10, 10, 10, 10), new Date(2000, 10, 11, 10, 10)]
      }
    }
  }
</script>
