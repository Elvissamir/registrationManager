<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-8/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl font-bold">Curso {{ course.degree.title }} {{ course.degree.level }} {{ course.section.name }}</h1>
                    <ShowBtn :routeName="'courseStudents.create'" :model="course">+ Alumno</ShowBtn>
                </div>

                <div class="mt-4">
                     <p class="text-xl font-bold">Datos del Curso</p>
                    <p class="text-lg mt-2">Nombre: {{ course.degree.title }} {{ course.section.name }} </p>
                    <p class="text-lg">Grado: {{ course.degree.title }} {{ course.degree.level }}</p>
                    <p class="text-lg">Seccion: {{ course.section.name }}</p>
                    <p class="text-lg">Periodo: {{ course.period }}</p>
                    <div class="flex">
                        <p class="text-lg">Estado: </p>
                        <div v-if="course.status == 'active'">
                            <p class="text-lg">Activo</p>
                        </div>

                        <div v-else>
                            <p class="text-lg">Finalizado</p>
                        </div>
                    </div>
                </div>

                <div v-if="hasStudents">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Alumno</th>
                                <th class="border border-gray-300 px-2">Edad</th>
                                <th class="border border-gray-300 px-2">Ver</th>
                                <th class="border border-gray-300 px-2">Editar</th>
                                <th class="border border-gray-300 px-2">Remover Alumno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(student, index) in students.data" :key="index">
                                <td class="border border-gray-300 px-2">
                                    <a class="text-blue-500 underline" :href="route('students.show', student.id)">
                                        {{ student.first_name }} {{ student.last_name }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ student.age }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <ShowBtn :routeName="'students.show'" :model="student">Ver</ShowBtn>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <EditBtn :routeName="'students.edit'" :model="student">Editar</EditBtn>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <Link class="border bg-red-800 px-4 rounded-md text-lg text-white font-bold" :href="`/courses/${course.id}/students/${student.id}`" method="delete" as="button" type="button">Remover</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- PAGINATION --> 
                    <Pagination :model="students"></Pagination>
                </div>

                <div class="flex flex-col" v-else>
                    <p class="mt-3 text-lg mx-auto"> No hay alumnos para mostrar por el momento.</p>

                    <div class="mx-auto mt-2">
                        <ShowBtn :routeName="'courseStudents.create'" :model="course">+ Alumno</ShowBtn>
                    </div>
                </div>

            </div>
        </Layout>
    </div>
</template>

<script>

import { ref } from 'vue'
import Layout from '../../Layouts/AppLayout'
import { Link } from '@inertiajs/inertia-vue3'
import ShowBtn from '../../Components/ShowBtn.vue'
import EditBtn from '../../Components/EditBtn.vue'
import Pagination from '../../Components/Pagination.vue'

export default {
    components: {
        Layout,
        ShowBtn,
        EditBtn,
        Link,
        Pagination,
    },
    props: {
        course: {
            type: Object,
            required: true,
        },
        students: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const hasStudents = ref(true);

        if (props.students.length == 0)
            hasStudents.value = false;

        return {
            hasStudents,
        }
    },
}
</script>