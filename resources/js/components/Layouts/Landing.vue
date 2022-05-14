<template>
    <div>
        <nav class="navbar navbar-expand-lg navigation fixed-top sticky" id="navbar">
            <div class="container">
                <a class="navbar-logo" href="/">
                    <img src="images/logo-dark.png" alt height="19" class="logo logo-dark" />
                    <img src="images/logo-light.png" alt height="19" class="logo logo-light" />
                </a>

                <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-toggle="collapse"
                    data-target="#topnav-menu-content" @click="toggleMenu()">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav ms-auto" id="topnav-menu" v-scroll-spy-active="{ selector: 'a.nav-link' }">
                        <li class="nav-item">
                            <a class="nav-link" v-scroll-to="'#home'" href="javascript: void(0);">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" v-scroll-to="'#about'" href="javascript: void(0);">About</a>
                        </li>
                    </ul>

                    <div class="ms-lg-2">
                        <a href="/login" class="btn btn-outline-success w-xs">Sign in</a>
                    </div>
                </div>
            </div>
        </nav>
        <div v-scroll-spy>
            <section class="section hero-section bg-ico-hero" id="home" style="margin-bottom: -230px;">
                <div class="bg-overlay bg-primary"></div>
                <div class="container">
                    <div class="row" style="margin-top: -120px;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-1 me-n2">
                                    <img src="images/sei.png" alt="" class="avatar-sm">
                                </div>
                                <div class="col-10 ms-n4">
                                    <div class="text-white-50">
                                        <h5 class="text-white fw-semibold mb-0 hero-title" style="font-size: 21px;">
                                            DOST-IX Scholarship Program </h5>
                                        <p class="font-size-14">Science & Technology Scholarship Information Management
                                            System</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="text-white-50 mt-n1 float-end text-end">
                                <h5 class="text-white fw-semibold mb-0 hero-title" style="font-size: 27px;">DOST-IX</h5>
                                <p class="font-size-14">Department Of Science And Technology - IX</p>
                            </div>
                        </div> -->
                    </div>

                </div>
            </section>


            <section class="section pt-4 bg-white" id="about">
                <div class="container">
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <div class="card border mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div class="me-3">
                                                    <p class="text-muted mb-2">Total Scholars</p>
                                                    <h5 class="mb-0">981</h5>
                                                </div>
                                                <div class="avatar-sm ms-auto">
                                                    <div
                                                        class="avatar-title bg-light rounded-circle font-size-20 text-success">
                                                        <i class="bx bx-group"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card border mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div class="me-3">
                                                    <p class="text-muted mb-2">Total Graduates</p>
                                                    <h5 class="mb-0">651</h5>
                                                </div>
                                                <div class="avatar-sm ms-auto">
                                                    <div
                                                        class="avatar-title bg-light rounded-circle font-size-20 text-info">
                                                        <i class="bx bxs-graduation"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card border mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div class="me-3">
                                                    <p class="text-muted mb-2">Ongoing Scholars</p>
                                                    <h5 class="mb-0">168</h5>
                                                </div>
                                                <div class="avatar-sm ms-auto">
                                                    <div
                                                        class="avatar-title bg-light rounded-circle font-size-20 text-primary">
                                                        <i class="bx bx-user-circle"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <Lists />
                </div>
            </section>

            <footer class="landing-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <img src="images/logo-light.png" alt height="20" />
                            </div>
                            <p class="mb-2">{{ new Date().getFullYear() }} © DOST-IX</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
    import {
        Carousel,
        Slide
    } from "vue-carousel";
    import Lists from "../Modules/Home/Coordinator/Lists.vue";

    export default {
        components: {
            Carousel,
            Slide , Lists
        },
        data() {
            return {
                start: "",
                end: "",
                interval: "",
                days: "",
                minutes: "",
                hours: "",
                seconds: "",
                starttime: "Nov 5, 2020 15:37:25",
                endtime: "Dec 31, 2021 16:37:25"
            };
        },
        created() {
            window.addEventListener("scroll", this.windowScroll);
        },
        destroyed() {
            window.removeEventListener("scroll", this.windowScroll);
        },
        mounted() {
            this.start = new Date(this.starttime).getTime();
            this.end = new Date(this.endtime).getTime();
            // Update the count down every 1 second
            this.timerCount(this.start, this.end);
            this.interval = setInterval(() => {
                this.timerCount(this.start, this.end);
            }, 1000);
        },
        methods: {
            timerCount: function (start, end) {
                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = start - now;
                var passTime = end - now;

                if (distance < 0 && passTime < 0) {
                    clearInterval(this.interval);
                    return;
                } else if (distance < 0 && passTime > 0) {
                    this.calcTime(passTime);
                } else if (distance > 0 && passTime > 0) {
                    this.calcTime(distance);
                }
            },
            calcTime: function (dist) {
                // Time calculations for days, hours, minutes and seconds
                this.days = Math.floor(dist / (1000 * 60 * 60 * 24));
                this.hours = Math.floor(
                    (dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                );
                this.minutes = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                this.seconds = Math.floor((dist % (1000 * 60)) / 1000);
            },
            windowScroll() {
                const navbar = document.getElementById("navbar");
                if (
                    document.body.scrollTop >= 50 ||
                    document.documentElement.scrollTop >= 50
                ) {
                    navbar.classList.add("nav-sticky");
                } else {
                    navbar.classList.remove("nav-sticky");
                }
            },
            toggleMenu() {
                document.getElementById("topnav-menu-content").classList.toggle("show");
            },
            nextSlide() {
                this.$refs.carousel.goToPage(this.$refs.carousel.getNextPage());
            },
            prevSlide() {
                this.$refs.carousel.goToPage(this.$refs.carousel.getPreviousPage());
            }
        }
    };

</script>
