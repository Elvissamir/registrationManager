<template>
  <div>
         <Layout>
            <div class="flex flex-col max-w-md shadow-md rounded px-8 pt-6 pb-8 my-8 mx-auto bg-white">
                <div class="flex flex-row text-2xl">
                    <h1>Registrar Curso </h1>
                </div>

                <div class="flex mt-4">
                    <form class="" @submit.prevent="submit">
                        
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="section_id">Seleccione la seccion: </label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  name="section_id" id="section_id" v-model="form.section_id">
                                <option v-for="(section, index) in sections" :key="index" :value="section.id" >
                                    {{ section.name }}
                                </option>                                
                            </select>

                            <div class="text-red-500 text-xs italic" v-if="errors.section_id">{{ errors.section_id }}</div>
                        </div>

                       <div class="flex flex-col mt-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="degree_id">Seleccione el grado: </label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  name="degree_id" id="degree_id" v-model="form.degree_id">
                                <option v-for="(degree, index) in degrees" :key="index" :value="degree.id" >
                                    {{ degree.title }}
                                </option>                                
                            </select>

                            <div class="text-red-500 text-xs italic" v-if="errors.degree_id">{{ errors.degree_id }}</div>
                        </div>

                         <div class="flex flex-col mt-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="period">Periodo: </label>
                              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="period" v-model="form.period" />

                            <div class="text-red-500 text-xs italic" v-if="errors.period">{{ errors.period }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">Registrar</button>
                    </form>
                </div>
            </div>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Link,
    },
    props: {
        sections: {
            required: true,
            type: Object,
        },
        degrees: {
            required: true,
            type: Object,
        },
        errors: {
            required: true,
            type: Object,
        }
    },
    setup() {

        const form = ref({
            degree_id: null,
            section_id: null,
            period: null,
        })

        function submit() {
            Inertia.post('/courses', form.value)
        }

        return { form, submit }
        },
}
</script>