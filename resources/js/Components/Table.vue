<script setup>
import BuyButton from "@/Components/BuyButton.vue";
import Rating from "@/Components/Rating.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

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
        default: []
    },

});
</script>

<template>
    <div class='overflow-x-auto w-full'>
        <table class="border-separate border border-slate-400 w-full">
            <thead>
            <tr>
                <th v-for="header in headers" class="border border-slate-300">{{ header }}</th>
                <th class="border border-slate-300"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in rows">
                <td class="border border-slate-300 text-center">{{ row.title }}</td>
                <td class="border border-slate-300 text-center">
                    <Rating :popularity="row.popularity"/>
                </td>
                <td class="border border-slate-300 text-center">${{ row.price }}</td>
                <td class="border border-slate-300 text-center">
                    <SecondaryButton @click="$emit('activityView',row.id)">ver</SecondaryButton>
                    <BuyButton @click="$emit('confirmBuy',row)">Comprar</BuyButton>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
