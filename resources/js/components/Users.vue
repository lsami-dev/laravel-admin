<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users List</h3>
                        <div class="card-tools">
                            <b-button class="btn btn-success" @click="createUserModal()">
                                Add New <i class="fa fa-user-plus"></i>
                            </b-button>

                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registred At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.role | capitalize }}</td>
                                    <td>{{ user.created_at | formatDate }}</td>
                                    <td>
                                        <a href="#" @click="editUserModal(user)">
                                            <i class="fa fa-pen">

                                            </i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteUser(user.id)">
                                            <i class="fa fa-trash text-red">

                                            </i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
        <!-- User creation Modal  -->
        <b-modal hide-backdrop id="userModal" :title="editMode ? 'Edit User' : 'Add New User'" :hide-footer="true">


            <form @submit.prevent="editMode ? updateUser() : createUser()">


                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" v-model="form.name" type="text" name="name" class="form-control">
                    <HasError :form="form" field="name" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail Address</label>
                    <input id="email" v-model="form.email" type="text" name="email" class="form-control">
                    <HasError :form="form" field="email" />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" v-model="form.password" type="password" name="password" class="form-control">
                    <HasError :form="form" field="password" />
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" v-model="form.role" type="role" name="role" class="form-control">
                        <option value="">Select</option>
                        <option value="basic">Basic</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                    <HasError :form="form" field="role" />
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">Profile Picture</label>
                    <input id="avatar" type="file" name="avatar" class="form-control">
                    <HasError :form="form" field="avatar" />
                </div>

                <button type="submit" class="btn btn-success float-right">
                    {{ editMode ? 'Save changes' : 'Add new User' }}
                    <i :class="[editMode ? 'fa fa-user-pen' : 'fa fa-user-plus']"></i>
                </button>

            </form>


        </b-modal>

    </div>
</template>

<script>
export default {
    data() {
        return {
            editMode: true,
            users: {},
            form: new From({
                id: '',
                name: '',
                email: '',
                password: '',
                role: '',
                avatar: ''
            })
        }
    },
    methods: {
        createUserModal() {
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            this.$root.$emit('bv::show::modal', 'userModal');

        },
        editUserModal(user) {
            this.editMode = true;
            this.form.clear();
            this.form.reset();
            this.$root.$emit('bv::show::modal', 'userModal');
            this.form.fill(user);
        },
        getAllUsers() {
            axios.get('api/user').then(({ data }) => (this.users = data.data));
        },
        createUser() {
            this.$Progress.start();
            this.form.post('/api/user')
                .then(() => {
                    this.$root.$emit('bv::hide::modal', 'userModal');
                    toast.fire({
                        icon: 'success',
                        title: 'User created successfully'
                    });
                    this.$Progress.finish();
                    EventHandler.$emit('tableUpdate');
                }
                )
                .catch(() => {
                    this.$Progress.fail();
                });

        },
        updateUser() {
            this.$Progress.start();
            this.form.put('api/user/' + this.form.id)
                .then(() => {
                    this.$root.$emit('bv::hide::modal', 'userModal');
                    toast.fire({
                        icon: 'success',
                        title: 'User updated successfully'
                    });
                    this.$Progress.finish();
                    EventHandler.$emit('tableUpdate');
                })
                .catch(() => {
                    this.$Progress.fail();

                });
        },
        deleteUser(userId) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$Progress.start();
                    this.form.delete('api/user/' + userId)
                        .then(() => {
                            swal.fire(
                                'Deleted!',
                                'The user has been deleted !',
                                'success'
                            );
                            this.$Progress.finish();
                            EventHandler.$emit('tableUpdate');
                        })
                        .catch(() => {
                            this.$Progress.fail();
                            swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'User cannot be deleted !',
                            })
                        });
                }
            })

        }
    },
    created() {
        this.getAllUsers();
        EventHandler.$on('tableUpdate', () => {
            this.getAllUsers();
        });
    }
}
</script>