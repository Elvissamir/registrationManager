<template>
    <Link class="border border-gray-500 px-4 rounded-md text-lg font-bold" 
          :class="[(order == option)? 'bg-green-200 text-gray-400 border-none' : '']" 
          :href="url" method="get" as="button" type="button">{{ name }}</Link>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },
    props: {
        order: {
            required: true,
            type: String,
        },
        option: {
            required: true,
            type: String,
        },
        url: {
            required: true,
            type: String,
        },
        name: {
            required: true,
            type: String,
        }
    },
    setup() {
        
    },
}
</script>
