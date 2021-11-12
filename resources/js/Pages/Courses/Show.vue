<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-6/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl font-bold">Curso {{ course.degree.title }} {{ course.degree.level }} {{ course.section.name }}</h1>
                    <div class="flex ml-auto">
                        <EditBtn class="mr-2" :routeName="'courses.edit'" :model="course">Editar</EditBtn>
                        <DeleteBtn v-if="hasStudents" :routeName="'courses.destroy'" :model="course" :circle="false">Eliminar</DeleteBtn>
                    </div>
                </div>

                <!-- COURSE DATA --> 
                <div class="flex flex-col justify-between mt-3">
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
                    <div class="flex">
                        <p class="text-lg">Cantidad de Alumnos: {{ studentsCount }}</p>
                        <div class="">   
                            <ShowBtn v-if="studentsCount > 0" :routeName="'courseStudents.show'" :model="course">Ver Alumnos</ShowBtn>
                            <ShowBtn :routeName="'courseStudents.create'" :model="course">+ Alumno</ShowBtn>
                        </div>
                    </div>  
                    <p class="text-lg"></p>
                </div>

                <!-- ACTIVE COURSES --> 
                <div class="flex flex-col mt-5">
					<p class="text-xl font-bold">Materias Asignadas: </p>
                    <div v-if="hasSubjects" class="flex">
                        <table class="border-collapse border border-gray-300 mt-3 text-lg w-full">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-gray-300 px-2 py-1">Materia</th>
                                    <th class="border border-gray-300 px-2">Creditos</th>
                                    <th class="border border-gray-300 px-2">Ver</th>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="flex flex-col mx-auto mt-2">
                        <p class="text-lg mx-auto">Este curso no tiene materias asignadas.</p>
                        <div class="mx-auto mt-3">
                            <ShowBtn :routeName="'courseSubjects.create'" :model="course">+ Materia</ShowBtn>
                        </div>
                    </div>
                </div>

            </div>
        </Layout>
    </div>
</template>

<script>

import { ref } from 'vue'
import Layout from '../../Layouts/AppLayout'
import DeleteBtn from '../../Components/DeleteBtn'
import EditBtn from '../../Components/EditBtn'
import ShowBtn from '../../Components/ShowBtn'

export default {
    components: {
        Layout,
        ShowBtn,
        EditBtn,
        DeleteBtn,
    },
    props: {
        course: {
            required: true,
            type: Object,
        },
        studentsCount: {
            required: true,
            type: Number,
        }
    },
    setup(props) {
       
       const hasStudents = ref(false);
       const hasSubjects = ref(false);
       
       if (props.course.subjects.length > 0)
	   	hasSubjects.value = true;
       
       if (props.studentCount > 0)
        hasStudents.value = true;

        return {
            hasSubjects,
            hasStudents,
        }
    },
}
</script>