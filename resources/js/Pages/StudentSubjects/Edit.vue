<template>
  <div>
         <Layout>
            <Container :width="'w-4/12'">
                <div class="flex">
                    <Title>Editar Calificaciones {{ subject.title }}</Title>
                </div>

                  <!-- COURSE DATA --> 
                <div class="flex flex-col justify-between">
                    <div class="flex flex-col justify-between mt-4">
                        <p class="text-xl font-bold">Datos del Curso</p>
                        <p class="text-lg mt-2">Nombre: {{ course.degree.title }} {{ course.degree.level }} {{ course.section.name }} </p>
                        <div class="flex">
                            <p class="text-lg">Estado: </p>
                            <div v-if="course.status == 'active'">
                                <p class="text-lg ml-2">Activo</p>
                            </div>

                            <div v-else>
                                <p class="text-lg ml-2">Finalizado</p>
                            </div>
                        </div>
                    </div>

                    <!-- STUDENT DATA-->
                    <div class="flex flex-col mt-4">
                        <p class="text-xl font-bold">Datos del Estudiante</p>
                        <p class="text-lg mt-2">Nombre Completo: {{ student.first_name }} {{ student.last_name }} </p>
                    </div>
                </div>

                <div class="flex flex-col mt-4">
                    <p class="text-xl font-bold">Calificaciones </p>
                    <form class="w-full" @submit.prevent="submit">
                        <div class="flex flex-col mt-2">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="first">1er Lapso: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" max="20" id="first" v-model="form.first" />

                            <div class="text-red-500 text-sm italic" v-if="errors.first">{{ errors.first }}</div>
                        </div>

                         <div class="flex flex-col mt-2">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="second">2do Lapso: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" max="20" id="second" v-model="form.second" />

                            <div class="text-red-500 text-sm italic" v-if="errors.second">{{ errors.second }}</div>
                        </div>

                         <div class="flex flex-col mt-2">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="third">3er Lapso: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" max="20" id="third" v-model="form.third" />

                            <div class="text-red-500 text-sm italic" v-if="errors.third">{{ errors.third }}</div>
                        </div>

                         <div class="flex flex-col mt-2">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="fourth">4to Lapso: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" max="20" id="fourth" v-model="form.fourth" />

                            <div class="text-red-500 text-sm italic" v-if="errors.fourth">{{ errors.fourth }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">Guardar</button>
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
        Container,
        Title,
    },
    props: {
        course: {
            required: true,
            type: Object,
        },
        subject: {
            required: true,
            type: Object,
        },
        student: {
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
            first: props.subject.first,
            second: props.subject.second,
            third: props.subject.third,
            fourth: props.subject.fourth,
        })

        function submit() {
            const url = `/students/${props.student.id}/subjects/${props.subject.id}`;
            Inertia.put(url, form.value)
        }

        return { form, submit }
        },
}
</script>