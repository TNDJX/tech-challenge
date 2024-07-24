<template>
    <div>
        <div class="max-w-lg mx-auto">
            <form @submit.prevent="storeJournal()">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" class="form-control" v-model="journal.date">
                    <input-error :errors="errors.date" />
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" class="form-control" v-model="journal.content">
                    </textarea>
                    <input-error :errors="errors.content" />
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-default">Clear</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import InputError from './InputError.vue';

export default {
    name: 'JournalForm',
    components: {InputError},
    props: ['client'],
    emits: ['journal-created'],
    data() {
        return {
            journal: {
                date: null,
                content: null,
            },
            errors: {}
        }
    },

    methods: {
        storeJournal() {
            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then((data) => {
                    this.$emit('journal-created', data.data.data);
                }).catch((error) => {
                const response = error.response;
                if (response.status === 422) {
                    this.errors = response.data.errors || {};
                }
            });
        }
    }
}
</script>
