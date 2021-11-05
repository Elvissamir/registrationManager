<template>
  <div>
        <Layout>
            <div class="flex flex-col mx-auto mt-8 w-6/12">
                <div class="w-full bg-white p-6">
                    <div class="flex flex-row">
                        <h1 class="text-2xl">Secciones Disponibles:</h1>
                       
                        <GetBtn :routeName="'sections.create'">Crear Seccion</GetBtn>
                    </div>

                    <div v-if="hasSections">
                        <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
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
                </div>
            </div>
        </Layout>
    </div>
</template>


<script>

import GetBtn from '../../Components/GetBtn.vue'
import ShowBtn from '../../Components/ShowBtn.vue'
import Layout from '../../Layouts/AppLayout'
import { ref } from 'vue'

export default {
    components: {
        Layout,
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