<template>
  <div>
         <Layout>
            <Container :width="'w-4/12'">
                <div class="flex flex-row text-2xl">
                    <Title>Agregar Alumno al Curso {{ course.id }}</Title>
                </div>

                <div class="flex mt-4">
                    <form class="w-full" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="first_name">Seleccione el alumno: </label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  name="student_id" id="student_id" v-model="form.student_id">
                                <option v-for="(student, index) in students" :key="index" :value="student.id" >
                                    {{ student.first_name }} {{ student.last_name }}
                                </option>                                
                            </select>

                            <div class="text-red-500 text-sm italic" v-if="errors.student_id">{{ errors.student_id }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Registrar
                        </button>
                    </form>
                </div>
            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Title,
        Container,
    },
    props: {
        course: {
            required: true,
            type: Object,
        },
        students: {
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
            student_id: null,
        })

        function submit() {
            const url = `/courses/${props.course.id}/students`;

            Inertia.post(url, form.value);
        }

        return { form, submit }
        },
}
</script>