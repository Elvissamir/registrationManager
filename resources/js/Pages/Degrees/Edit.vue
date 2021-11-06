<template>
  <div>
          <Layout>
            <div class="flex flex-col shadow-md rounded px-8 pt-6 pb-8 my-8 mx-auto w-3/12 bg-white">
                <div class="flex flex-row text-2xl">
                    <h1>Editar Grado {{ degree.title }} {{ degree.level }} </h1>
                </div>

                <div class="flex mt-4">
                    <form class="" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="titulo">Titulo: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="title" v-model="form.title" />
                            <div class="text-red-500 text-xs italic" v-if="errors.title">{{ errors.title }}</div>
                        </div>

                        <div class="flex flex-col mt-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="level">Nivel: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" id="level" v-model="form.level" />
                            <div class="text-red-500 text-xs italic" v-if="errors.level">{{ errors.level }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">Guardar</button>
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
        degree: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const form = ref({
            title: props.degree.title,
            level: props.degree.level,
        })

        function submit() {
            
            const url = `/degrees/${props.degree.id}`;
            Inertia.put(url, form.value)
        }

        return { form, submit }
        },
}
</script>