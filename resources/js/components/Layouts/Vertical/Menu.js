export const menuItems = [{
        id: 1,
        label: "menuitems.menu.text",
        isTitle: true,
        user: [],
    },
    {
        id: 2,
        label: "menuitems.dashboards.text",
        icon: "bx-home-circle",
        link: "/home",
        user: [],
    },
    {
        id: 3,
        label: "menuitems.users.text",
        icon: "bxs-user-circle",
        link: "/users",
        user: ['Super Administrator'],
    },
    {
        id: 4,
        label: "menuitems.schools.text",
        icon: "bxs-school",
        link: "/schools",
        user: ['Super Administrator'],
    },
    {
        id: 5,
        label: "menuitems.downloads.text",
        icon: "bx-cloud-download",
        link: "/downloads",
        user: ['Super Administrator'],
    },
    {
        id: 6,
        label: "menuitems.logs.text",
        icon: "bx-message-square-dots",
        link: "/logs",
        user: ['Super Administrator'],
    },

    {
        id: 20,
        label: "menuitems.qualifiers.text",
        icon: "bx-id-card",
        link: "/qualifier/lists",
        user: ['Scholarship Coordinator']
    },
    {
        id: 21,
        label: "menuitems.scholars.text",
        icon: "bx-group",
        link: "/scholars",
        user: ['Scholarship Coordinator', 'Regional Director'],
        links: [{
                link: "/import",
            },
            {
                link: "/reports",
            },
        ]
    },
    {
        id: 24,
        label: "menuitems.enrollments.text",
        icon: "bxs-folder-open",
        link: "/enrollments",
        user: ['Scholarship Coordinator']
    },
    // {
    //     id: 22,
    //     label: "menuitems.evaluations.text",
    //     icon: "bxs-folder-open",
    //     link: "/evaluations",
    //     user: ['Scholarship Coordinator']
    // },
    {
        id: 23,
        label: "menuitems.benefits.text",
        icon: "bx-credit-card-front",
        link: "/benefits",
        user: ['Scholarship Coordinator']
    },
    // {
    //     id: 30,
    //     label: "menuitems.accounting.text",
    //     icon: "bxs-wallet-alt ",
    //     user: ['Scholarship Coordinator'],
    //     subItems: [{
    //             id: 1,
    //             label: "menuitems.accounting.list.allotments",
    //             link: "/allotments",
    //             icon: "bxs-wallet",
    //             parentId: 30,
    //         },
    //         {
    //             id: 2,
    //             label: "menuitems.accounting.list.disbursements",
    //             link: "/disbursements",
    //             icon: "bx-wallet",
    //             parentId: 30,
    //         },
    //     ]
    // },

    {
        id: 33,
        label: "menuitems.insights.text",
        icon: "bx-line-chart",
        link: "/insights",
        user: ['Scholarship Coordinator', 'Regional Director']
    },

];