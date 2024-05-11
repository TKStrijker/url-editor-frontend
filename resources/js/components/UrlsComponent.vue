<template>
    <div>
        <div class="accordion" id="newUrl">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#newUrlTarget" aria-expanded="false" aria-controls="newUrlTarget">
                        {{ $t('urls.new url') }}
                    </button>
                </h2>
                <div id="newUrlTarget" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <url-form-component
                            :authenticated_user_id="this.authenticated_user_id"
                            @saved="addUrl"
                        >
                        </url-form-component>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="urlsEmpty">
            <div class="card">
                <div class="card-body">
                    {{ $t('urls.no urls')}}
                </div>
            </div>
        </div>
        <div v-for="url in urlList">
            <url-component
                :url="url"
                :authenticated_user_id="this.authenticated_user_id"
                @destroyed="removeUrl"
            ></url-component>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { Url } from '../models/Url';

export default defineComponent({
    props: {
        urls: {
            type: Object as ()=> Url[],
            required: true
        },
        authenticated_user_id: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            urlList: this.urls
        }
    },
    computed: {
        urlsEmpty() {
            return this.urls.length === 0;
        }
    },
    methods: {
        addUrl(newUrl) {
            this.urlList.push(newUrl as Url);
        },
        removeUrl(id) {
            /**
             * Get the index of the destroyed url, 
             * then remove it from the rendered list.
             */
            let index = this.urlList.findIndex(url => {
                return url.id === id
            })

            this.urlList.splice(index, 1)
        }
    },
})
</script>