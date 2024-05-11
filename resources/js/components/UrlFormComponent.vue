<template>
    <div>
        <div class="form-group">
            <label for="original_url">
                {{ $t('urls.original url') }}
            </label>
            <input type="text" id="original_url" class="form-control" v-model="form.original_url">
            <div v-if="errors.original_url" class="text-danger">
                {{ errors.original_url }}
            </div>
        </div>
        <div class="form-group">
            <label for="shortened_url">
                {{ $t('urls.shortened url') }}
            </label>
            <input type="text" id="shortened_url" class="form-control" v-model="form.shortened_url">
            <div v-if="errors.shortened_url" class="text-danger">
                {{ errors.shortened_url }}
            </div>
        </div>
        <div class="form-group">
            <label for="redirect_url">
                {{ $t('urls.redirect url') }}
            </label>
            <input type="text" id="redirect_url" class="form-control" v-model="form.redirect_url">
            <div v-if="errors.redirect_url" class="text-danger">
                {{ errors.redirect_url }}
            </div>
        </div>
        <button class="btn btn-primary" @click="save()">{{ $t('models misc.save') }}</button>
    </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
import { Url } from '../models/Url';
import axios from 'axios';

export default defineComponent({
    props: {
        url: {
            type: Object as ()=> Url,
        },
        authenticated_user_id: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            form: Object as ()=> Url,
            errors: {}
        }
    },
    mounted() {
        if (this.url) {
            this.form = this.url;
        }
    },
    methods: {
        save() {
            /**
             * Check for a id to determine if a model exists, 
             * if so update, otherwise store
             */ 
            if (this.form.id) {
                axios.put('http://127.0.0.1:8001/api/url/' + this.form.id, {
                    user_id: this.form.user_id,
                    original_url: this.form.original_url,
                    shortened_url: this.form.shortened_url,
                    redirect_url: this.form.redirect_url,
                })
                    .catch(error => {
                        this.setErrors(error);
                    })
            } else {
                axios.post('http://127.0.0.1:8001/api/url/', {
                    user_id: this.authenticated_user_id,
                    original_url: this.form.original_url,
                    shortened_url: this.form.shortened_url,
                    redirect_url: this.form.redirect_url,
                })
                    .then(response => {
                        this.$emit('saved', response.data as Url);

                        /**
                         * Clear the form and errors after a successful save.
                         */
                        this.form = {} as Url
                        this.errors = {}
                    })
                    .catch(error => {
                        this.setErrors(error)
                    });
            }
        },
        setErrors(error) {
            /**
             * Assign the errors to a var for ease of use.
             */
            let e = error.response.data.errors;
            
            this.errors.original_url = e.original_url[0];
            this.errors.shortened_url = e.shortened_url[0];
            this.errors.redirect_url = e.redirect_url[0];
        }
    }
})
</script>