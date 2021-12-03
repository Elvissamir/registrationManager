<template>
  <div>
        <Layout>
            <Container :width="'w-3/12'">
                <div class="flex flex-row text-2xl">
                    <Title>Crear Seccion </Title>
                </div>

                <div class="flex mt-4">
                    <form class="w-full" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="name">Nombre: </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" v-model="form.name" />
                            <div class="text-red-500 text-sm italic" v-if="errors.name">{{ errors.name }}</div>
                        </div>

                        <button class="bg-gray-800 text-white font-bold py-2 px-4 mt-4 rounded focus:outline-none focus:shadow-outline" type="submit">Crear</button>
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
        errors: {
            required: true,
            type: Object,
        }
    },
    setup() {

        const form = ref({
            name: null,
        })

        function submit() {
            Inertia.post('/sections', form.value)
        }

        return { form, submit }
        },
}
</script>