<script setup>
import BuyButton from "@/Components/BuyButton.vue";
const props = defineProps({
    headers: {
        type: Array,
        default: [
            'Header 1',
            'Header 2',
            'Header 3',
            'Header 4',
        ]
    },
    rows: {
        type: Array,
        default: [
           [
               'row 1',
               'row 2',
               'row 3',
               'row 4',
           ]
        ]
    },

});
</script>

<template>
    <table class="border-separate border border-slate-400 w-full">
        <thead>
        <tr>
            <th v-for="header in headers" class="border border-slate-300">{{header}}</th>
            <th class="border border-slate-300"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="row in rows">
            <td class="border border-slate-300" v-for="colum in row">{{ colum }}</td>
            <td class="border border-slate-300" ><BuyButton>Comprar</BuyButton></td>
        </tr>
        </tbody>
    </table>
</template>
