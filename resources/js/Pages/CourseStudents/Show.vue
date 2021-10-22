<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-8/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl">Curso</h1>
                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courseStudents.create', course.id)" method="get" as="button" type="button">
                        Agregar Alumno
                    </Link>
                </div>

                <div class="mt-4">
                    <p>Id curso: {{ course.id }}</p>
                    <p>Periodo: {{ course.period }}</p>
                    <div class="flex">
                        <p>Estado: </p>
                        <div v-if="course.status == 'active'">
                            Activo
                        </div>
                        <div v-else>
                            Finalizado
                        </div>
                    </div>
                </div>

                <div v-if="hasStudents">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Id</th>
                                <th class="border border-gray-300 px-2">Nombre completo</th>
                                <th class="border border-gray-300 px-2">Edad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(student, index) in students" :key="index">
                                <td class="border border-gray-300 px-2">
                                   {{ student.id }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <a class="text-blue-500 underline" :href="route('students.show', student.id)">
                                        {{ student.first_name }} {{ student.last_name }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ student.age }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg mx-auto"> No hay alumnos para mostrar por el momento.</p>

                    <Link class="mt-2 bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courseStudents.create', course,id)" method="get" as="button" type="button">
                        Agregar Alumno 
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