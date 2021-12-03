<template>
    <div class="flex justify-center items-center min-h-screen">
        <div class="flex flex-col p-10 bg-white rounded-3xl shadow-2xl my-14" :class="[ width ]">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        width: {
            required: true,
            type: String,
        }
    },
    setup() {
        
    },
}
</script>