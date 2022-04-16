<script>
import HorizontalTopbar from "../Layouts/Horizontal/Topbar.vue";
import HorizontalNav from "../Layouts/Horizontal/Navigation.vue";
import RightBar from "../Layouts/Horizontal/Rightbar.vue";
import Footer from "../Layouts/Horizontal/Footer.vue";

/**
 * Horizontal-layout
 */
export default {
    props: ['user'],
    components: {
        HorizontalTopbar,
        HorizontalNav,
        Footer,
        RightBar
    },
    data() {
        return {};
    },
    created: () => {
        document.body.setAttribute("data-layout", "horizontal");
        // document.body.setAttribute("data-topbar", "dark");
        document.body.removeAttribute("data-sidebar", "dark");
        document.body.removeAttribute("data-layout-size", "boxed");
    },
    mounted() {
        const layout = JSON.parse(localStorage.getItem("layout")) || {};
        if (layout.loader == true) {
            document.getElementById("preloader").style.display = "block";
            document.getElementById("status").style.display = "block";

            setTimeout(function() {
                document.getElementById("preloader").style.display = "none";
                document.getElementById("status").style.display = "none";
            }, 2500);
        } else {
            document.getElementById("preloader").style.display = "none";
            document.getElementById("status").style.display = "none";
        }
    },
    methods: {
        toggleRightSidebar() {
            document.body.classList.toggle("right-bar-enabled");
        },
        hideRightSidebar() {
            document.body.classList.remove("right-bar-enabled");
        }
    }
};
</script>

<template>
    <div>
        <div id="preloader">
            <div id="status">
                <div class="spinner-chase">
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                </div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="layout-wrapper">
            <HorizontalTopbar :user="user"/>
            <!-- <HorizontalNav :user="user"/> -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content" style="margin-top: -40px;">
                <div class="page-content">
                    <div class="account-pages px-4">
                        <!-- account-pages p-4  || container-fluid-->
                        <slot />
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <!-- <Footer /> -->
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <RightBar />
    </div>
</template>
