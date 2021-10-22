<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-10/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl">Cursos Disponibles:</h1>
                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courses.create')" method="get" as="button" type="button">
                        Crear Curso
                    </Link>
                </div>

                <div v-if="hasCourses">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Id</th>
                                <th class="border border-gray-300 px-2">Seccion</th>
                                <th class="border border-gray-300 px-2">Grado</th>
                                <th class="border border-gray-300 px-2">Periodo</th>
                                <th class="border border-gray-300 px-2">Estado</th>
                                <th class="border border-gray-300 px-2">Agregar Materia</th>
                                <th class="border border-gray-300 px-2">Agregar Alumno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(course, index) in courses" :key="index">
                                <td class="border border-gray-300 px-2">
                                    <a class="text-blue-500 underline" :href="route('courses.show', course.id)">
                                        {{ course.id }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ course.section.name }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ course.degree.title }}
                                </td>
                                <td class="border border-gray-300 px-2">{{ course.period }}</td>
                                <td class="border border-gray-300 px-2">
                                    <div v-if="course.status == 'active'">
                                        Activo
                                    </div>
                                    <div v-else>
                                        Finalizado
                                    </div>
                                </td>

                                <td class="h-12 justify-center items-center border border-gray-300 px-2">
                                    <Link class="text-sm bg-gray-800 rounded-md font-bold text-white py-1 px-4" :href="route('courseSubjects.create', course.id)" method="get" as="button" type="button">
                                        Agregar Materia
                                    </Link>
                                </td>

                                <td class="h-12 justify-center items-center border border-gray-300 px-2">
                                    <Link class="text-sm bg-gray-800 rounded-md font-bold text-white py-1 px-4" :href="route('courseStudents.create', course.id)" method="get" as="button" type="button">
                                        Agregar Alumno
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg"> No hay alumnos para mostrar por el momento.</p>

                    <Link class="mt-2 bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courses.create')" method="get" as="button" type="button">
                        Crear Curso
                    </Link>
                </div>

            </div>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Link,
    },
    props: {
        courses: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const hasCourses = ref(true);

        if (props.courses.length == 0)
            hasCourses.value = false;

        return {
            hasCourses,
        }
    },
}
</script>