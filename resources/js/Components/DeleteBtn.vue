<template>
    <Link class="ml-auto bg-red-600 font-bold text-white" 
          :href="route(routeName, model.id)"  
           method="delete" as="button" type="button" :class="[(circle)? 'rounded-full px-2' : 'rounded-md px-4']">
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
        circle: {
            type: Boolean,
            required: true,
        },
        routeName: {
            type: String,
            required: true,
        },
        model: {
            type: Object,
            required: true,
        }
    },
    setup(props) {
        
    },
}
</script>