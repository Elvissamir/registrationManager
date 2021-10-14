<template>
    <div>
        <layout>
            <h1>Los estudiantes</h1>
            <p>{{ students }}</p>
            <div v-for="(student, index) in students" :key="index">
                <div>
                    <p>{{ student.id }}</p>
                    <p>{{ student.first_name }}</p>
                </div>
            </div>
        </layout>
    </div>
</template>

<script>

import Layout from '../../Layouts/AppLayout'

export default {
    components: {
        Layout,
    },
    props: {
        students: {
            type: Object,
            required: true,
        }
    },
    setup(props) {
        console.log(props.students);
    },
}
</script>