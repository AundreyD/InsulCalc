<script setup>
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8 container">
            <div>
                <h1>InsulCalc</h1>
                <p>Enter your attic dimensions and the desired insulation R-value to calculate the required insulation volume.</p>
                <div v-for="dimension in dimensions">
                    <div key="dimension">
                        <v-text-field :label="dimension.name + ' (ft)'" type="number" v-model="dimension.value">
                        </v-text-field>
                    </div>
                    </div>
                <select v-model="rValue">
                <option value="3">R-3</option>
                <option value="6">R-6</option>
                <option value="9">R-9</option>
                <option value="12">R-12</option>
                </select>
                <button @click="calculate">Calculate</button>
                <p v-if="volume">The required insulation volume is: {{ volume }}</p>
            </div>
         </div>
    </div>
</template>
<script>

export default {
  data() {
    return {
      dimensions: [
      {
        name: "Length",
        value: 0,
      },
      {
        name: "Width",
        value: 0,
      },
      {
        name: "Height",
        value: 0,
      }],
      rValue: 3,
      volume: null,
    };
  },
  methods: {
    calculate(length, width, height, rValue) {
        const url = 'http://localhost:8000/api/calculate';
        const data = {
        length: this.dimensions[0].value,
        width: this.dimensions[1].value,
        height: this.dimensions[2].value,
        rValue: this.rValue,
    };

    return axios.post(url, data).then(response => {
        this.volume = response.data;
        return this.volume;
    }).catch(error => {
        console.log(error);
    });
    }
    },
        };
</script>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
.container {
    background-color: whitesmoke;
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
