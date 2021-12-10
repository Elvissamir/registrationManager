<template>
  <div>
        <Layout>
            <Container :width="'w-8/12'">
                <div class="flex">
                    <Title>Curso {{ course.degree.title }} {{ course.degree.level }} {{ course.section.name }}</Title>
                    <div class="flex ml-auto">
                        <EditBtn class="mr-2" :routeName="'courses.edit'" :model="course">Editar</EditBtn>
                    </div>
                </div>

                <!-- COURSE DATA --> 
                <div class="flex justify-between">
                    <div class="flex flex-col justify-between mt-4 w-5/12 border-r-2 border-gray-300">
                        <p class="text-xl font-bold">Datos del Curso</p>
                        <p class="text-lg mt-2">Nombre: {{ course.degree.title }} {{ course.section.name }} </p>
                        <p class="text-lg">Grado: {{ course.degree.title }} {{ course.degree.level }}</p>
                        <p class="text-lg">Seccion: {{ course.section.name }}</p>
                        <p class="text-lg">Periodo: {{ course.period }}</p>
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
                    <div class="flex flex-col mt-4 w-6/12">
                        <p class="text-xl font-bold">Datos del Estudiante</p>
                        <p class="text-lg mt-2">Nombre Completo: {{ student.first_name }} {{ student.last_name }} </p>
                        <p class="text-lg">Edad: {{ student.age }} </p>
                    </div>
                </div>

                <!-- SUBJECTS & SCORES -->
                <div class="flex flex-col mt-4">
                    <Title>Calificaciones:</Title>
                    <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2 py-1">Materia</th>
                                <th class="border border-gray-300 px-2">Creditos</th>
                                <th class="border border-gray-300 px-2">1er Lapso</th>
                                <th class="border border-gray-300 px-2">2do Lapso</th>
                                <th class="border border-gray-300 px-2">3er Lapso</th>
                                <th class="border border-gray-300 px-2">4to Lapto</th>
                                <th class="border border-gray-300 px-2">Total</th>
                                <th class="border border-gray-300 px-2">Editar Calificaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(subject, index) in student.subjects" :key="index">
                                <td class="border border-gray-300 px-2 py-1">
                                    <p>{{ subject.title }} </p>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <p>{{ subject.credits }}</p>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <p>{{ subject.first }}</p>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <p>{{ subject.second }}</p>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <p>{{ subject.third }}</p>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <p>{{ subject.fourth }}</p>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <p>{{ (subject.first + subject.second + subject.third + subject.fourth)/4 }}</p>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="`/students/${student.id}/subjects/${subject.id}/edit`" 
                                          method="get" as="button" type="button">
                                        Editar
                                    </Link> 
                                </td>
                            </tr>
                        </tbody>
                    </table>    
                </div> 

            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container.vue'
import Title from '../../Components/Title'
import DeleteBtn from '../../Components/DeleteBtn'
import EditBtn from '../../Components/EditBtn'
import { Link } from '@inertiajs/inertia-vue3'
import ShowBtn from '../../Components/ShowBtn'

export default {
    components: {
        Layout,
        Container,
        Title,
        ShowBtn,
        EditBtn,
        Link,
        DeleteBtn,
    },
    props: {
        course: {
            required: true,
            type: Object,
        },
        student: {
            required: true,
            type: Object,
        }
    },
    setup(props) {
        
    }
}
</script>