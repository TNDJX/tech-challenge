<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                        <tr>
                            <th class="text-gray-600 pr-3">Name</th>
                            <td>{{ client.name }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Email</th>
                            <td>{{ client.email }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Phone</th>
                            <td>{{ client.phone }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Address</th>
                            <td>{{ client.address }}<br />{{ client.postcode + ' ' + client.city }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn"
                            :class="{'btn-primary': currentTab === 'bookings', 'btn-default': currentTab !== 'bookings'}"
                            @click="switchTab('bookings')">Bookings
                    </button>
                    <button class="btn"
                            :class="{'btn-primary': currentTab === 'journals', 'btn-default': currentTab !== 'journals'}"
                            @click="switchTab('journals')">Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab === 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>
                    <select v-model="filter" class="ring-2 my-2">
                        <option v-for="option in filterOptions" :key="option">{{ option }}</option>
                    </select>
                    <template v-if="filteredBookings.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="booking in filteredBookings" :key="booking.id">
                                <td>{{ formatDate(booking.start, booking.end) }}</td>
                                <td>{{ booking.notes }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab === 'journals'">
                    <h3 class="mb-3">List of client journals</h3>

                    <p>(BONUS) TODO: implement this feature</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            filter: 'All bookings',
            filterOptions: ['All bookings', 'Future bookings only', 'Past bookings only']
        }
    },

    computed: {
        filteredBookings() {
            if (!this.client.bookings) return [];

            const now = new Date();
            if (this.filter === 'Future bookings only') {
                return this.client.bookings.filter(booking => new Date(booking.start) > now);
            } else if (this.filter === 'Past bookings only') {
                return this.client.bookings.filter(booking => new Date(booking.start) < now);
            }
            return this.client.bookings;
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        formatDate(start, end) {
            const startDate = new Date(start);
            const endDate = new Date(end);

            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            const formattedStartDate = new Intl.DateTimeFormat('en-GB', options).format(startDate);

            const timeOptions = { hour: '2-digit', minute: '2-digit' };
            const formattedEndDate = new Intl.DateTimeFormat('en-GB', timeOptions).format(endDate);

            return `${formattedStartDate} to ${formattedEndDate}`;
        }
    }
}
</script>

