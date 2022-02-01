<template>
  <div>
        <Layout :title="'Editar Grado'">
            <Container :width="'w-4/12'">
                <div class="flex flex-row">
                    <Title>Editar Grado {{ degree.title }} {{ degree.level }} </Title>
                </div>

                <div class="flex mt-4">
                    <form class="w-full" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="titulo">Titulo: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="title" v-model="form.title" />
                            <div class="text-red-500 text-sm italic" v-if="errors.title">{{ errors.title }}</div>
                        </div>

                        <div class="flex flex-col mt-3">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="level">Nivel: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" id="level" v-model="form.level" />
                            <div class="text-red-500 text-sm italic" v-if="errors.level">{{ errors.level }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">Guardar</button>
                    </form>
                </div>
            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Container,
        Title,
    },
    props: {
        degree: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const form = ref({
            title: props.degree.title,
            level: props.degree.level,
        })

        function submit() {
            
            const url = `/degrees/${props.degree.id}`;
            Inertia.put(url, form.value)
        }

        return { form, submit }
        },
}
</script>