<template>
  <div>
    <span v-if="errors" v-for="error in errors" class="text-red-500">{{error}}</span>
  </div>
</template>

<script>
    export default {
        props: {
            errors: {
                type: Array,
                required: true,
                default: () => []
            }
        }
    }
</script>
