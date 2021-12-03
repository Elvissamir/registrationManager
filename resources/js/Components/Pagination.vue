<template>

    <div class="flex mt-8">
        <p class="">Mostrando </p>
        <p>{{ itemsCount }}</p>
        <p class="ml-1">de</p>
        <p>{{ totalItems }}</p>
    </div>

    <div class="flex justify-center mx-auto mt-3 mb-5">
        <Link class="bg-green-700 text-white px-4 rounded-md text-lg font-bold" :href="model.links.first" method="get" as="button" type="button">First</Link>
        <Link class="bg-green-700 text-white ml-2 px-4 rounded-md text-lg font-bold" :href="model.links.prev" method="get" as="button" type="button">Prev</Link>
        <div class="flex items-center border border-gray-400 ml-2 px-2 text-lg font-bold rounded-full">{{ model.meta.current_page }}</div>
        <Link class="bg-green-700 text-white ml-2 px-4 rounded-md text-lg font-bold" :href="model.links.next" method="get" as="button" type="button">Next</Link>
        <Link class="bg-green-700 text-white ml-2 px-4 rounded-md text-lg font-bold" :href="model.links.last" method="get" as="button" type="button">Last</Link>
    </div>
</template>

<script>

import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },
    props: {
        model: {
            required: true,
            type: Object,
        }
    },
    setup(props) {

        const itemsCount = ref(props.model.meta.to - props.model.meta.from - 1);
        const totalItems = ref(props.model.meta.total);

        
        console.log(props.model);

        return {
            itemsCount, 
            totalItems,
        }
    },
}
</script>