<template>
  <div>
        <Layout>
            <div class="flex flex-col m-auto p-6 my-8 bg-white w-6/12">
                <div class="flex flex-row">
                    <h1 class="text-2xl">Lista de Materias: </h1>
                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route('subjects.create')" method="get" as="button" type="button">
                        Crear Materia
                    </Link>
                </div>

                <div v-if="hasSubjects">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Id</th>
                                <th class="border border-gray-300 px-2">Titulo</th>
                                <th class="border border-gray-300 px-2">Creditos</th>
                                <th class="border border-gray-300 px-2">Asignar Profesor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(subject, index) in subjects" :key="index">
                                <td class="border border-gray-300 px-2">{{ subject.id }}</td>
                                <td class="border border-gray-300 px-2">
                                    <a class="text-blue-500 underline" :href="route('subjects.show', subject.id)">{{ subject.title }}</a>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ subject.credits }}
                                </td>
                                 <td class="h-12 justify-center items-center border border-gray-300 px-2">
                                    <Link class="text-sm bg-gray-800 rounded-md font-bold text-white py-1 px-4" :href="route('subjectTeachers.create', subject.id)" method="get" as="button" type="button">
                                        Asignar Profesor
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg"> No hay materias para mostrar por el momento.</p>

                    <Link class="mt-2" :href="route('subjects.create')" method="get" as="button" type="button">
                        Crear Materia
                    </Link>
                </div>

            </div>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Layout,
        Link,
    },
    props: {
        subjects: {
            required: true,
            type: Object,
        }
    },
    setup(props) {

        const hasSubjects = ref(true);

        if (props.subjects.length == 0) {
            hasSubjects.value = false;
        }

        return {
            hasSubjects,
        }
    },
}
</script>