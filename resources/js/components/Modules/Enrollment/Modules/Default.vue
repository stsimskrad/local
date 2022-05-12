<template>
     <div>
       <div class="card-body" :style="{ height: (height) + 'px' }">
           default
       </div>
     </div>
</template>

<script>
    import simplebar from "simplebar-vue";
    export default {
        components: { simplebar },
        props: ['height','lists','selected','user'],
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                attachments: []
            }
        },
    }
</script>
