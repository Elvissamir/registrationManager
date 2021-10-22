<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-6/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl">Profesor: {{ teacher.first_name }} {{ teacher.last_name }}</h1>
                    <Link class="hidden ml-auto bg-gray-800 font-bold rounded-md text-white px-4" :href="route('teachers.edit', teacher.id)" method="get" as="button" type="button">
                        Editar
                    </Link>
                </div>

                <div class="flex flex-col justify-between mt-3">
                    <p>Id: {{ teacher.id }}</p>
                    <p>Nombre Completo: {{ teacher.first_name }} {{ teacher.last_name }} </p>
                    <p>Edad: {{ teacher.age }}</p>
                    <p>CI: {{ teacher.ci }}</p>
                    <p>Telefono (Celular): {{ teacher.phone_mobile }}</p>
                    <p>Telefono (Casa): {{ teacher.phone_house }}</p>
                    <p>Fecha de Registro: {{ teacher.created_at }}</p>
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
        teacher: {
            required: false,
            type: Object,
        }
    },
    setup(props) {
       
    },
}
</script>