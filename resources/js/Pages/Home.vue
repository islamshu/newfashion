<script setup>
import Layout from "../Layouts/Layout.vue";
defineOptions({
    layout: Layout,
});
defineProps({
    user: String,
});
</script>
<template>
    <Head title=" - الرئيسية" />
    <h1 class="px-4 py-2 rounded">Hello {{ user }}</h1>
</template>
