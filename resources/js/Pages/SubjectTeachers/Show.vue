<template>
  <div>
        <Layout>
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title>Materia: {{ subject.title }}</Title>
                    <Link class="ml-auto bg-gray-800 rounded-md font-bold text-white px-4" :href="route('subjectTeachers.create', subject.id)" method="get" as="button" type="button">
                        Asignar Profesor
                    </Link>
                </div>

                <div class="mt-4">
                    <p>Id materia: {{ subject.id }}</p>
                    <p>Credits: {{ subject.credits }}</p>
                </div>

                <div v-if="hasTeachers">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Id</th>
                                <th class="border border-gray-300 px-2">Nombre</th>
                                <th class="border border-gray-300 px-2">CI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(teacher, index) in teachers" :key="index">
                                <td class="border border-gray-300 px-2">
                                   {{ teacher.id }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <a class="text-blue-500 underline" :href="route('teachers.show', teacher.id)">
                                        {{ teacher.first_name }} {{ teacher.last_name }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-2">
                                    {{ teacher.ci }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="mt-3 text-lg mx-auto"> No hay profesores para mostrar por el momento.</p>

                    <Link class="mt-2 bg-gray-800 rounded-md font-bold text-white px-4" :href="route('courseSubjects.create', course,id)" method="get" as="button" type="button">
                        Asignar Profesor 
                    </Link>
                </div>

            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
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
            type: Object,
            required: true,
        },
        teachers: {
            type: Object,
            required: true,
        }
    },
    setup(props) {
        
        const hasTeachers = ref(true);

        if (props.teachers.length == 0)
            hasTeachers.value = false;

        return {
            hasTeachers,
        }
    },
}
</script>