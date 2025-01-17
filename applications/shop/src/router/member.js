const MemberRoute = [
    {
        
        path: '/register',
        name: 'register',
        component: () => import('@/views/member/RegisterView.vue')
        
    },
    {
        path: '/login',
        name: 'login',
        // route level code-splitting
        // this generates a separate chunk (About.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import('@/views/member/LoginView.vue')
    },
    
]

export default MemberRoute




  