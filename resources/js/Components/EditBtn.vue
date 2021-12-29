<template>

    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route(routeName, model.id)" 
          method="get" as="button" type="button">
        <slot></slot>
    </Link> 

</template>

<script>

import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },
    props: {
        routeName: {
            type: String,
            required: true,
        },
        model: {
            type: Object,
            required: true,
        }
    },
    setup() {
        
    },
}
</script>