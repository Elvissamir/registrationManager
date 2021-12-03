<template>
  <div>
        <Layout>
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title>Grado: {{ degree.title }} {{ degree.level }}</Title>
                    <div class="flex justify-between ml-auto">
                        <EditBtn class="mr-3" :routeName="'degrees.edit'" :model="degree">Editar</EditBtn>

                        <DeleteBtn v-if="!(courses.length > 0)" :routeName="'degrees.destroy'" :model="degree" :circle="false">
                            Eliminar
                        </DeleteBtn>
                    </div>
                </div>

                <div class="flex flex-col justify-between mt-4">
                    <div class="flex flex-col">
                        <p class="text-xl font-bold">Lista de Cursos del Grado {{ degree.title }} {{ degree.level }}</p>

                        <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-gray-300 px-2">Id</th>
                                    <th class="border border-gray-300 px-2">Periodo</th>
                                    <th class="border border-gray-300 px-2">Status</th>
                                    <th class="border border-gray-300 px-2">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(course, index) in courses" :key="index">
                                    <td class="border border-gray-300 px-2">
                                        {{ course.id }}
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                       {{ course.period }}
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1">
                                        <div v-if="course.status == 'active'">Activo</div>
                                        <div v-else>Finalizado</div>
                                    </td>
                                     <td class="border border-gray-300 px-2">
                                        <ShowBtn :routeName="'courses.show'" :model="course">Ver</ShowBtn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
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
import ShowBtn from '../../Components/ShowBtn'
import EditBtn from '../../Components/EditBtn'
import DeleteBtn from '../../Components/DeleteBtn'

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
        degree: {
            type: Object,
            required: true,
        },
        courses: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
       
    },
}
</script>