<template>
  <div>
         <Layout :title="'Editar Alumno'">
            <Container :width="'w-4/12'">
                <div class="flex flex-row text-2xl">
                    <Title>Editar Alumno: {{ student.first_name }} {{ student.last_name }}</Title>
                </div>

                <div class="flex mt-4">
                    <form class="w-full" @submit.prevent="submit">
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="first_name">Nombre </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="first_name" v-model="form.first_name" />
                            <div class="text-red-500 text-sm italic" v-if="errors.first_name">{{ errors.first_name }}</div>
                        </div>

                        <div class="flex flex-col mt-3">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="last_name">Apellido </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="last_name" v-model="form.last_name" />
                            <div class="text-red-500 text-sm italic" v-if="errors.last_name">{{ errors.last_name }}</div>
                        </div>

                        <div class="flex flex-col mt-3">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="age">Edad </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="age" v-model="form.age" />
                            <div class="text-red-500 text-sm italic" v-if="errors.age">{{ errors.age }}</div>
                        </div>

                        <div class="flex flex-col mt-3">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="phone_mobile">Telefono (Celular) </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="phone_mobile" v-model="form.phone_mobile" />
                            <div class="text-red-500 text-sm italic" v-if="errors.phone_mobile">{{ errors.phone_mobile }}</div>
                        </div>

                        <div class="flex flex-col mt-3">
                            <label class="block text-gray-700 text-base font-bold mb-2" for="phone_house">Telefono (Fijo) </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="phone_house" v-model="form.phone_house" />
                            <div class="text-red-500 text-sm italic" v-if="errors.phone_house">{{ errors.phone_house }}</div>
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
        student: {
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
            first_name: props.student.first_name,
            last_name: props.student.last_name,
            age: props.student.age,
            phone_mobile: props.student.phone_mobile,
            phone_house: props.student.phone_house,
        })

        function submit() {
            
            const url = `/students/${props.student.id}`;

            Inertia.put(url, form.value)
        }

        return { form, submit }
        },
}
</script>