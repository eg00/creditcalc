<template>
    <div class="container flex flex-col justify-center items-center mx-auto">
        <div class="rounded shadow-lg min-w-1/2 flex flex-col">
            <h2 class="font-heading border-blue-500 border-b text-center py-4 bg-white">
                Калькулятор ежемесячных аннуитетных платежей
            </h2>

            <transition name="extra" mode="out-in">
                <result-component v-if="isCalculated && result.annuity" @reset="handleReset">
                    Ваш ежемесячный платёж составит: {{result.annuity | round}} руб.
                </result-component>
                <form-component v-else @submited="handleSubmit" :errors="errors"></form-component>
            </transition>
        </div>
        <transition name="fade" mode="out-in">
            <chart-component v-if="showChart" :data="result.data"></chart-component>
        </transition>
        <transition name="fade" mode="out-in">
            <detailed-table v-if="showDetailed" :data="result.data"></detailed-table>
        </transition>

    </div>
</template>

<script>
import axios from 'axios'
import DetailedTable from './DetailedTable'
import Form from './Form'
import Result from './Result'
import Chart from './Chart'

export default {
    name: 'Calc',
    components: {'chart-component': Chart, 'result-component': Result, 'form-component': Form, DetailedTable},
    data() {
        return {
            isCalculated: false,
            chartChecked: false,
            result: {},
            errors: {},
        }
    },
    methods: {
        handleSubmit(formData) {
            this.errors = {};
            this.chartChecked = formData.chart;
            axios.post('/api/calc', formData).then(({data}) => {
                this.result = data
                this.isCalculated = true
            }).catch(({response: {data, status}}) => {
                if (status === 422) {
                    this.isCalculated = false
                    this.errors = data || {}
                }
            })
        },
        handleReset() {
            this.isCalculated = false
        },

    },
    computed: {
        showDetailed() {
            return this.isCalculated && Array.isArray(this.result.data)
        },
        showChart() {
            return this.showDetailed && this.chartChecked;
        }

    },
}
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .7s, transform 1s;
        transform: none;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;

    }

    .fade-leave-to {
        transform: scale(0);
    }


    /* Extra Styes */
    .extra-enter {
        transform: translateX(-50vw);
        /*opacity: 0;*/

    }

    .extra-enter-to {
        transform: translateX(0px);
    }

    .extra-enter-active {
        transition: all 1s ease;
    }

    .extra-leave-active, .extra-leave-to {
        /*opacity: 0;*/
    }

    .card-body {
        background-color: #ffffff;
    }
</style>
