<template>
    <div class="card">
        <div class="card-body" style="height: 440px;">
            <div>
                <table class="table table-centered table-bordered table-sm table-nowrap mb-1">
                    <thead class="thead-light">
                        <tr class="font-size-10">
                            <th style="width: 50%;" class="text-center">Undergraduate</th>
                            <th style="width: 50%;" class="text-center">JLSS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 50%;" class="text-center">{{types['Undergraduate']}}</td>
                            <td style="width: 50%;" class="text-center">{{types['JLSS']}}</td>
                        </tr>
                    </tbody>
                </table>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="(list,index) in main" v-bind:key="index">
                        <div class="py-1">
                            <h5 class="font-size-12">
                                {{ list.name }} <span class="float-end">{{list.scholar_count}} <span class="text-muted">({{ set(list.scholar_count) }}%)</span></span>
                            </h5>
                            <div class="progress animated-progess progress-sm">
                                <div class="progress-bar" :class="colors[index]" role="progressbar" :style="'width: '+set(list.scholar_count)+'%'"
                                    aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </li>
                </ul>
                <p @click="program" class="text-center text-muted mt-1 mb-n1" style="cursor: pointer;">Show All</p>
            </div>
        </div>
        <Program ref="program"/>
    </div>
</template>
<script>
    import Program from "../Modals/Program.vue";
    export default {
        props: ['types','main','colors'],
        components : { Program },
        data() {
            return {
                currentUrl: window.location.origin,
            }
        },

        methods: {
            program(){
                this.$refs.program.set(this.types['lists'],this.types['total']);
                this.$bvModal.show("program");
            },

            set(data){
                return parseFloat((data / this.types['total']) * 100).toFixed(2);
            },
        }
    }

</script>
