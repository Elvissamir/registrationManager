<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-6/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl font-black">Grado: {{ degree.title }} {{ degree.level }}</h1>
                    <div class="flex justify-between ml-auto">
                        <EditBtn class="mr-3" :routeName="'degrees.edit'" :model="degree">Editar</EditBtn>

                        <DeleteBtn v-if="!(courses.length > 0)" :routeName="'degrees.destroy'" :model="degree" :circle="false">
                            Eliminar
                        </DeleteBtn>
                    </div>
                </div>

                <div class="flex flex-col justify-between mt-3">
                    <div class="flex flex-col">
                        <p class="text-xl">Lista de Cursos del Grado {{ degree.title }} {{ degree.level }}</p>

                        <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
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
            </div>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import ShowBtn from '../../Components/ShowBtn'
import EditBtn from '../../Components/EditBtn'
import DeleteBtn from '../../Components/DeleteBtn'

export default {
    components: {
        Layout,
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