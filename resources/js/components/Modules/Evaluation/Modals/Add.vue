<template>
    <b-modal @ok="save($event)" id="failedSubject" title="Failed Subject" ok-title="Add" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3 mt-2">
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <input type="text" class="form-control text-center" placeholder="Search Subject" v-model="subject" @keyup="search()" />

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
                subject: '',
                subjects: [],
                lists: [],
                selected: [],
                selectedDefault: ''
            }
        },

        methods: {
            save() {
                this.$emit('add', this.selectedDefault);
                Vue.$toast.success('<strong>Add Successful</strong>', {
                    position: 'bottom-right'
                });
                this.$bvModal.hide("failedSubject");
                // let index = this.subjects.findIndex(x => x.code === this.selectedDefault.code);
                // this.subjects.splice(index,1);
                this.selectedDefault = '';
                this.lists = [];
                this.subject = '';
            },

            set(subjects) {
                subjects.forEach((subject) => {
                    if(subject.is_failed){
                        this.subjects.push(subject);
                    }
                });
            },

            search() {
                if (this.subjects.length > 0) {
                    this.lists = this.subjects.filter(x => x.code === this.subject);
                }
            },

            log(arg){
                this.to = arg;
            }
        }
    }
</script>
