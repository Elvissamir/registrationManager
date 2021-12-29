<template>
  <div>
        <Layout>
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title>Materia: {{ subject.title }}</Title>
                    <div class="flex ml-auto">
                        <ShowBtn :routeName="'subjects.edit'" :model="subject">Editar</ShowBtn>
                    </div>
                </div>

                <div class="flex flex-col justify-between mt-3">
                    <p class="text-lg">Titulo: {{ subject.title }}</p>
                    <p class="text-lg">Creditos: {{ subject.credits }}</p>
                    <p class="text-lg">Creada: {{ subject.created_at }}</p>
                </div>

                <div class="flex flex-col mt-3">
                    <p class="text-xl font-bold">Profesores Asignados: </p>

                    <div v-if="hasAssignedTeachers">
                        <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                            <thead>
                                <tr class="text-center">
                                <th class="border border-gray-300 px-2 py-1">
                                    Nombre
                                    </th>
                                    <th class="border border-gray-300 px-2">
                                        Ver
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(teacher, index) in teachers.data" :key="index">
                                    <td class="border border-gray-300 px-2">
                                        {{ teacher.first_name }} {{ teacher.last_name }}
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        <ShowBtn :routeName="'teachers.show'" :model="teacher">Ver</ShowBtn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="flex mx-auto mt-2">
                        <p class="text-lg">La materia {{ subject.title }} no tiene profesores asignados.</p>
                    </div>
                </div>
            </Container>
        </Layout>
    </div>
</template>

<script>

import { ref } from 'vue'
import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
import { Link } from '@inertiajs/inertia-vue3'
import ShowBtn from '../../Components/ShowBtn'

export default {
    components: {
        Layout,
        Container, 
        Title,
        Link,
        ShowBtn,
    },
    props: {
        subject: {
            required: false,
            type: Object,
        },
        teachers: {
            required: true,
            type: Object,
        }
    },
    setup(props) {
        
        const hasAssignedTeachers = ref(false);
       
        if (props.teachers.data.length > 0)
	   	    hasAssignedTeachers.value = true;

        console.log(props);

        return {
            hasAssignedTeachers,
        }
    },
}
</script>