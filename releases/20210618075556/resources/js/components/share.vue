<template>
	<div>
		<div class="modal-body rounded-0 mt-0">
			<div class="form-group mb-4">
				<div class="row">
					<div class="col-7 col-md-9">
						<div class="input-group">
							<input type="text"
								class="form-control border-primary border-right-0 form-control-sm" aria-label="Text input with dropdown button"
								v-model="email"
								placeholder="Invite someone...">
							<div class="input-group-append">
								<button class="btn btn-sm btn-default dropdown-toggle border-primary border-left-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									{{ translate('can') }} {{action}}
								</button>
								<div class="dropdown-menu">
									<span class="dropdown-item" @click="action='view'">
										{{ translate('can view') }}
									</span>
									<span v-if="can_edit" class="dropdown-item" @click="action='edit'">
										{{ translate('can edit') }}
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-5 col-md-3">
						<button class="btn btn-secondary btn-sm" @click="invite"><i v-if="invite_loading" class="fas fa-spinner fa-spin"></i>
						{{ translate('Send Invite') }}
						</button>
					</div>
				</div>
			</div>
			<div class="users">
				<div class="user" v-for="(share, index) in shares">
					<div class="row align-items-center mb-2">
						<div class="col-1-">
							<img :src="share.user.avatar" v-if="share.user!=undefined" class="img-fluid rounded-circle" style="height: 30px; width: 30px;">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAMAAAAM7l6QAAAAqFBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAVFRUODg4YGBgWFhYUFBQeHh4dHR0jIyMiIiIoKCgsLCwxMTE7Ozs9PT1QUFBRUVFXV1dkZGRnZ2dsbGx7e3t+fn6RkZGSkpKUlJSVlZWXl5eYmJiampqenp6jo6OlpaWnp6e0tLS5ubm6urrCwsLDw8PFxcXGxsbGxsbHx8fJycnJycnJycnKysrMzMzMzMwx5bRlAAAAN3RSTlMAAQQFCAkKCwwSFRcaIiMkJi0uNEFHXF5kdXmAk5ausLKytre5vsTKy9zi5e/x9fX2+Pj5+vv+zkPLPAAAAKBJREFUeNq90NcSgjAUhOGo2HvDLvbeo5z3fzMZAjkZ2XDpf/td7MyKv9U8vG7zok23FDbCuqEoF2mLdBnAJ+YxYOIuSc2TUZLL6ewY6qdvXwF/mD3Aa+Yu4DqzQN1jnUKuRfoQuIXitoVnigsWPiruYXXjz6pIl6Qb/lpnRWZyUmHL7Qi0LyltkKV+yD7ZygY6QMDvnu0sA36GSaO3zvkCLB5NV0m+BIEAAAAASUVORK5CYII=" v-else class="img-fluid rounded-circle" style="height: 30px; width: 30px;">
						</div>
						<div class="col-6 col-md-8">
							<div  v-if="share.user!=undefined">{{share.user.name}}</div>
							<div v-else>
								{{share.user_email}} {{ translate('(invited)') }}
							</div>
						</div>
						<div class="col-3">
							<button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span v-if="!share.loading">can {{share.action}}</span><i class="fas fa-spinner fa-spin" v-else></i></button>
								<div class="dropdown-menu">
									<span class="dropdown-item" @click="editAction('view', share.user_id, index)">
										{{ translate('can view') }}
									</span>
									<span v-if="can_edit" class="dropdown-item" @click="editAction('edit', share.user_id, index)">
										{{ translate('can edit') }}
									</span>
									<span v-if="user_id==owner_id" class="dropdown-item" @click="deleteShare(share.user_id, index)">
										{{ translate('remove') }}
									</span>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer justify-content-center" v-if="false">
			<span class="btn btn-link" @click="getLink" v-if="link==''">
				<i v-if="!link_loading" class="fas fa-link"></i><i v-else class="fas fa-spinner fa-spin"></i>
				{{ translate('Copy link') }}
				</span>
			<span class="text-muted" v-else><i class="fas fa-link"></i>
			{{ translate('Copied link') }}
			</span>
			<span class="d-none btn btn-link" @click="getCode" v-if="code==''"><i v-if="!code_loading" class="fas fa-code"></i><i v-else class="fas fa-spinner fa-spin"></i>
			{{ translate('Get embed code') }}
			</span>
			<span class="text-muted" v-else><i class="fas fa-code"></i>
			{{ translate('Copied code') }}
			</span>
		</div>
	</div>
</template>
<script>
	import copy from 'copy-to-clipboard'
	import translate from "../utils/translate";
	export default {
		data(){
			return {
				shares: {},
				action: 'view',
				email: '',
				id: 0,
				user_id: 0,
				owner_id: 0,
				link: '',
				code: '',
				link_loading: false,
				code_loading: false,
				invite_loading: false,
                can_edit: false
			}
		},
		methods: {
			translate,
			invite(){
				this.invite_loading = true
				axios.post(endpoints.ajax.post.brandbook.shares_add, {id: this.id, email: this.email, action: this.action}).
				then(response=>{
					this.invite_loading=false
					this.load(this.id)
				})
                this.$root.$emit('book-shared', {id : this.id});
			},
			editAction(action, user_id, index){
				this.shares[index].loading = true
				axios.post(endpoints.ajax.post.brandbook.shares_edit, {id: this.id, user_id: user_id, action: action}).
				then(response=>{
					this.load(this.id)
				})
			},
			deleteShare(user_id, index){
				this.shares[index].loading = true
				axios.post(endpoints.ajax.post.brandbook.shares_delete, {id: this.id, user_id: user_id}).
				then(response=>{
					this.load(this.id)
				})
			},
			load(id){
				this.id = id
				axios.post(endpoints.ajax.post.brandbook.shares, {id: id}).
				then(response=>{
					this.shares = response.data.shares
					this.user_id = response.data.user_id
					this.owner_id = response.data.owner_id
                    this.can_edit = response.data.can_edit
				})
			},
			getLink(){
				this.link_loading=true
				axios.post(endpoints.ajax.post.brandbook.shares_link, {id: this.id}).
				then(response=>{
					this.link = response.data
					copy(this.link)
					this.link_loading=false
				})
                this.$root.$emit('book-shared', {id : this.id});
			},
			getCode(){
				this.code_loading = true
				axios.post(endpoints.ajax.post.brandbook.shares_code, {id: this.id}).
				then(response=>{
					this.code_loading = false
					this.code = response.data
					copy(this.code)
				})
			}
		},
		mounted(){
			this.$root.$on('share', (data)=>{
			    console.log(data.id);
				this.load(data.id)
			})
		}
	}
</script>
