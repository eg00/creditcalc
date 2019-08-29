<template>
    <div class="px-8 py-8 bg-white mt-4">
        <div class="col-sm-8">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Месяц</th>
                    <th scope="col">В погашение долга</th>
                    <th scope="col">В погашение процентов</th>
                    <th scope="col">Остаток долга после платежа</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in data" class="odd:bg-gray-200">
                    <td class="text">{{row.num | round}}</td>
                    <td>{{row.repayment | round}}</td>
                    <td>{{row.interest | round}}</td>
                    <td>{{(row.debt).toFixed()}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props:{data: Array},
        name: "DetailedTable"
    }
</script>

<style scoped>
    /*td {*/
    /*    @apply py-4 px-6 border-b border-gray-400 text-center;*/
    /*}*/
    /*th {*/
    /*    @apply py-4 px-6 font-medium uppercase font-heading text-gray-500 border-b border-gray-400*/
    /*}*/
</style>
