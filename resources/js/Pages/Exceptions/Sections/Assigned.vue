<template>
    <div>
        {{ exception }}
    </div>
</template>

<script>
export default {
    props: {
        exception: {
            type: String,
            required: true,
        }
    },
    setup() {
        
    },
}
</script>