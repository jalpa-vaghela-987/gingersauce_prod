import NewBrandbook from './components/NewBrandbook.vue'
import PreviewBrandbook from './components/preview.vue'
import EditBrandbook from './components/edit.vue'

export const routes = [
    { path: '/my/new', component: NewBrandbook, name: 'New' },
    { path: '/my/view/:id', component: PreviewBrandbook, name: 'Preview' },
    { path: '/my/edit/:id', component: EditBrandbook, name: 'Edit' },
    { path: '/my/resume/:id', component: NewBrandbook, name: 'Resume' },
    { path: '/my/wizard/:id/:page?', component: NewBrandbook, name: 'Wizard' },
];
