<template>
  <div>
        <Layout>
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title>Profesores Registrados:</Title>
                    <div class="flex ml-auto">
                        <GetBtn :routeName="'teachers.create'">Registrar Profesor</GetBtn>
                    </div>
                </div>

                <div v-if="hasTeachers">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Nombre</th>
                                <th class="border border-gray-300 px-2">Ver</th>
                                <th class="border border-gray-300 px-2">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(teacher, index) in teachers.data" :key="index">
                                <td class="border border-gray-300 px-2 py-1">
                                   {{ teacher.first_name }} {{ teacher.last_name }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <ShowBtn :routeName="'teachers.show'" :model="teacher">Ver</ShowBtn>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <ShowBtn :routeName="'teachers.edit'" :model="teacher">Editar</ShowBtn>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- PAGINATION --> 
                    <Pagination :model="teachers"></Pagination>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg"> No hay profesores para mostrar por el momento.</p>

                    <Link class="mt-2" :href="route('teachers.create')" method="get" as="button" type="button">
                        Registrar Profesor
                    </Link>
                </div>

            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
import GetBtn from '../../Components/GetBtn.vue'
import ShowBtn from '../../Components/ShowBtn.vue'
import Pagination from '../../Components/Pagination.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Container,
        Title,
        Link,
        GetBtn,
        ShowBtn,
        Pagination,
    },
    props: {
        teachers: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const hasTeachers = ref(true);

        if (props.teachers.length == 0)
            hasTeachers.value = false;

        return {
            hasTeachers,
        }
    },
}
</script>