<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-6/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl">Curso</h1>
                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courseSubjects.create', course.id)" method="get" as="button" type="button">
                        Agregar Materia
                    </Link>
                </div>

                <div class="mt-4">
                    <p>Id curso: {{ course.id }}</p>
                    <p>Periodo: {{ course.period }}</p>
                    <div class="flex">
                        <p>Estado: </p>
                        <div v-if="course.status == 'active'">
                            Activo
                        </div>
                        <div v-else>
                            Finalizado
                        </div>
                    </div>
                </div>

                <div v-if="hasSubjects">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Id</th>
                                <th class="border border-gray-300 px-2">Titulo</th>
                                <th class="border border-gray-300 px-2">Creditos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(subject, index) in subjects" :key="index">
                                <td class="border border-gray-300 px-2">
                                   {{ subject.id }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <a class="text-blue-500 underline" :href="route('subjects.show', subject.id)">
                                        {{ subject.title }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ subject.credits }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg mx-auto"> No hay materias para mostrar por el momento.</p>

                    <Link class="mt-2 bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courseSubjects.create', course,id)" method="get" as="button" type="button">
                        Agregar Materia 
                    </Link>
                </div>

            </div>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

export default {
    components: {
        Layout,
        Link,
    },
    props: {
        course: {
            type: Object,
            required: true,
        },
        subjects: {
            type: Object,
            required: true,
        }
    },
    setup(props) {

        const hasSubjects = ref(true);

        if (props.subjects.length == 0)
            hasSubjects.value = false;

        return {
            hasSubjects,
        }
    },
}
</script>