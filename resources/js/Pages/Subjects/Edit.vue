<template>
  <div>
         <Layout :title="'Editar Materia'">
            <Container :width="'w-4/12'">
                <div class="flex flex-row text-2xl">
                    <Title>Editar Materia: {{ subject.title }}</Title>
                </div>

                <div class="flex mt-4">
                    <form class="w-full" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Titulo</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="first_name" v-model="form.title" />
                            <div class="text-red-500 text-xs italic" v-if="errors.title">{{ errors.title }}</div>
                        </div>

                        <div class="flex flex-col mt-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="credits">Creditos</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" id="credits" v-model="form.credits" />
                            <div class="text-red-500 text-xs italic" v-if="errors.credits">{{ errors.credits }}</div>
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
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Container, 
        Title,
        Link,
    },
    props: {
        subject: {
            required: true,
            type: Object,
        },
        errors: {
            required: true,
            type: Object,
        }
    },
    setup(props) {

        const form = ref({
            title: props.subject.title,
            credits: props.subject.credits,
        })

        function submit() {
            
            const url = `/subjects/${props.subject.id}`;

            Inertia.put(url, form.value)
        }

        return { form, submit }
        },
}
</script>