<template>
  <div>
          <Layout>
            <div class="flex flex-col shadow-md rounded px-8 pt-6 pb-8 my-8 mx-auto w-3/12 bg-white">
                <div class="flex flex-row text-2xl">
                    <h1>Crear Seccion </h1>
                </div>

                <div class="flex mt-4">
                    <form class="" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nombre: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" v-model="form.name" />
                            <div class="text-red-500 text-xs italic" v-if="errors.name">{{ errors.name }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">Crear</button>
                    </form>
                </div>
            </div>
        </Layout>
    </div>
</template>

<script>

import { Inertia } from '@inertiajs/inertia'
import Layout from '../../Layouts/AppLayout'
import { ref } from 'vue'

export default {
    components: {
        Layout,
    },
    props: {
        errors: {
            required: true,
            type: Object,
        }
    },
    setup() {

        const form = ref({
            name: null,
        })

        function submit() {
            Inertia.post('/sections', form.value)
        }

        return { form, submit }
        },
}
</script>