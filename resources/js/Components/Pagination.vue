<template>
    <div class="flex justify-center mx-auto mt-10 mb-5">
        <Link class="bg-green-700 text-white px-4 rounded-md text-lg font-bold" :href="model.links.first" method="get" as="button" type="button">First</Link>
        <Link class="bg-green-700 text-white ml-2 px-4 rounded-md text-lg font-bold" :href="model.links.prev" method="get" as="button" type="button">Prev</Link>
        <div class="flex items-center border border-gray-400 ml-2 px-2 text-lg font-bold rounded-full">{{ model.meta.current_page }}</div>
        <Link class="bg-green-700 text-white ml-2 px-4 rounded-md text-lg font-bold" :href="model.links.next" method="get" as="button" type="button">Next</Link>
        <Link class="bg-green-700 text-white ml-2 px-4 rounded-md text-lg font-bold" :href="model.links.last" method="get" as="button" type="button">Last</Link>
    </div>
</template>

<script>

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
    setup() {
        
    },
}
</script>