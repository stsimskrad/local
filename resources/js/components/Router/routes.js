const routes = [{
        path: '/home',
        component: () =>
            import ('../Views/Home.vue'),
        name: 'home',
        children: [{
                path: "profile",
                name: "profilee",
                component: () =>
                    import ('../Modules/Home/Scholar/Views/Profile.vue'),
            }, {
                path: "financial",
                name: "financial",
                component: () =>
                    import ('../Modules/Home/Scholar/Views/Financial.vue'),
            },
            {
                path: "enrollment",
                name: "enrollment",
                component: () =>
                    import ('../Modules/Home/Scholar/Views/Enrollment.vue'),
            },
            {
                path: "reimbursement",
                name: "reimbursement",
                component: () =>
                    import ('../Modules/Home/Scholar/Views/Reimbursement.vue'),
            },
        ]
    },
    {
        path: '/profile',
        component: () =>
            import ('../Views/Profile.vue'),
        name: 'profile'
    },

    {
        path: '/scholar/:id',
        component: () =>
            import ('../views/Scholars/Profile.vue'),
        name: 'scholar/profile',
        beforeEnter: coordinator,
        children: [{
                path: "profile",
                name: "profilee/view",
                component: () =>
                    import ('../Modules/Scholar/View/Profile/Index.vue'),
            }, {
                path: "financial",
                name: "financial/view",
                component: () =>
                    import ('../Modules/Scholar/View/Financial/Index.vue'),
            },
            {
                path: "trace",
                name: "trace/view",
                component: () =>
                    import ('../Modules/Scholar/View/Trace/Index.vue'),
            },
            {
                path: "enrollment",
                name: "enrollment/view",
                component: () =>
                    import ('../Modules/Scholar/View/Enrollment/Index.vue'),
            },
            {
                path: "prospectus",
                name: "prospectus/view",
                component: () =>
                    import ('../Modules/Scholar/View/Prospectus/Index.vue'),
            }
        ]
    },

    {
        path: '/users',
        component: () =>
            import ('../Views/Users/Index.vue'),
        name: 'users',
        beforeEnter: admin
    },
    {
        path: '/schools',
        component: () =>
            import ('../Views/Schools/Index.vue'),
        name: 'schools',
        beforeEnter: admin
    },
    {
        path: '/school/:id',
        component: () =>
            import ('../Views/Schools/Profile.vue'),
        name: 'school/profile',
        beforeEnter: admin
    },
    {
        path: '/Downloads',
        component: () =>
            import ('../Views/Download.vue'),
        name: 'downloads',
        beforeEnter: admin
    }, {
        path: '/logs',
        component: () =>
            import ('../Views/Users/Logs.vue'),
        name: 'logs',
        beforeEnter: admin
    },
    /////////////////////////////////////////
    /// S C H O O L  C O O R D I N A T O R///
    /////////////////////////////////////////
    {
        path: '/qualifier/lists',
        component: () =>
            import ('../Views/Qualifiers/Index.vue'),
        name: 'qualifier/lists',
        beforeEnter: coordinator
    },
    {
        path: '/qualifier/sync',
        component: () =>
            import ('../Views/Qualifiers/Sync.vue'),
        name: 'qualifier/sync',
        beforeEnter: coordinator
    },
    {
        path: '/qualifier/import',
        component: () =>
            import ('../Views/Qualifiers/Import.vue'),
        name: 'qualifier/import',
        beforeEnter: coordinator
    },
    {
        path: '/scholars',
        component: () =>
            import ('../Views/Scholars/Index.vue'),
        name: 'scholars',
        beforeEnter: two
    },
    {
        path: '/scholar/import',
        component: () =>
            import ('../Views/Scholars/Import.vue'),
        name: 'scholar/import',
        beforeEnter: coordinator
    },
    {
        path: '/scholar/create',
        component: () =>
            import ('../Views/Scholars/Create.vue'),
        name: 'scholar/create',
        beforeEnter: coordinator
    },
    {
        path: '/scholar/reports',
        component: () =>
            import ('../Views/Scholars/Report.vue'),
        name: 'scholar/reports',
        beforeEnter: two
    },
    {
        path: '/enrollments',
        component: () =>
            import ('../Views/Enrollment.vue'),
        name: 'enrollments',
        beforeEnter: coordinator
    },
    // {
    //     path: '/evaluations',
    //     component: () =>
    //         import ('../Views/Evaluation.vue'),
    //     name: 'evaluations',
    //     beforeEnter: coordinator
    // },
    {
        path: '/benefits',
        component: () =>
            import ('../Views/Benefit.vue'),
        name: 'evaluations',
        beforeEnter: coordinator
    },
    /////////////////////////////////////////
    /// A C C O U N T I N G///
    /////////////////////////////////////////
    {
        path: '/allotments',
        component: () =>
            import ('../Views/Accounting/Allotment.vue'),
        name: 'allotments',
        beforeEnter: coordinator
    },
    {
        path: '/allotment/:id',
        component: () =>
            import ('../Views/Accounting/AllotmentView.vue'),
        name: 'allotment/view',
        beforeEnter: coordinator,
    },
    {
        path: '/disbursements',
        component: () =>
            import ('../Views/Accounting/Disbursement.vue'),
        name: 'disbursements',
        beforeEnter: coordinator
    },

    /////////////////////////////////////////
    /// DIRECTOR ///
    /////////////////////////////////////////

    {
        path: '/insights',
        component: () =>
            import ('../Views/Insights.vue'),
        name: 'insights',
        beforeEnter: director
    },
];



function admin(to, from, next) {
    (window.User.role == "Super Administrator") ? next(true): next({
        path: '/home'
    });
}

function director(to, from, next) {
    (window.User.role == "Regional Director") ? next(true): next({
        path: '/home'
    });
}

function coordinator(to, from, next) {
    (window.User.role == "Scholarship Coordinator") ? next(true): next({
        path: '/home'
    });
}

function staff(to, from, next) {
    (window.User.role == "Scholarship Staff") ? next(true): next({
        path: '/home'
    });
}

function two(to, from, next) {
    (window.User.role == "Regional Director" || window.User.role == "Scholarship Coordinator") ? next(true): next({
        path: '/home'
    });
}

export default routes;