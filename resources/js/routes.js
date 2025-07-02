import NewBrandbook from './components/NewBrandbook.vue'
import PreviewBrandbook from './components/preview.vue'
import PreviewNewBrandbook from './components/preview-new.vue'
import PreviewNewBrandbookV3 from './components/preview-new-v3.vue'
import EditBrandbook from './components/edit.vue'
import EditBrandbooknew from './components/edit-new.vue'
import AuthorDashboard from './components/AuthorDashboard.vue'

export const routes = [
    { path: '/my/new', component: NewBrandbook, name: 'New', meta: { authRequired: true } },
    { path: '/my/edit/:id', component: EditBrandbook, name: 'Edit', meta: { authRequired: true } },
    { path: '/my/edit-new/:id', component: EditBrandbooknew, name: 'EditNew', meta: { authRequired: true } },
    { path: '/my/resume/:id', component: NewBrandbook, name: 'Resume', meta: { authRequired: true } },
    { path: '/my/wizard/:id/:page?', component: NewBrandbook, name: 'Wizard',meta: { authRequired: true } },
    { path: '/my/view/:id', component: PreviewBrandbook, name: 'Preview',meta: { authRequired: false } },
    { path: '/my/view-new/:id', component: PreviewNewBrandbook, name: 'PreviewNew',meta: { authRequired: false } },
    { path: '/my/view-new-v3/:id', component: PreviewNewBrandbookV3, name: 'PreviewNewV3' },
    { path: '/my/author-dashboard', component: AuthorDashboard, name: 'authorDashboard',meta: { authRequired: false } },
];
