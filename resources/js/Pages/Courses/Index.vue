<template>
  <div>
        <Layout>
            <Container :width="'w-10/12'">
                <div class="flex flex-row">
                    <Title>Cursos Disponibles</Title>
                    <GetBtn class="ml-auto" :routeName="'courses.create'">Crear Curso</GetBtn>
                </div>

                   <div v-if="hasCourses">
                    <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Id</th>
                                <th class="border border-gray-300 px-2">Seccion</th>
                                <th class="border border-gray-300 px-2">Grado</th>
                                <th class="border border-gray-300 px-2">Periodo</th>
                                <th class="border border-gray-300 px-2">Estado</th>
                                <th class="border border-gray-300 px-2">Ver</th>
                                <th class="border border-gray-300 px-2">Editar</th>
                                <th class="border border-gray-300 px-2">+ Materia</th>
                                <th class="border border-gray-300 px-2">+ Alumno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(course, index) in courses.data" :key="index">
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

                                <td class="border border-gray-300 px-2">
                                    <ShowBtn :routeName="'courses.show'" :model="course">Ver</ShowBtn>
                                </td>

                                <td class="border border-gray-300 px-2">
                                    <EditBtn :routeName="'courses.edit'" :model="course">Editar</EditBtn>
                                </td>

                                <td class="h-12 justify-center items-center border border-gray-300 px-2">
                                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courseSubjects.create', course.id)" method="get" as="button" type="button">
                                        + Materia
                                    </Link>
                                </td>

                                <td class="h-12 justify-center items-center border border-gray-300 px-2">
                                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courseStudents.create', course.id)" method="get" as="button" type="button">
                                        + Alumno
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- PAGINATION --> 
                    <Pagination :model="courses"></Pagination>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg"> No hay alumnos para mostrar por el momento.</p>

                    <div class="mx-auto mt-3">
                        <Link class="mt-2 bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courses.create')" method="get" as="button" type="button">
                            Crear Curso
                        </Link>
                    </div>
                </div>
            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container.vue'
import Title from '../../Components/Title.vue'
import { Link } from '@inertiajs/inertia-vue3'
import Pagination from '../../Components/Pagination.vue'
import GetBtn from '../../Components/GetBtn.vue'
import ShowBtn from '../../Components/ShowBtn.vue'
import EditBtn from '../../Components/EditBtn.vue'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Container,
        Title,
        Link,
        ShowBtn,
        EditBtn,
        Pagination,
        GetBtn,
    },
    props: {
        courses: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        console.log(props.courses);

        const hasCourses = ref(true);

        if (props.courses.length == 0)
            hasCourses.value = false;

        return {
            hasCourses,
        }
    },
}
</script>