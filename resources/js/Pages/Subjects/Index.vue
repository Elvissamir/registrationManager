<template>
  <div>
        <Layout :title="'Materias'">
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title class="text-2xl">Lista de Materias: </Title>
                    <GetBtn class="ml-auto" :routeName="'subjects.create'">Crear Materia</GetBtn>
                </div>

                <div v-if="hasSubjects">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                               <th class="border border-gray-300 px-2 py-1">
                                    <OrderByBtn :name="'Titulo'" :option="'title'" :url="'/subjects?orderBy=title'" :order="order"></OrderByBtn>
                                </th>
                                <th class="border border-gray-300 px-2">
                                    <OrderByBtn :name="'Creditos'" :option="'credits'" :url="'/subjects?orderBy=credits'" :order="order"></OrderByBtn>
                                </th>
                                <th class="border border-gray-300 px-2">Asignar Profesor</th>
                                <th class="border border-gray-300 px-2">Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(subject, index) in subjects.data" :key="index">
                                <td class="border border-gray-300 px-2">
                                    {{ subject.title }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ subject.credits }}
                                </td>
                                 <td class="h-12 justify-center items-center border border-gray-300 px-2">
                                    <Link class="text-sm bg-gray-800 rounded-md font-bold text-white py-1 px-4" :href="route('subjectTeachers.create', subject.id)" method="get" as="button" type="button">
                                        Asignar Profesor
                                    </Link>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <ShowBtn :routeName="'subjects.show'" :model="subject">Ver</ShowBtn>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination :model="subjects"></Pagination>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg"> No hay materias para mostrar por el momento.</p>

                    <Link class="mt-2" :href="route('subjects.create')" method="get" as="button" type="button">
                        Crear Materia
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
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import OrderByBtn from '../../Components/OrderByBtn.vue'
import Pagination from '../../Components/Pagination.vue'
import ShowBtn from '../../Components/ShowBtn.vue'
import GetBtn from '../../Components/GetBtn.vue'

export default {
    components: {
        Layout,
        Container, 
        Title,
        Link,
        OrderByBtn,
        ShowBtn,
        GetBtn,
        Pagination,
    },
    props: {
        subjects: {
            required: true,
            type: Object,
        },
        order: {
            required: true,
            type: String
        }
    },
    setup(props) {
        const hasSubjects = ref(true);

        if (props.subjects.length == 0) {
            hasSubjects.value = false;
        }

        return {
            hasSubjects,
        }
    },
}
</script>