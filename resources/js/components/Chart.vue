<template>
    <div class="px-8 py-8 bg-white flex-grow my-4 w-4/5">
            <apexchart :options="options" :series="series"></apexchart>
    </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
  name: 'Chart',
  components: { 'apexchart': VueApexCharts },
  props: { data: Array },
  data () {
    return {
      options: {
        chart: {},
        yaxis: [
          {
            seriesName: 'Остаток долга после платежа',
          },
          {
            opposite: true,
            seriesName: 'В погашение долга',
          },
          {
            opposite: true,
            seriesName: 'В погашение процентов',
          },
        ],
        fill: {
          type: [ 'gradient', 'solid', 'solid'],
          opacity: [0.85,0.25],
          gradient: {
            inverseColors: false,
            shade: 'light',
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100]
          }
        },
      },

      xaxis: [
        {
          tickAmount: 20,
          floating: true,
        },
        {
          tickAmount: 20,
          floating: true,
        }],
      series: [
        {
          name: 'Остаток долга после платежа',
          type: 'line',
          data: this.data.filter(item => item.num % 12 === 0).map(item => parseInt(item.debt)),
        },
        {
          name: 'В погашение долга',
          data: this.data.filter(item => item.num % 12 === 0).map(item => parseInt(item.repayment)),
          type: 'column',
        },
        {
          name: 'В погашение процентов',
          data: this.data.filter(item => item.num % 12 === 0).map(item => parseInt(item.interest)),
          type: 'column',
        },
      ],
    }
  },
}
</script>
