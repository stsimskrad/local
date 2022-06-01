<template>
    <b-modal id="mailing" hide-footer title="Mailing Service" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-1 fw-bold">WAITING..</p>
                </div>
            </div>
        </blockquote>
    </b-modal>
</template>
<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
            }
        },
    }
</script>





