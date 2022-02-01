<template>
  <div>
        <Layout :title="'Grados'">
            <Container :width="'w-6/12'">
                    <div class="flex flex-row">
                        <Title>Grados Disponibles:</Title>
                        <GetBtn :routeName="'degrees.create'">Crear Grado</GetBtn>
                    </div>

                    <div v-if="hasDegrees">
                        <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
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
            </Container>
        </Layout>
    </div>
</template>


<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
import GetBtn from '../../Components/GetBtn.vue'
import EditBtn from '../../Components/EditBtn.vue'
import ShowBtn from '../../Components/ShowBtn.vue'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Container,
        Title,
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