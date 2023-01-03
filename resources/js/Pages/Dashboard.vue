<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import {ref, onMounted, reactive} from 'vue'
import httpPostRequest from "../Services/HttpPostRequest"
import InputMessageError from "@/Components/InputMessageError.vue";
import AlertMessageError from "@/Components/AlertMessageError.vue";
import Paginator from "@/Components/Paginator.vue";
import Table from "@/Components/Table.vue";

onMounted(() => {
    console.log(`The initial count is`)
})

const formData = useForm({
    date: '',
    number_people: '',
})

const state = reactive({activities: [], errors: [], error: null})

const headers = ['Titulo', 'Popularidad', 'Precio Total']
const getActivities = async (url) => {
    state.errors = []
    let response = await httpPostRequest(url, formData)
    if (response.status === 200) {
        state.activities = response.data
    } else if (response.status === 422) {
        state.errors = response.errors
    } else {
        state.error = response.error
    }
}

const clearError = () => {
    state.error = null
}

const mapData = () => {

    if (!state.activities.data){
        return []
    }

    return state.activities.data.map((data)=> {
        return [
            data.title,
            data.popularity,
            `$${data.price}`
        ]
    })
}

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <AlertMessageError v-if="state.error" :error="state.error" @clearError="clearError"/>

                    <form class="mt-6 space-y-6" @submit.prevent="submit">

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label for="date" class="block font-medium text-sm text-gray-700">
                                    <span>Fecha</span>
                                </label>
                                <input type="date" v-model="formData.date"
                                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                       required>
                                <InputMessageError v-if="state.errors.date" :errors="state.errors.date" />
                            </div>
                            <div>
                                <label for="number_people"
                                       class="block font-medium text-sm text-gray-700">
                                    <span> N° Personas</span>
                                </label>
                                <input type="number" v-model="formData.number_people"
                                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                       required>
                                <InputMessageError v-if="state.errors.number_people" :errors="state.errors.number_people" />
                            </div>
                            <div>
                                <button
                                    @click="getActivities(route('activities.filter'))"
                                    class="inline-flex items-center px-4 mt-7 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Filtrar
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
              <Table v-if="state.activities.data" :headers="headers" :rows="mapData()"/>
                <Paginator
                    :next_page_url="state.activities.next_page_url"
                    :prev_page_url="state.activities.prev_page_url"
                    :function_filter="getActivities"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
