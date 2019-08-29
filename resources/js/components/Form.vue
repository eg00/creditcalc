<template>
    <div class="px-8 py-8 bg-white flex-grow">
        <form @submit.prevent="onSubmit">
            <div class="md:flex md:items-top mb-6">
                <div class="md:w-1/3">
                    <label for="amount" class="input-label">Сумма кредита</label>
                </div>
                <div class="md:w-2/3">
                    <input type="text"
                           :class="{'form-input w-full':true, 'input-error' : errors && errors.amount}"
                           id="amount" name="amount"
                           v-model.number="form.amount"
                           aria-describedby="amount__help">
                    <span v-if="errors && errors.amount" class="block text-red-500 text-xs italic"
                          role="alert">{{ errors.amount[0] }}</span>
                    <small v-else id="amount__help" class="block text-sm">
                        в рублях, от 500 000 до 10 000 000
                    </small>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="rate" class="input-label">Годовая процентная ставка</label>
                </div>
                <div class="md:w-2/3">
                    <input type="text"
                           :class="{'form-input w-full':true, 'input-error' : errors && errors.rate}"
                           id="rate" name="rate"
                           v-model="form.rate"
                           aria-describedby="rate__help">
                    <span v-if="errors && errors.rate" class="block text-red-500 text-xs italic" role="alert">{{ errors.rate[0] }}</span>
                    <small v-else id="rate__help" class="block text-sm">в %, от 1 до 100</small>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="period" class="input-label">Срок кредита</label>
                </div>
                <div class="md:w-2/3">
                    <div class="flex">
                        <input type="text"
                               :class="{'form-input rounded-r-none w-2/3':true,'input-error' : errors && errors.period}"
                               id="period" name="period"
                               v-model="form.period"
                               aria-describedby="period__help">
                        <select class="form-select block  rounded-l-none" v-model="form.period_type">
                            <option value="year">в годах</option>
                            <option value="month">в месяцах</option>
                        </select>
                    </div>
                    <span v-if="errors && errors.period" class="block text-red-500 text-xs italic"
                          role="alert">{{ errors.period[0] }}</span>
                    <small v-else id="period__help" class="block text-sm">{{period__help}}</small>
                </div>
            </div>
            <label class="flex items-center mb-3">
                <input type="checkbox" class="form-checkbox" v-model.number="form.detailed">
                <span class="ml-2">Показать помесячные платежи</span>
            </label>
            <label class="flex items-center mb-3" v-show="form.detailed">
                <input type="checkbox" class="form-checkbox" v-model="form.chart">
                <span class="ml-2">Показать график</span>
            </label>
            <div class="md:flex justify-center">
                <button type="submit"
                        class="shadow bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Расчитать
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['errors', 'result'],
    name: 'Form',
    data() {
        return {
            form: {
                // amount: null,
                // rate: null,
                // period: null,
                amount: 500000,
                rate: 20,
                period: 20,
                period_type: 'year',
                detailed: 0,
                chart: 0,
            },
        }
    },
    methods: {
        inputHandler: function (input) {
            if (this.errors && this.errors[input]) {
                this.errors[input] = null
            }
            if (this.isCalculated) {
                this.isCalculated = false
            }
        },
        onSubmit() {
            this.$emit('submited', this.form)
        },
    },
    watch: {
        'form.amount'() {
            this.inputHandler('amount')
        },
        'form.rate'() {
            this.inputHandler('rate')
        },
        'form.period'() {
            this.inputHandler('period')
        },
        'form.period_type'() {
            this.inputHandler('period')
        },

    },
    computed: {
        period__help() {
            return this.form.period_type === 'year' ? 'от 10 до 50' : 'от 120 до 600'
        },
    },
}
</script>

<style scoped>

</style>
