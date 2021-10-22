<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-6/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl">Alumno: {{ student.first_name }} {{ student.last_name }}</h1>
                    <Link class="ml-auto bg-gray-800 font-bold rounded-md text-white px-4" :href="route('students.edit', student.id)" method="get" as="button" type="button">
                        Editar
                    </Link>
                </div>

                <div class="flex flex-col justify-between mt-3">
                    <p>Id: {{ student.id }}</p>
                    <p>Nombre Completo: {{ student.first_name }} {{ student.last_name }} </p>
                    <p>Edad: {{ student.age }}</p>
                    <p>Telefono (Celular): {{ student.phone_mobile }}</p>
                    <p>Telefono (Casa): {{ student.phone_house }}</p>
                    <p>Fecha de Registro: {{ student.created_at }}</p>
                </div>
            </div>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Layout,
        Link,
    },
    props: {
        student: {
            required: false,
            type: Object,
        }
    },
    setup(props) {
       
    },
}
</script>