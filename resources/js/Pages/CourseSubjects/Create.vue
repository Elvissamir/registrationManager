<template>
  <div>
         <Layout>
            <div class="flex flex-col max-w-md shadow-md rounded px-8 pt-6 pb-8 my-8 mx-auto bg-white">
                <div class="flex flex-row text-2xl">
                    <h1>Agregar Materia al Curso {{ course.id }}</h1>
                </div>

                <div class="flex mt-4">
                    <form class="" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">Seleccione la materia: </label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  name="subject_id" id="subject_id" v-model="form.subject_id">
                                <option v-for="(subject, index) in subjects" :key="index" :value="subject.id" >
                                    {{ subject.title }}
                                </option>                                
                            </select>

                            <div class="text-red-500 text-xs italic" v-if="errors.subject_id">{{ errors.subject_id }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Registrar
                        </button>
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
        course: {
            required: true,
            type: Object,
        },
        subjects: {
            required: true,
            type: Object,
        },
        errors: {
            required: true,
            type: Object,
        }
    },
    setup(props) {

        const form = ref({
            subject_id: null,
        })

        function submit() {
            
            const url = `/courses/${props.course.id}/subjects`;

            Inertia.post(url, form.value);
        }

        return { form, submit }
        },
}
</script>