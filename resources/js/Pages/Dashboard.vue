<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import {onMounted, reactive, ref} from 'vue'
import httpPostRequest from "../Services/HttpPostRequest"
import InputMessageError from "@/Components/InputMessageError.vue";
import AlertMessageError from "@/Components/AlertMessageError.vue";
import Paginator from "@/Components/Paginator.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import BuyButton from "@/Components/BuyButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import httpGetRequest from "@/Services/HttpGetRequest";
import Rating from "@/Components/Rating.vue";
import InputLabel from "@/Components/InputLabel.vue";
import AlertMessageSuccess from "@/Components/AlertMessageSuccess.vue";

onMounted(() => {
    console.log(`The initial count is`)
})

const formData = useForm({
    date: '',
    number_people: '',
})

const state = reactive({activities: [], errors: [], error: null, activity: null, success: null})
const modalView = ref(false);
const modalViewConfirm = ref(false);
const headers = ['Titulo', 'Popularidad', 'Precio Total']

const getActivities = async (url) => {

    state.errors = []
    state.error = null
    state.success = null

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
const clearSuccess = () => {
    state.success = null
}

const getNow = () => {
    const today = new Date();
    const year = today.getFullYear()

    let month = today.getMonth() + 1
    month = (month <= 9) ? '0' + month : month

    let day = today.getDate()
    day = (day <= 9) ? '0' + day : day

    return year + '-' + month + '-' + day;
}

const closeModal = () => {
    modalView.value = false;
};
const closeModalConfirm = () => {
    modalViewConfirm.value = false;
};

const activityView = async (id) => {
    state.error = null
    let response = await httpGetRequest(route('activities.get', id))
    if (response.status === 200) {
        state.activity = response.data
        state.activity.number_people = formData.number_people
        modalView.value = true
    } else {
        state.error = response.error
    }
}

const confirmBuy = (row) => {
    state.success = null
    modalViewConfirm.value = true
    state.activity = row
}

const buyActivity = async (activity) => {
    state.success = null
    state.error = null
    let response = await httpPostRequest(route('bookings.create'), {
        activity_id: activity.id,
        number_people: formData.number_people,
        price: activity.price,
        activity_date: formData.date
    })
    if (response.status === 201) {
        state.success = response.data.message
    } else {
        state.error = response.error
    }
    closeModal()
    closeModalConfirm()
}

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Actividades</h2>
        </template>
        <Modal :show="modalView" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ state.activity.title }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ state.activity.description }}
                </p>
                <Rating class="mt-3" :popularity="state.activity.popularity"/>
                <div class="mt-2">
                    <InputLabel>Personas: {{ state.activity.number_people }}</InputLabel>
                </div>
                <div class="mt-2">
                    <InputLabel> Precio: ${{ state.activity.price }}</InputLabel>
                </div>
                <div class="mt-6">
                </div>
                <div class="mt-6 flex justify-end">
                    <DangerButton @click="closeModal">Cerrar</DangerButton>
                    <BuyButton @click="buyActivity(state.activity)">Comprar</BuyButton>
                </div>
            </div>
        </Modal>
        <Modal :show="modalViewConfirm" @close="closeModalConfirm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Esta seguro que desea realizar la reservacion?
                </h2>
                <div class="mt-6 flex justify-end">
                    <DangerButton @click="closeModalConfirm">Cancelar</DangerButton>
                    <BuyButton @click="buyActivity(state.activity)">Comprar</BuyButton>
                </div>
            </div>
        </Modal>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <AlertMessageSuccess v-if="state.success" :message="state.success" @clearSuccess="clearSuccess"/>
                    <AlertMessageError v-if="state.error" :error="state.error" @clearError="clearError"/>

                    <form class="mt-6 space-y-6" @submit.prevent="submit">

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label for="date" class="block font-medium text-sm text-gray-700">
                                    <span>Fecha</span>
                                </label>
                                <input type="date" v-model="formData.date"
                                       :min="getNow()"
                                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                       required>
                                <InputMessageError v-if="state.errors.date" :errors="state.errors.date"/>
                            </div>
                            <div>
                                <label for="number_people"
                                       class="block font-medium text-sm text-gray-700">
                                    <span> N° Personas</span>
                                </label>
                                <input type="number" min="1" v-model="formData.number_people"
                                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                       required>
                                <InputMessageError v-if="state.errors.number_people"
                                                   :errors="state.errors.number_people"/>
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <Table v-if="state.activities.data"
                       :headers="headers"
                       :rows="state.activities.data"
                       @activityView="activityView"
                       @confirmBuy="confirmBuy"
                />
                <Paginator
                    :next_page_url="state.activities.next_page_url"
                    :prev_page_url="state.activities.prev_page_url"
                    :function_filter="getActivities"/>
                <span v-if="state.activities.to">{{ state.activities.to }} de {{ state.activities.total }}</span>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
