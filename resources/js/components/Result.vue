<template>
    <div class="px-8 py-8 bg-white flex-grow flex flex-col justify-between">
        <h2 class="text-center mb-2">
            <slot></slot>
        </h2>
        <div>
            <a href="#" class="shadow bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
               @click="$emit('reset')">Еще раз</a>
        </div>
    </div>
</template>

<script>
export default {
  name: 'Result',
}
</script>

<style scoped>

</style>
