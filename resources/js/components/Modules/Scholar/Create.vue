<template>
    <div>
        <form @submit.prevent="create">
            <div class="row">
                <div class="col-md-3" style="margin-top: 10px; margin-bottom: 15px;">
                    <myUpload field="img" @crop-success="cropSuccess" v-model="photo.show" :width="500" :height="500" :params="params" :headers="headers" lang-type="en" img-format="png">
                    </myUpload>
                    <div @click="toggleShow" class="fuzone" style="width: 100%; height: auto;">
                        <div v-if="photo.url != ''">
                            <img :src="photo.url" style="width: 100%; height: auto;">
                        </div>
                        <div v-else class="fu-text" @click="toggleShow">
                            <span>
                                <i class="fa fa-picture"></i> 
                                Click here to upload<br> 
                                <span v-if="errors.avatar" style="color: red; font-size: 12px; margin-top: -20px;">
                                    ({{ errors.avatar[0] }})
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 customform"  style="margin-top: 20px; margin-bottom: 15px; overflow-y: scroll;" :style="{ height: (height -60) + 'px' }">
                    <div class="row">
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Learner's Reference No.: <span v-if="errors.lrn" class="haveerror">({{ errors.lrn[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.lrn" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>SPAS ID No.: <span v-if="errors.spas_id" class="haveerror">({{ errors.spas_id[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.spas_id" style="text-transform: uppercase;">
                            </div>
                        </div> 

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Category: <span v-if="errors.category_id" class="haveerror">({{ errors.category_id[0] }})</span></label>
                                <multiselect 
                                    v-model="user.category_id" 
                                    :options="categories"
                                    :show-labels="false"
                                    label="name" track-by="id" 
                                    :allow-empty="false"
                                    placeholder="Select Category">
                                </multiselect>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status: <span v-if="errors.status_id" class="haveerror">({{ errors.status_id[0] }})</span></label>
                                <multiselect 
                                    v-model="user.status_id" 
                                    :options="statuses" 
                                    
                                    :show-labels="false"
                                    label="name" track-by="id" 
                                    :allow-empty="false"
                                    placeholder="Select Status">
                                </multiselect>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2"><hr></div>
                        <div class="col-md-12"> 
                            <button  style="margin-top: -55px;" class="btn btn-sm w-md btn-primary pull-right" type="button">Profile</button>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lastname: <span v-if="errors.lastname" class="haveerror">({{ errors.lastname[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.lastname" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Firstname: <span v-if="errors.firstname" class="haveerror">({{ errors.firstname[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.firstname" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Middlename: <span v-if="errors.middlename" class="haveerror">({{ errors.middlename[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.middlename" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Ext: <span v-if="errors.suffix" class="haveerror">({{ errors.suffix[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.suffix" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birthday: <span v-if="errors.birthday" class="haveerror">({{ errors.birthday[0] }})</span></label>
                                <input type="date" class="form-control" v-model="user.birthday" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email: <span v-if="errors.email" class="haveerror">({{ errors.email[0] }})</span></label>
                                <input type="email" class="form-control" v-model="user.email" style="text-transform: lowercase;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mobile No.: <span v-if="errors.mobile" class="haveerror">({{ errors.mobile[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.mobile">
                            </div>
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <div class="row" style="margin-top: 10px; margin-bottom: -10px;">
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="customRadio1" class="custom-control-input" checked="checked" value="Male" v-model="user.gender">
                                        <label class="custom-control-label" for="customRadio1">Male</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="customRadio2" class="custom-control-input" checked="checked" value="Female" v-model="user.gender">
                                        <label class="custom-control-label" for="customRadio2">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 "><hr></div>
                        <div class="col-md-12"> 
                            <button  style="margin-top: -55px;" class="btn btn-sm w-md btn-primary pull-right" type="button">Parents</button>
                        </div>

                        <div class="col-md-6" style="margin-top: -10px;">
                            <div class="form-group">
                                <label>Mother: <span v-if="errors.mother" class="haveerror">({{ errors.mother[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.mother" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top: -10px;">
                            <div class="form-group">
                                <label>Father: <span v-if="errors.father" class="haveerror">({{ errors.father[0] }})</span></label>
                                <input type="text" class="form-control" v-model="user.father" style="text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="col-md-12 mt-2"><hr></div>
                        <div class="col-md-12"> 
                            <button  style="margin-top: -55px;" class="btn btn-sm w-md btn-primary pull-right" type="button">Address</button>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" style="margin-top: -10px;">
                                <label>Region: <span v-if="errors.region" class="haveerror">({{( errors.region[0] )}})</span></label>
                                    <multiselect 
                                    @input="onChangeRegion(user.region.code)"
                                    v-model="user.region" 
                                    :options="regions"
                                    :allow-empty="false"
                                    :show-labels="false"
                                    label="region" track-by="code"
                                    placeholder="Select Region">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-top: -10px;">
                                <label>Province: <span v-if="errors.province" class="haveerror">({{( errors.province[0] )}})</span></label>
                                    <multiselect 
                                    @input="onChangeProvince(user.province.code)"
                                    v-model="user.province" 
                                    :options="provinces"
                                    :allow-empty="false"
                                    :show-labels="false"
                                    label="name" track-by="code"
                                    placeholder="Select Province">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-top: -10px;">
                                <label>Municipality: <span v-if="errors.municipality" class="haveerror">({{( errors.municipality[0] )}})</span></label>
                                    <multiselect 
                                    v-model="user.municipality" 
                                    :options="municipalities"
                                    :allow-empty="false"
                                    :show-labels="false"
                                    label="name" track-by="code"
                                    placeholder="Select Municipality">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-top: -10px;">
                                <label>Address: <span v-if="errors.address" class="haveerror">({{( errors.address[0] )}})</span></label>
                                <input type="text" class="form-control" v-model="user.address">
                            </div>
                        </div>

                        <div class="col-md-12 mt-2"><hr></div>
                        <div class="col-md-12"> 
                            <button  style="margin-top: -55px;" class="btn btn-sm w-md btn-primary pull-right" type="button">School</button>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" style="margin-top: -10px;">
                                <label>School: <span v-if="errors.school_id" class="haveerror">({{ errors.school_id[0] }})</span></label>
                                <multiselect v-model="user.school" id="ajax" label="name" track-by="id"
                                    placeholder="Search School" open-direction="bottom" :options="schools"
                                    :searchable="true" 
                                    :allow-empty="false"
                                    :show-labels="false"
                                    @search-change="asyncSchool">
                                </multiselect> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="margin-top: -10px;">
                                <label>Course: <span v-if="errors.course_id" class="haveerror">({{ errors.course_id[0] }})</span></label>
                                <multiselect v-model="user.course" id="ajax" label="name" track-by="id"
                                    placeholder="Search Course" open-direction="bottom" :options="courses"
                                    :searchable="true" 
                                    :allow-empty="false"
                                    :show-labels="false"
                                    @search-change="asyncCourse">
                                </multiselect> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="margin-top: -10px;">
                                <label>Level: <span v-if="errors.level_id" class="haveerror">({{ errors.level_id[0] }})</span></label>
                                <multiselect v-model="user.level" id="ajax" label="name" track-by="id"
                                    placeholder="Search Level" open-direction="bottom" :options="levels"
                                    :searchable="true" 
                                    :allow-empty="false"
                                    :show-labels="false">
                                </multiselect> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit"  class="mt-4 mb-4 float-right btn w-lg btn-success  waves-effect waves-light">Save Scholar</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <loading :active.sync="isLoading" :can-cancel="true" loader="dots" background-color="black" :is-full-page="fullPage"></loading>
    </div>
</template>


<script>
    import Loading from 'vue-loading-overlay';
    import Multiselect from 'vue-multiselect';
    import myUpload from 'vue-image-crop-upload/upload-2.vue';
    export default {
        props: ['regions','dropdowns'],
        data(){
            return {
                currentUrl: window.location.origin,
                windowHeight: window.innerHeight,
                windowWidth: window.innerWidth,
                errors: [], 
                user: {
                    id: '',
                    email: '',
                    firstname: '',
                    lastname: '',
                    middlename: '',
                    suffix: '',
                    gender: '', 
                    mobile: '',
                    birthday: '',
                    avatar: '',
                    father: '',
                    mother: '',
                    lrn: '',
                    spas: '',
                    category_id: '',
                    status_id: '',
                    awarded_year: '',
                    spas_id: '',
                    social: '',
                    address: '',
                    region: '',
                    province: '',
                    municipality: '',
                    school: '',
                    course: '',
                    level: '',
                },
                attachments: [],
                photo: {show: false,url: '',signature: ''},
                params: {token: '123456798',name: 'avatar'},
                headers: {smail: '*_~'},
                editable: false,
                options: [
                    {
                        language: 'Ongoing',
                        libs: []
                    },
                    {
                        language: '',
                        libs: []
                    }
                ],
                isLoading: false,
                fullPage: true,
                provinces: [],
                municipalities: [],
                schools: [],
                courses: []
            }
        },
         
        computed:{
            statuses : function() {
                return this.dropdowns.filter(x => x.classification === 'Status');
            },
            categories : function() {
                return this.dropdowns.filter(x => x.classification === 'Category');
            },
            levels : function() {
                return this.dropdowns.filter(x => x.classification === 'Level');
            },
            height: function() {
                return this.windowHeight - 170;
            },
            width: function() {
                return this.windowWidth;
            },
        },
        
        methods : {
            create(){
                this.isLoading = true;
                let data = new FormData();

                if(this.attachments.length > 0){
                    for (var i = this.attachments.length - 1; i >= 0; i--) {
                        data.append('files[]', this.attachments[i]);
                    }
                }else{
                    if(this.editable == false){
                        data.append('files[]', []);
                    }
                }

                data.append('id', (this.user.id != undefined) ? this.user.id : '');
                data.append('email', (this.user.email != undefined) ? this.user.email : '');
                data.append('firstname', (this.user.firstname != undefined) ? this.user.firstname : '');
                data.append('lastname', (this.user.lastname != undefined) ? this.user.lastname : '');
                data.append('middlename', (this.user.middlename != undefined) ? this.user.middlename : '');
                data.append('suffix', (this.user.suffix != undefined) ? this.user.suffix : '');
                data.append('gender', (this.user.gender != undefined) ? this.user.gender : '');
                data.append('mobile', (this.user.mobile != undefined) ? this.user.mobile : '');
                data.append('birthday', (this.user.birthday != undefined) ? this.user.birthday : '');
                // data.append('social', (this.user.social != undefined) ? this.user.social : '');
                data.append('father', (this.user.father != undefined) ? this.user.father : '');
                data.append('mother', (this.user.mother != undefined) ? this.user.mother : '');
                data.append('img', (this.photo.url != undefined) ? this.photo.url : '');
                data.append('lrn', (this.user.lrn != undefined) ? (this.user.lrn == 'N/A') ? '' : this.user.lrn : '');
                data.append('applicant_id', (this.user.lrn != undefined) ? (this.user.lrn == 'N/A') ? '' : this.user.lrn : '');
                data.append('spas_id', (this.user.spas_id != undefined) ? this.user.spas_id : '');
                // data.append('awarded_year', (this.user.awarded_year != undefined) ? this.user.awarded_year : '');
                data.append('course_id', (this.user.course != undefined) ? this.user.course.id : '');
                data.append('school_id', (this.user.school != undefined) ? this.user.school.id : '');
                data.append('level_id', (this.user.level != undefined) ? this.user.level.id : '');
                data.append('category_id', (this.user.category_id != undefined) ? this.user.category_id.id : '');
                data.append('status_id', (this.user.status_id != undefined) ? this.user.status_id.id : '');
                data.append('region_code', (this.user.region != undefined) ? this.user.region.code : '');
                data.append('province_code', (this.user.province != undefined) ? this.user.province.code : '');
                data.append('municipality_code', (this.user.municipality != undefined) ? this.user.municipality.code : '');
                data.append('address', (this.user.address != undefined) ? this.user.address : '');
                data.append('editable', 'new');

                axios.post(this.currentUrl + '/request/scholar/store', data)
                .then(response => {
                    this.clear();
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    this.isLoading = false;
                    this.$router.push({ name: 'scholar/lists'})
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
            },

            edit(user,editable){
                this.errors = [];
                this.user = user;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                this.errors = [];
                this.user = {};
            },

            toggleShow() {
                this.photo.show = !this.photo.show;
            },

            cropSuccess(imgDataUrl, field) {
                this.photo.url = imgDataUrl;
            },

            fetchProvince($id){
                axios.get(this.currentUrl + '/lists/provinces/'+$id)
                .then(response => {
                    this.provinces = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchMunicipality($id){
                axios.get(this.currentUrl + '/lists/municipalities/'+$id)
                .then(response => {
                    this.municipalities = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChangeRegion($id) {
                this.fetchProvince($id);
                this.province = '';
                this.municipality = '';
            },

            onChangeProvince($id) {
                this.fetchMunicipality($id);
                this.municipality = '';
            },

            asyncSchool(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/search/schools', {
                        word: value,
                    })
                    .then(response => {
                        this.schools = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            asyncCourse(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/search/courses', {
                        word: value,
                    })
                    .then(response => {
                        this.courses = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

        }, components: { Multiselect, myUpload, Loading }
    }
</script>