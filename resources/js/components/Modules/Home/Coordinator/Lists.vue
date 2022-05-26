<template>
    <div class="me-n2 ms-n2">
        <ul class="list-inline user-chat-nav text-end ms-4 mt-1 dropdown float-end">
            <!-- <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <button type="button"
                    class="btn btn-sm w-sm ms-n4 me-n3 ml-1 btn-secondary">Update</button>
            </li> -->
            <!-- <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <i class="bx bxs-check-circle text-success h4"
                    style="margin-left: -22px; position: absolute;"></i>
                <span class="text-muted font-size-11">Completed : 1</span>
            </li>
            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <i class="bx bxs-info-circle text-warning h4"
                    style="margin-left: -22px; position: absolute;"></i>
                <span class="text-muted font-size-11">Incomplete : 1</span>
            </li> -->
            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="subprogram"
                        id="programs" />
                    <label class="form-check-label font-size-11" for="programs">
                        Sub-Programs</label>
                </div>
            </li>
             <li class="list-inline-item d-non d-sm-inline-block " style="margin-right: 50px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="graphical"
                        id="graph" />
                    <label class="form-check-label font-size-11" for="graph">
                        Graphical View</label>
                </div>
            </li>
        </ul>
        <b-tabs pills nav-class="bg-light rounded" content-class="mt-3" small>
            <b-tab active title="Provinces">
                <b-card-text>
                    <div class="row ms-n1 me-n1">
                        <div class="col-md-3 g-0 ps-1">
                            <table class="table table-centered table-bordered table-nowrap">
                                <thead class="thead-light">
                                    <tr class="font-size-10">
                                        <th style="width: 100%;">Province</th>
                                    </tr>
                                </thead>
                                <tbody class="font-size-11">
                                    <tr v-for="(province,index) in orderedProvince" v-bind:key="index">
                                        <td class="fw-bold" @click="show(province)" style="width: 100%; cursor: pointer;">
                                            {{ province.province.name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%;" class="fw-bold font-size-12 text-success">Total</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8 g-0">
                            <table class="table table-centered table-bordered table-nowrap">
                                <thead class="thead-light">
                                    <tr class="font-size-10">
                                        <th style="width: 13%;" class="text-center"
                                            v-for="program in programs_list" v-bind:key="program.id">
                                            {{ program.name }}</th>
                                    </tr>
                                </thead>
                                <tbody class="font-size-11">
                                    <tr v-for="(province,index) in orderedProvince" v-bind:key="index">
                                        <td style="width: 13%;" v-if="index2 < counts" class="text-center" v-for="(count,index2) in province.count" v-bind:key="index2">
                                            {{ count }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 13%;" class="text-center font-size-12 text-success fw-bold" v-if="index3 < counts" v-for="(total,index3) in totals" v-bind:key="index3">{{ total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1 g-0 pe-1">
                            <table class="table table-centered table-bordered table-nowrap">
                                <thead class="thead-light">
                                    <tr class="font-size-10">
                                        <th style="width: 100%;" class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="font-size-11">
                                    <tr v-for="(province,index) in orderedProvince" v-bind:key="index">
                                        <td style="width: 13%;" class="fw-bold text-center text-success">{{ total(province.count) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%;" class="font-size-12 fw-bold  text-primary text-center">{{ sum }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <!-- <table class="table table-centered table-bordered table-nowrap mb-0">
                        <tfoot class="thead-light">
                            <tr class="font-size-12">
                                <th style="width: 80%;" colspan="3"></th>
                                <th class="text-center text-primary" style="width: 10%;">{{ units }}</th>
                                <th class="text-center text-primary" style="width: 10%;">{{ total }}</th>
                            </tr>
                        </tfoot>
                    </table> -->
                </b-card-text>
            </b-tab>
            <b-tab title="Programs">
                <b-card-text>
                    <div class="table-responsive">
                        <table class="table table-centered table-bordered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr class="font-size-10">
                                    <th style="width: 40%;">Name</th>
                                    <th style="width: 20%;" class="text-center">Undergraduate</th>
                                    <th style="width: 20%;" class="text-center">JLSS</th>
                                    <th style="width: 20%;" class="text-center">Total</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-centered table-bordered table-nowrap">
                            <tbody class="font-size-11">
                                <tr v-for="(program,index) in undergraduates" v-bind:key="index">
                                    <td style="width: 40%; cursor: pointer;" class="fw-bold">
                                        {{ program.name }}
                                    </td>
                                    <td style="width: 20%;" class="text-center">
                                        {{ (program.name == 'RA 10612') ? '-' : program.scholar_count }}
                                    </td>
                                    <td style="width: 20%;" class="text-center">{{ jlss[index].scholar_count }}</td>
                                    <td style="width: 20%;" class="fw-bold text-center">{{ program.scholar_count + jlss[index].scholar_count}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </b-card-text>
            </b-tab>
        </b-tabs>
        <Province ref="show"/>
    </div>
</template>

<script>
import Province from "../Coordinator/Modals/ViewProvince.vue";
export default {
    components : { Province },
    data(){
        return {
            currentUrl: window.location.origin,
            type_programs: [],
            provinces: [],
            totals: [],
            programs: { undergrad: []},
            subprogram: false,
            graphical: false,
        }
    },

    created() {
        this.fetch();
    },

    computed: {
        undergraduates : function(){
            if(this.subprogram == false){
                return this.programs.undergrad.filter(x => x.is_sub === 0);
            }else{
                return this.programs.undergrad;
            }
        },
        jlss : function(){
            if(this.subprogram == false){
                return this.programs.jlss.filter(x => x.is_sub === 0);
            }else{
                return this.programs.jlss;
            }
        },
        programs_list : function(){
            if(this.subprogram == false){
                return this.type_programs.filter(x => x.is_sub === 0);
            }else{
                return this.type_programs;
            }
        },
        counts : function(){
            return this.programs_list.length;
        },
        sum : function(){
            var sum = 0;
            for (var i = 0; i < this.totals.length; i++) {
                if(i < this.counts){
                    sum += this.totals[i];
                }
            }
            return sum;
        },
        orderedProvince : function () {
            return _.orderBy(this.provinces, 'total', 'desc')
        }
    },

    methods : {
        fetch() {
            axios.get(this.currentUrl + '/public/lists')
            .then(response => {
                this.provinces = response.data.provinces.provinces;
                this.type_programs = response.data.provinces.programs;
                this.programs = response.data.programs;
                this.totals = response.data.provinces.totals;
            })
            .catch(err => console.log(err));
        },

        total(data){   
            const firstHalf = data.slice(0, this.counts) 
            return firstHalf.reduce((a, b) => a + b, 0);
        },

        show(province){
            this.$bvModal.show("province");
            this.$refs.show.set(province);
        }
    }
}
</script>