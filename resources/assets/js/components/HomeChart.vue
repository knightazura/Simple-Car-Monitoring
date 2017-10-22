<template>
  <div class="card text-white bg-warning">
      <div class="card-body">
          <p class="card-text">Status kendaraan lainnya.</p>
          <doughnut-chart :data="example"></doughnut-chart>
      </div>
  </div>
</template>
<script>
  import DoughnutChart from '../helpers/Doughnut.js'

  export default {
    components: { DoughnutChart },
    data () {
      return {
        example: {
          labels: ['Tersedia', 'Dipakai', 'Diperbaiki', 'Rusak'],
          datasets: [
            {
              label: 'GitHub Commits',
              backgroundColor: ['#f87979', '#abc', '#4590ab', '#889cab'],
              data: [13, 4, 1, 2]
            }
          ]
        }
      }
    }
  }
</script>
