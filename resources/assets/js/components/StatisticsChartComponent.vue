<template>
    <canvas ref="chart"></canvas>
</template>

<style>

</style>

<script>
    import Chart from 'chart.js'
export default {
  name: 'name',
  data () {
    return {
      data: 'example'
    }
  },
  props: {
    totalUsers: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    },
    messages: {
      type: Array,
      required: true
    }
  },
  mounted () {
    let cfg = {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [
          {
            label: 'New users',
            backgroundColor: 'rgb(255,0,0)',
            borderColor: 'rgb(255,0,0)',
            data: this.users,
            fill: false
          },
          {
            label: 'Total users',
            backgroundColor: 'rgb(0,255,0)',
            borderColor: 'rgb(0,255,0)',
            data: this.totalUsers,
            fill: false
          },
          {
            label: 'Chat messages',
            backgroundColor: 'rgb(0,0,255)',
            borderColor: 'rgb(0,0,255)',
            data: this.messages,
            fill: false
          }
        ]
      }
    }
    new Chart(this.$refs.chart.getContext('2d'), cfg)
  }
}
</script>