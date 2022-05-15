<template>
    <section class="section" id="team">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card bg-soft bg-info border shadow-none mb-3">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ml-2 ms-2 mr-2">
                                    <div class="avatar-title rounded bg-transparent"><i class="bx bx-news h4 mt-1"></i>
                                    </div>
                                </div>
                                <div class="overflow-hidden mr-auto align-self-center">
                                    <h5 class="fw-bold font-size-12 mt-1 fw-bold">Announcements</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-sm-6" v-for="post in posts" v-bind:key="post.id">
                            <div class="blog-box mb-4 mb-xl-0">
                                <div class="position-relative">
                                    <img :src="currentUrl+'/images/'+post.attachment" alt
                                        class="rounded img-fluid mx-auto d-block" />
                                    <div :class="'badge bg-'+post.type.color+' blog-badge font-size-11'">{{ post.type.name }}</div>
                                </div>
                                <div class="mt-4 text-muted font-size-12">
                                    <p class="mb-2"><i class="bx bx-calendar me-1"></i> {{ post.created_at }}</p>
                                    <h6 class="mb-3 fw-bold">{{ post.title }}</h6>
                                    <p>{{ post.content.substring(0,50) }}..</p>

                                    <div>
                                        <a href="#">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-soft bg-info border shadow-none mb-3">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ml-2 ms-2 mr-2">
                                    <div class="avatar-title rounded bg-transparent"><i
                                            class="bx bx-info-circle h4 mt-1"></i></div>
                                </div>
                                <div class="overflow-hidden mr-auto align-self-center">
                                    <h5 class="fw-bold font-size-12 mt-1 fw-bold">Quick Links</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="card border">
                        <a href="https://www.science-scholarships.ph" target="_blank">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-light rounded-circle font-size-20 text-primary">
                                            <i class="bx bxs-window-alt"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3 mt-1">
                                        <p class="fw-bold text-truncated mb-0">S&T E-Scholarship </p>
                                        <h5 class="mb-0 text-muted font-size-12">Web Application System</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card border mt-n3">
                        <a href="https://www.sei.dost.gov.ph/images/stsd/ugradFAQ.pdf" target="_blank">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-light rounded-circle font-size-20 text-warning">
                                            <i class="bx bxs-user-voice"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3 mt-1">
                                        <p class="fw-bold text-truncated text-warning mb-0">Frequently Asked
                                            Questions </p>
                                        <h5 class="mb-0 text-muted font-size-12">DOST - Science Education
                                            Institute</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card border  mt-n3">
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle font-size-20 text-primary">
                                        <img src="images/sei.png" alt="" class="ms-1" style="width: 25px; height 25px;">
                                    </div>
                                </div>
                                <div class="ms-3 mt-1">
                                    <a href="https://www.sei.dost.gov.ph/" target="_blank">
                                        <p class="fw-bold text-truncated mb-0">Science Education Institute </p>
                                    </a>
                                    <a href="https://www.dost.gov.ph/" target="_blank">
                                        <h5 class="mb-0 text-muted font-size-12">Department of Science and Technology
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group bg-light rounded mb-3">
                        <input type="email" placeholder="Enter Email address" aria-label="Recipient's username" aria-describedby="button-addon2" class="form-control bg-transparent border-0">
                        <div class="input-group-append">
                            <button type="button" id="button-addon2" class="btn btn-primary rounded">
                                <i class="bx bx-envelope"></i>
                            </button>
                        </div>
                    </div>

                    <!-- <div class="card border mt-n3">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center mt-0 mb-0">
                                <div class="avatar-sm me-2">
                                    <a href="https://www.sei.dost.gov.ph/" target="_blank">
                                    <img src="images/sei.png" alt="" class="avatar-sm">
                                    </a>
                                </div>
                                <div class="avatar-sm">
                                    <a href="https://www.dost.gov.ph/" target="_blank">
                                    <img src="images/dost.png" alt="" class="avatar-sm">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> -->


                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                posts: []
            }
        },

        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get(this.currentUrl + '/public/posts')
                    .then(response => {
                        this.posts = response.data.data;
                    })
                    .catch(err => console.log(err));
            },
        }
    }

</script>
