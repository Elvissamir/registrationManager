<template>
  <div>
        <Layout>
            <Container :width="'w-6/12'">
                <div class="flex flex-row">
                    <Title>Profesor: {{ teacher.first_name }} {{ teacher.last_name }}</Title>
                    <ShowBtn :routeName="'teachers.edit'" :model="teacher">Editar</ShowBtn>
                </div>

                <div class="flex flex-col justify-between mt-3">
                    <p>Nombre Completo: {{ teacher.first_name }} {{ teacher.last_name }} </p>
                    <p>Edad: {{ teacher.age }}</p>
                    <p>CI: {{ teacher.ci }}</p>
                    <p>Telefono (Celular): {{ teacher.phone_mobile }}</p>
                    <p>Telefono (Casa): {{ teacher.phone_house }}</p>
                    <p>Fecha de Registro: {{ teacher.created_at }}</p>
                </div>

                <div v-if="hasSubjects">
                    <table class="border-collapse border border-gray-300 mt-4 text-lg w-full">
                        <thead>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2">Titulo</th>
                                <th class="border border-gray-300 px-2">Creditos</th>
                                <th class="border border-gray-300 px-2">Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(subject, index) in teacher.subjects" :key="index">
                                <td class="border border-gray-300 px-2 py-1">
                                   {{ subject.title }}
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                   {{ subject.credits }}
                                </td>
                                <td class="border border-gray-300 px-2">
                                    <ShowBtn :routeName="'subjects.show'" :model="subject">Ver</ShowBtn>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="mx-auto mt-3 text-center">{{ teacher.first_name }} {{ teacher.last_name }} aun no ha sido asignado a ningun curso.</p>
                    <div class="flex mx-auto">

                    </div>
                </div>

            </Container>
        </Layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'
import Container from '../../Components/Container'
import Title from '../../Components/Title'
import { ref } from 'vue'
import ShowBtn from '../../Components/ShowBtn.vue'

export default {
    components: {
        Layout,
        Container,
        Title,
        ShowBtn,
    },
    props: {
        teacher: {
            required: false,
            type: Object,
        }
    },
    setup(props) {
       
       const hasSubjects = ref(false);

       if (props.teacher.subjects.length > 0)
        hasSubjects.value = true;

        return {
            hasSubjects,
        }
    },
}
</script>