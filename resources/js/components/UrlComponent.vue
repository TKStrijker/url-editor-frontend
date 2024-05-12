<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div>
                    <a class="btn btn-primary" @click="this.editing = !this.editing">{{ $t('models misc.edit') }}</a>
                    <a class="btn btn-danger" @click="destroy()">
                        {{ $t('models misc.delete') }}
                    </a>
                    <div v-if="hasErrors" class="text-danger">
                        {{ $t('models misc.unforeseen error')}}
                    </div>
                </div>
                <div v-show="isEditing">
                    <url-form-component
                        :url="this.url"
                        :authenticated_user_id="this.authenticated_user_id"
                    >
                    </url-form-component>
                </div>
                <div v-show="!isEditing">
                    <div>
                        {{ $t('urls.original url') }}: {{ url.original_url }}
                    </div>
                    <div>
                        {{ $t('urls.shortened url') }}: 
                        <a class="btn btn-link" :href="this.url.redirect_url">
                            {{ url.shortened_url }}
                        </a>
                    </div>
                    <div>
                        {{ $t('urls.redirect url') }}: {{ url.redirect_url }}
                    </div>
                    <div>
                        {{ $t('models misc.created at') }}: {{ url.created_at }}
                    </div>
                    <div>
                        {{ $t('models misc.updated at') }}: {{ url.updated_at }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
import { Url } from '../models/Url';
import axios from 'axios';

export default defineComponent({
    props: {
        url: {
            type: Object as ()=> Url
        },
        authenticated_user_id: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            editing: false,
            hasErrors: false,
        }
    },
    computed: {
        isEditing() {
            return this.editing
        }
    },
    methods: {
        destroy() {
            axios.delete('http://127.0.0.1:8001/api/url/' + this.url.id, {
                data: {
                    user_id: this.url.user_id
                }
            })
                .then(response => {
                    this.$emit('destroyed', response.data);
                    this.hasErrors = false;
                })
                .catch(error => {
                    this.hasErrors = true;
                })
        }
    }
})
</script>