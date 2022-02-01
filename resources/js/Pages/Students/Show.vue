<template>
  <div>
        <Layout :title="'Alumno'"> 
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title class="text-2xl font-bold">Alumno: {{ student.first_name }} {{ student.last_name }}</Title>
                    <div class="flex ml-auto">
                        <EditBtn class="mr-2" :routeName="'students.edit'" :model="student">Editar</EditBtn>
                        <DeleteBtn v-if="hasActiveCourses == false && hasFinishedCourses == false" :routeName="'students.destroy'" :model="student" :circle="false">Eliminar</DeleteBtn>
                    </div>
                </div>

                <!-- STUDENT DATA --> 
                <div class="flex flex-col justify-between mt-3">
                    <p class="text-xl font-bold">Datos Personales: </p>
                    <p class="text-lg mt-2">Nombre Completo: {{ student.first_name }} {{ student.last_name }} </p>
                    <p class="text-lg">Edad: {{ student.age }}</p>
                    <p class="text-lg">Telefono (Celular): {{ student.phone_mobile }}</p>
                    <p class="text-lg">Telefono (Casa): {{ student.phone_house }}</p>
                    <p class="text-lg">Fecha de Registro: {{ student.created_at }}</p>
                </div>

                <!-- ACTIVE COURSES --> 
                <div class="flex flex-col mt-5">
					<p class="text-xl font-bold">Cursos Activos: </p>
                    <div v-if="hasActiveCourses" class="flex">
                        <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-gray-300 px-2 py-1">Curso</th>
                                    <th class="border border-gray-300 px-2">Seccion</th>
                                    <th class="border border-gray-300 px-2">Periodo</th>
                                    <th class="border border-gray-300 px-2">Ver</th>
                                    <th class="border border-gray-300 px-2">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(course, index) in activeCourses" :key="index">
                                    <td class="border border-gray-300 px-2 py-1">
                                        <p>{{ course.degree.title }} {{course.degree.level }}</p>
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        {{ course.section.name }}
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        {{ course.period }}
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        <ShowBtn :routeName="'courses.show'" :model="course">Ver</ShowBtn>
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        <EditBtn :routeName="'courses.edit'" :model="course">Editar</EditBtn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="flex mx-auto mt-2">
                        <p class="text-lg">El alumno {{ student.first_name }} {{ student.last_name }} no esta inscrito en ningun curso activo.</p>
                    </div>
                </div>

                <!-- FINISHED COURSES --> 
                <div class="flex flex-col mt-6 mb-5">
					<p class="text-xl font-bold">Cursos Finalizados: </p>

                    <div v-if="hasFinishedCourses">
                        <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-gray-300 px-2 py-1">Curso</th>
                                    <th class="border border-gray-300 px-2">Seccion</th>
                                    <th class="border border-gray-300 px-2">Periodo</th>
                                    <th class="border border-gray-300 px-2">Ver</th>
                                    <th class="border border-gray-300 px-2">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(course, index) in finishedCourses" :key="index">
                                    <td class="border border-gray-300 px-2 py-1">
                                        <p>{{ course.degree.title }} {{course.degree.level }}</p>
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        {{ course.section.name }}
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        {{ course.period }}
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        <ShowBtn :routeName="'courses.show'" :model="course">Ver</ShowBtn>
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        <EditBtn :routeName="'courses.edit'" :model="course">Editar</EditBtn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="flex mx-auto mt-2">
                        <p class="text-lg">El alumno {{ student.first_name }} {{ student.last_name }} no ha finalizado ningun curso.</p>
                    </div>
                </div>
            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
import { ref } from 'vue'
import DeleteBtn from '../../Components/DeleteBtn'
import EditBtn from '../../Components/EditBtn'
import ShowBtn from '../../Components/ShowBtn'

export default {
    components: {
        Layout,
        Container, 
        Title,
        ShowBtn,
        EditBtn,
        DeleteBtn,
    },
    props: {
        student: {
            required: true,
            type: Object,
        },
        finishedCourses: {
            required: true,
            type: Array,
        },
        activeCourses: {
            required: true,
            type: Array,
        }
    },
    setup(props) {
       
        const hasActiveCourses = ref(false);
        const hasFinishedCourses = ref(false);
       
        if (props.finishedCourses.length > 0)
	   	    hasFinishedCourses.value = true;
       
        if (props.activeCourses.length > 0)
            hasActiveCourses.value = true;

        return {
            hasActiveCourses,
            hasFinishedCourses,
        }
    },
}
</script>