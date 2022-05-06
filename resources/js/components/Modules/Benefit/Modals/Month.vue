<template>
    <b-modal @ok="save($event)" id="newmonth" title="New Month" ok-title="Generate" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center mb-0">
                        <div class="avatar-sm mx-auto mb-2">
                            <div class="avatar-title bg-light rounded-circle text-primary h3">
                                <i class="bx bxs-calendar-week"></i>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h5 class="text-primary">{{ month }}</h5>
                                <p class="text-muted font-size-12 mb-0"> 
                                    Click Generate to create a batch for this month.
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                month : new Date().toLocaleString('en-us', { month: 'long' }),
                batch: '',
                id: ''

            }
        },

        methods: {
            set(data){
                this.id = data;
            },

            save(){
                axios.post(this.currentUrl + '/request/benefit/month/generate',{
                    'id' : this.id
                })
                .then(response => {
                    this.$emit('status', true);
                    this.batch = response.data;
                })
                .catch(err => console.log(err));
            }
        }
    }

</script>
