<template>

    <div class="flex mt-8 justify-center text-lg font-bold">
        <p class="">Mostrando </p>
        <p class="ml-1">{{ itemsCount }}</p>
        <p class="ml-1">de</p>
        <p class="ml-1">{{ totalItems }}</p>
        <p class="ml-1">elementos</p>
    </div>

    <div class="flex justify-center mx-auto mt-3 mb-5">
        <Link class="bg-green-700 text-white px-4 border border-green-700 rounded-md text-lg font-bold hover:bg-white hover:text-green-700" :href="model.links.first" method="get" as="button" type="button">First</Link>
        
        <div class="ml-2">
            <Link v-if="showPrev" class="bg-green-700 text-white px-4 border border-green-700  rounded-md text-lg font-bold hover:bg-white hover:text-green-700" :href="model.links.prev" method="get" as="button" type="button">Prev</Link>
            <button v-else class="bg-gray-400 cursor-not-allowed text-white px-4 rounded-md text-lg font-bold" disabled>Prev</button>
        </div>
        
        <div class="flex items-center border border-gray-400 ml-2 px-2 text-lg font-bold rounded-full">{{ model.meta.current_page }}</div>
        
        <div class="ml-1">
            <Link v-if="showNext" class="bg-green-700 text-white px-4 border border-green-700  rounded-md text-lg font-bold hover:bg-white hover:text-green-700" :href="model.links.next" method="get" as="button" type="button">Next</Link>
            <button v-else class="bg-gray-400 cursor-not-allowed text-white px-4 rounded-md text-lg font-bold" disabled>Next</button>
        </div>

        <Link class="bg-green-700 text-white ml-2 px-4 border border-green-700  rounded-md text-lg font-bold hover:bg-white hover:text-green-700" :href="model.links.last" method="get" as="button" type="button">Last</Link>
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

        const itemsCount = ref(props.model.data.length);
        const totalItems = ref(props.model.meta.total);

        const showPrev = ref((props.model.links.prev == null)? false : true);
        const showNext = ref((props.model.links.next == null)? false : true);

        return {
            itemsCount, 
            totalItems,
            showPrev,
            showNext,
        }
    },
}
</script>