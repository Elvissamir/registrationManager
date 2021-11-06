<template>
  <div>
        <Layout>
            <div class="flex flex-col mx-auto mt-8 w-6/12">
                <div class="w-full bg-white p-6">
                    <div class="flex flex-row">
                        <h1 class="text-2xl">Grados Disponibles:</h1>
                       
                        <GetBtn :routeName="'degrees.create'">Crear Grado</GetBtn>
                    </div>

                    <div v-if="hasDegrees">
                        <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-gray-300 px-2">Titulo</th>
                                    <th class="border border-gray-300 px-2">Nivel</th>
                                    <th class="border border-gray-300 px-2">Ver</th>
                                    <th class="border border-gray-300 px-2">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(degree, index) in degrees" :key="index">
                                    <td class="border border-gray-300 px-2">
                                        {{ degree.title }}
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        {{ degree.level }}
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1">
                                        <ShowBtn :routeName="'degrees.show'" :model="degree">Ver</ShowBtn>
                                    </td>
                                       <td class="border border-gray-300 px-2 py-1">
                                        <EditBtn :routeName="'degrees.edit'" :model="degree">Editar</EditBtn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else>
                        <p class="mt-3 text-lg"> No hay grados para mostrar por el momento.</p>
                        <GetBtn :routeName="'degrees.create'">Crear Grado</GetBtn>
                    </div>
                </div>
            </div>
        </Layout>
    </div>
</template>


<script>

import GetBtn from '../../Components/GetBtn.vue'
import EditBtn from '../../Components/EditBtn.vue'
import ShowBtn from '../../Components/ShowBtn.vue'
import Layout from '../../Layouts/AppLayout'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        GetBtn,
        ShowBtn,
        EditBtn,
    },
    props: {
        degrees: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const hasDegrees = ref(true);

        if (props.degrees.length == 0)
            hasDegrees.value = false;

        return {
            hasDegrees,
        }
    },
}
</script>