<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-6/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl">Materia: {{ subject.title }}</h1>
                    <Link class="ml-auto bg-gray-800 font-bold rounded-md text-white px-4" :href="route('subjects.create')" method="get" as="button" type="button">
                        Crear Materia
                    </Link>
                </div>

                <div class="flex justify-between mt-3">
                    <p>Id: {{ subject.id }}</p>
                    <p>titulo: {{ subject.title }}</p>
                    <p>creditos: {{ subject.credits }}</p>
                    <p>creada: {{ subject.created_at }}</p>
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
        subject: {
            required: false,
            type: Object,
        }
    },
    setup(props) {
       
    },
}
</script>