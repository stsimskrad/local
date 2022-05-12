<template>
    <b-modal @ok="save($event)" id="switch" title="Switch Subject" ok-title="Save" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3 mt-2">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group mb-2 currency-value">
                                    <input type="text" class="form-control" v-model="from.code" disabled />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control text-end" v-model="to.code" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <input type="text" class="form-control text-center" v-model="subject" @keyup="search()" />
                        
                                <b-form-group class="mt-3 font-size-14">
                                    <b-form-radio  @change="log" v-for="list in lists" v-bind:key="list.id" v-model="selectedDefault" class="mb-1" :value="list" plain>
                                        <span class="font-size-13">{{ list.code }} {{(list.is_lab == 0) ? '(Lec)' : '(Lab)' }}</span>
                                        <span class="font-size-6"> / </span>
                                        <span class="font-size-13">{{ list.subject }}</span>
                                    </b-form-radio>
                                </b-form-group>
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
                errors: [],
                from: '',
                to: '',
                subject: '',
                subjects: [],
                lists: [],
                selectedDefault: '',
                scholar_id: ''
            }
        },

        methods: {
            save(evt) {
                evt.preventDefault();
                
                axios.post(this.currentUrl + '/request/evaluation/enrollment/switch',{
                   to: this.to,
                   from: this.from,
                   scholar_id: this.scholar_id
                })
                .then(response => {
                    Vue.$toast.success('<strong>Switched Successful</strong>', {
                        position: 'bottom-right'
                    });
                    this.from = '';
                    this.to = '';
                    this.scholar_id = '';
                    this.subject = '';
                    this.subjects = [];
                    this.lists = [];
                    this.$emit('status', response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }else{
                        Vue.$toast.error('<strong>Contact Administrator</strong>', {
                            position: 'bottom-right'
                        });
                    }
                });
            },

            set(subjects, selected, user) {
                this.from = selected;
                this.subjects = subjects;
                this.scholar_id = user;
            },

            search() {
                if (this.subject.length > 0) {
                    this.lists = this.subjects.filter(x => x.code === this.subject);
                }
            },

            log(arg){
                this.to = arg;
            }
        }
    }
</script>
