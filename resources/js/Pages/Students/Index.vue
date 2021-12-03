<template>
  <div>
        <Layout>
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title>Alumnos Registrados:</Title>
                    <GetBtn :routeName="'students.create'">Registrar Alumno</GetBtn>
                </div>

                <div v-if="hasStudents">
                    <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2 py-1">
                                    <Link class="border border-gray-500 px-4 rounded-md text-lg font-bold" :class="[(order == 'name')? 'bg-green-200 text-gray-400 border-none' : '']" 
                                          :href="'/students?orderBy=name'" method="get" as="button" type="button">Nombre</Link>
                                </th>
                                <th class="border border-gray-300 px-2">
                                    <Link class="border border-gray-500 px-4 rounded-md text-lg font-bold" :class="[(order == 'registration')? 'bg-green-200 text-gray-400 border-none' : '']"
                                          :href="'/students?orderBy=registration'" method="get" as="button" type="button">Registro</Link>
                                </th>
                                <th class="border border-gray-300 px-2">Ver</th>
                                <th class="border border-gray-300 px-2">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(student, index) in students.data" :key="index">
                                <td class="border border-gray-300 px-2 py-1">
                                    <p>{{ student.first_name }} {{ student.last_name }}</p>
                                </td>
                                 <td class="border border-gray-300 px-2">
                                     {{ student.created_at }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <ShowBtn :routeName="'students.show'" :model="student">Ver</ShowBtn>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <EditBtn :routeName="'students.edit'" :model="student">Editar</EditBtn>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- PAGINATION --> 
                    <Pagination :model="students"></Pagination>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg"> No hay alumnos para mostrar por el momento.</p>
                    <div class="mx-auto mt-3">
                        <GetBtn :routeName="'students.create'">Registrar Alumno</GetBtn>
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
import { Link } from '@inertiajs/inertia-vue3'
import Pagination from '../../Components/Pagination.vue'
import GetBtn from '../../Components/GetBtn'
import EditBtn from '../../Components/EditBtn'
import ShowBtn from '../../Components/ShowBtn'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Container, 
        Title,
        Pagination,
        GetBtn,
        ShowBtn,
        EditBtn,
        Link,
    },
    props: {
        students: {
            type: Object,
            required: true,
        },
        order: {
            type: String,
            required: true,
        }
    },
    setup(props) {

        console.log(props.students);

        const hasStudents = ref(true);

        if (props.students.length == 0)
            hasStudents.value = false;
            
        return {
            hasStudents,
        }
    },
}
</script>