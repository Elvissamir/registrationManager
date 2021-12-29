<template>
  <div>
        <Layout>
            <Container :width="'w-6/12'">
                    <div class="flex flex-row">
                        <Title>Secciones Disponibles:</Title>
                        <GetBtn :routeName="'sections.create'">Crear Seccion</GetBtn>
                    </div>

                    <div v-if="hasSections">
                        <table class="border-collapse border border-gray-300 mt-6 text-lg w-full">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-gray-300 px-2">Nombre</th>
                                    <th class="border border-gray-300 px-2">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(section, index) in sections" :key="index">
                                    <td class="border border-gray-300 px-2">
                                        {{ section.name }}
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1">
                                        <ShowBtn :routeName="'sections.show'" :model="section">Ver</ShowBtn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else>
                        <p class="mt-3 text-lg"> No hay secciones para mostrar por el momento.</p>
                        <GetBtn :routeName="'sections.create'">Crear Seccion</GetBtn>
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
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Container, 
        Title,
        GetBtn,
        ShowBtn,
    },
    props: {
        sections: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const hasSections = ref(true);

        if (props.sections.length == 0)
            hasSections.value = false;

        return {
            hasSections,
        }
    },
}
</script>