const routes = [{
    path: '/home',
    component: () =>
        import ('../Views/Home.vue'),
    name: 'home',
}, {
    path: '/profile',
    component: () =>
        import ('../Views/Profile.vue'),
    name: 'profile',
}, {
    path: '/users',
    component: () =>
        import ('../Views/Users/Index.vue'),
    name: 'users',
    beforeEnter: admin
}, {
    path: '/logs',
    component: () =>
        import ('../Views/Users/Logs.vue'),
    name: 'logs',
    beforeEnter: admin
}];



function admin(to, from, next) {
    (window.User.role == "Super Administrator") ? next(true): next({
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

export default routes;